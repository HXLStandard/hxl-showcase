<?php

/**
 * Controller for dataset landing page.
 *
 * @param dataset - the identifier of the dataset to show.
 * @param import - the timestamp of the import to show (defaults to
 * the latest import if not specified).
 */
class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');

    // Latest import for the dataset if not specified
    $import = get_import($params->dataset, $params->import);

    list($filter_fragment, $filters) = process_filters($request, $import->import, get_tags());

    $cols = get_cols($import);

    $row_count = $this->doQuery(
      'select count(distinct row) from value_view where import=?',
      $import->import
    )->fetchColumn();

    if ($filters) {
      $filtered_row_count = $this->doQuery(
        'select count(distinct row) from value_view where row in ' . $filter_fragment
      )->fetchColumn();
    }

    $response->setParameter('params', $params);
    $response->setParameter('filters', $filters);
    $response->setParameter('import', $import);
    $response->setParameter('cols', $cols);
    $response->setParameter('filtered_row_count', $filtered_row_count);
    $response->setParameter('row_count', $row_count);
    $response->setTemplate('dataset');
  }

}
