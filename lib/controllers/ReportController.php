<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $cols = $request->get('cols');

    $col_list = explode(',', $cols);

    // We need a list of code objects in the order provided by the user
    $code_query = sprintf('select * from code where code in (%s)', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $code_query);
    $codes = call_user_method_array('doQuery', $this, $params);
    foreach ($codes as $code) {
      $code_map[$code->code] = $code;
    }
    $codes = array();
    foreach ($col_list as $col_code) {
      array_push($codes, $code_map[$col_code]);
    }

    // Now we need a list of matching values
    $value_query = sprintf('select V.* from value_view V where V.code_code in (%s) order by V.row, V.col', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $value_query);
    $values = call_user_method_array('doQuery', $this, $params);

    $response->setParameter('codes', $codes);
    $response->setParameter('values', $values);
    $response->setTemplate('report');
  }

}