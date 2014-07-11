<?php

class ImportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $source = $request->get('source');
    $dataset = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');

    $import = $this->doQuery('select * from import_view ' .
                             'where source_ident=? and dataset_ident=? and stamp=? ' .
                             'order by stamp desc',
                             $source, $dataset, $stamp)->fetch();

    $cols = $this->doQuery('select * from col_view where import=? order by id', $import->id)->fetchAll();
    $values = $this->doQuery('select * from value_view where import=? order by row, col', $import->id);

    if ($format == 'csv') {
      header('Content-type: text/csv;charset=utf-8');
      dump_csv($cols, $values, fopen('php://output', 'w'));
      exit;
    } else {
      $response->setParameter('import', $import);
      $response->setParameter('cols', $cols);
      $response->setParameter('values', $values);
      $response->setTemplate('import');
    }
  }

}