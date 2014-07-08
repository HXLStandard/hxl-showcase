<?php

class SearchController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // HTTP GET parameters
    $q = $request->get('q');
    $source_ident = $request->get('source');
    $code_code = $request->get('code');
    $user_ident = $request->get('user');

    // Clean up query string to match search syntax
    // TODO - figure out how to make more Google-like
    $q = preg_replace("/[^a-zA-Z0-9]+/", "+", $q);
    $q = preg_replace("/^\\++/", "", $q);
    $q = preg_replace("/\\++$/", "", $q);

    // Options for select lists
    $codes = $this->doQuery('select * from code order by code');
    $sources = $this->doQuery('select * from source order by ident');
    $users = $this->doQuery('select * from usr order by ident');

    //
    // Construct the search query incrementally, depending on what facets
    // the user has specified
    //
    $params = array($q);
    $frag = "from value_view V join latest_import_view LI on V.import=LI.id where to_tsvector('english', V.value) @@ to_tsquery('english', ?)";

    if ($source_ident) {
      array_push($params, $source_ident);
      $frag .= " and V.source_ident=?";
    }

    if ($code_code) {
      array_push($params, $code_code);
      $frag .= " and V.code_code=?";
    }

    if ($user_ident) {
      array_push($params, $user_ident);
      $frag .= " and V.usr_ident=?";
    }

    // Crazy grouping statement to get aggregate totals for datasets
    $sql = "select V.source_ident, V.source_name, " .
      "V.dataset_ident, V.dataset_name, " .
      "V.code_code, V.code_name, " .
      "V.value, V.usr_ident, V.usr_name, " .
      "count(V.id) as row_count " .
      $frag . ' ' .
      "group by V.source_ident, V.source_name, " .
      "V.dataset_ident, V.dataset_name, " .
      "V.code_code, V.code_name, " .
      "V.value, V.usr_ident, V.usr_name " .
      "order by row_count desc";
    array_unshift($params, $sql);
    $values = call_user_method_array('doQuery', $this, $params);

    array_shift($params);
    array_unshift($params, "select count(V.*) $frag");
    $result_count = call_user_method_array('doQuery', $this, $params)->fetchColumn();

    // Set up the template parameters
    $response->setParameter('q', $q);

    $response->setParameter('codes', $codes);
    $response->setParameter('sources', $sources);
    $response->setParameter('users', $users);

    $response->setParameter('source_ident', $source_ident);
    $response->setParameter('code_code', $code_code);
    $response->setParameter('user_ident', $user_ident);
    $response->setParameter('values', $values);
    $response->setParameter('result_count', $result_count);

    $response->setTemplate('search');
  }

}