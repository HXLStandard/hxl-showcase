<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');

    $import = get_import($params->dataset, $params->import);
    $cols = get_cols($import);
    $rows = get_rows($import);

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
      $response->setParameter('params', $params);
      $response->setParameter('import', $import);
      $response->setParameter('cols', $cols);
      $response->setParameter('rows', $rows);
      $response->setTemplate('report');
      break;
    }

  }

}