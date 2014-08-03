<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');

    $import = get_import($params->dataset, $params->import);
    $cols = get_cols($import);
    $values = get_values($import);

    $rows = new RowIterator($values);

    switch($format) {
    case 'csv':
      dump_csv($cols, $rows);
      exit;
    case 'json':
      dump_json($cols, $values);
      exit;
    case 'xml':
      dump_xml($cols, $values);
      exit;
    case 'n3':
      dump_n3($cols, $values);
      exit;
    default:
      $response->setParameter('params', $params);
      $response->setParameter('import', $import);
      $response->setParameter('cols', $cols);
      $response->setParameter('rows', $rows);
      $response->setTemplate('report');
      break;
    }

  }

}