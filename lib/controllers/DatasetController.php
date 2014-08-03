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

    $row_count = $this->doQuery(
      'select count(distinct row) from value_view where import=?',
      $import->import
    )->fetchColumn();

    $response->setParameter('import', $import);
    $response->setParameter('row_count', $row_count);
    $response->setTemplate('dataset');
  }

}
