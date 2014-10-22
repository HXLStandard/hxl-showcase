<?php

/**
 * Generate a tabular data report.
 *
 * @param dataset - the dataset ID to show
 * @param import - the import timestamp to show (defaults to the latest import)
 * @param (any HXL tag) - a filter for the data
 */
class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->tag = $request->get('tag'); // not used, but passed on to links
    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');

    $import = get_import($params->dataset, $params->import);

    list($filter_fragment, $filters) = process_filters($request, $import->import, get_tags());

    $cols = get_cols($import);
    $rows = get_rows($cols, $filter_fragment);

    $total_count = get_row_count($import);
    $filtered_count = get_row_count_filtered($filter_fragment);

    switch($format) {
    case 'csv':
      dump_csv($cols, $rows);
      exit;
    case 'json':
      dump_json($cols, $rows);
      exit;
    case 'xml':
      dump_xml($cols, $rows);
      exit;
    case 'n3':
      dump_n3($cols, $rows);
      exit;
    default:
      $filter_tags = get_filter_tags($params->tag, $filters, get_cols($import));
      sort($filter_tags);
      $response->setParameter('params', $params);
      $response->setParameter('filters', $filters);
      $response->setParameter('filter_tags', $filter_tags);
      $response->setParameter('import', $import);
      $response->setParameter('cols', $cols);
      $response->setParameter('rows', $rows);
      $response->setParameter('filtered_count', $filtered_count);
      $response->setParameter('total_count', $total_count);
      $response->setTemplate('report');
      break;
    }

  }

}