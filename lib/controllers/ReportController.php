<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->dataset = $request->get('dataset');
    $params->stamp = $request->get('stamp');

    $import = get_import($params->dataset, $params->stamp);
    $cols = get_cols($import);
    $values = get_values($import);

    switch($format) {
    case 'csv':
      dump_csv($cols, $values);
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
      $response->setParameter('values', $values);
      $response->setTemplate('report');
      break;
    }

  }

}