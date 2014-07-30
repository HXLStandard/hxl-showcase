<?php

class ReportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $cols_raw = $request->get('cols');

    $col_list = explode(',', $cols_raw);

    // We need a list of tag objects in the order provided by the user
    $col_query = sprintf('select * from tag where tag in (%s)', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $col_query);
    $cols = call_user_method_array('doQuery', $this, $params);
    foreach ($cols as $col) {
      $col_map[$col->tag] = $col;
    }
    $cols = array();
    foreach ($col_list as $col_tag) {
      array_push($cols, $col_map[$col_tag]);
    }

    // Now we need a list of matching values
    $value_query = sprintf('select V.* from value_view V join latest_import_view LI on V.import=LI.id where V.tag in (%s) order by V.row, V.col', implode(',', array_fill(0, count($col_list), '?')));
    $params = $col_list;
    array_unshift($params, $value_query);
    $values = call_user_method_array('doQuery', $this, $params);

    $response->setParameter('cols', $cols);
    $response->setParameter('values', $values);
    $response->setTemplate('report');
  }

}