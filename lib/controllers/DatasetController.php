<?php

class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source_param = $request->get('source');
    $dataset_param = $request->get('dataset');
    $format = $request->get('format');

    // Latest import for the dataset
    $import = $this->doQuery(
      'select I.* from import_view I' .
      ' join latest_import_view LI using(import) ' .
      ' where I.source=? and I.dataset=?',
      $source_param, $dataset_param
    )->fetch();

    // Columns for the import
    $cols = $this->doQuery(
      'select C.* from col_view C ' .
      'where import=? ' .
      'order by C.col',
      $import->import
    )->fetchAll();

    // Values for the import
    $values = $this->doQuery(
      'select value.* from value ' .
      'join col using(col) ' .
      'where import=? ' .
      'order by row, col',
      $import->import
    );

    if ($format == 'csv') {

      header('Content-type: text/csv;charset=utf-8');
      dump_csv($cols, $values);
      exit;

    } else {

      $response->setParameter('cols', $cols);
      $response->setParameter('values', $values);
      $response->setParameter('import', $import);
      $response->setTemplate('dataset');
    }
  }

}
