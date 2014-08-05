<?php

/**
 * Controller for dataset landing page.
 */
class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');

    // Latest import for the dataset if not specified
    $import = get_import($params->dataset, $params->import);

    $cols = get_cols($import);

    $row_count = $this->doQuery(
      'select count(distinct row) from value_view where import=?',
      $import->import
    )->fetchColumn();

    $response->setParameter('params', $params);
    $response->setParameter('import', $import);
    $response->setParameter('cols', $cols);
    $response->setParameter('row_count', $row_count);
    $response->setTemplate('dataset');
  }

}
