<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $cols_raw = $request->get('cols');

    $col_list = explode(',', $cols_raw);

    // We need a list of code objects in the order provided by the user
    $col_query = sprintf('select * from code where code in (%s)', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $col_query);
    $cols = call_user_method_array('doQuery', $this, $params);
    foreach ($cols as $col) {
      $col_map[$col->code] = $col;
    }
    $cols = array();
    foreach ($col_list as $col_code) {
      array_push($cols, $col_map[$col_code]);
    }

    // Now we need a list of matching values
    $value_query = sprintf('select V.* from value_view V where V.code_code in (%s) order by V.row, V.col', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $value_query);
    $values = call_user_method_array('doQuery', $this, $params);

    $response->setParameter('cols', $cols);
    $response->setParameter('values', $values);
    $response->setTemplate('report');
  }

}