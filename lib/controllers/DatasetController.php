<?php

class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $format = $request->get('format');

    // Latest import for the dataset
    $import = $this->doQuery(
      'select I.* from import_view I ' .
      'join latest_import_view LI on I.id=LI.id ' .
      'where I.source_ident=? and I.dataset_ident=?',
      $source_ident, $dataset_ident
    )->fetch();

    // Columns for the import
    $cols = $this->doQuery(
      'select C.* from col_view C ' .
      'where import=? ' .
      'order by C.col',
      $import->id
    )->fetchAll();

    // Values for the import
    $values = $this->doQuery(
      'select V.* from value_view V ' .
      'where import=? ' .
      'order by row, col',
      $import->id
    );

    if ($format == 'csv') {

      header('Content-type: text/csv;charset=utf-8');
      dump_csv($cols, $values, fopen('php://output', 'w'));
      exit;

    } else {

      $response->setParameter('cols', $cols);
      $response->setParameter('values', $values);
      $response->setParameter('import', $import);
      $response->setTemplate('dataset');
    }
  }

}
