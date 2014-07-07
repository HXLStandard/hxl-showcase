<?php

class SearchController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $q = $request->get('q');
    $source_ident = $request->get('source');
    $code_code = $request->get('code');
    $user_ident = $request->get('user');

    // Values for select lists
    $codes = $this->doQuery('select * from code order by code');
    $sources = $this->doQuery('select * from source order by ident');
    $users = $this->doQuery('select * from usr order by ident');

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

    array_unshift($params, "select V.* $frag");
    $values = call_user_method_array('doQuery', $this, $params);

    array_shift($params);
    array_unshift($params, "select count(V.*) $frag");
    $result_count = call_user_method_array('doQuery', $this, $params)->fetchColumn();

    $response->setParameter('codes', $codes);
    $response->setParameter('sources', $sources);
    $response->setParameter('users', $users);

    $response->setParameter('q', $q);
    $response->setParameter('source_ident', $source_ident);
    $response->setParameter('code_code', $code_code);
    $response->setParameter('user_ident', $user_ident);
    $response->setParameter('values', $values);
    $response->setParameter('result_count', $result_count);
    $response->setTemplate('search');
  }

}