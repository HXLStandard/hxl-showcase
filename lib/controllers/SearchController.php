<?php

class SearchController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // HTTP GET parameters
    $q = $request->get('q');
    $source_ident = $request->get('source');
    $tag = $request->get('tag');
    $user_ident = $request->get('user');

    // Clean up query string to match search syntax
    // TODO - figure out how to make more Google-like
    $q = preg_replace("/[^a-zA-Z0-9]+/", "+", $q);
    $q = preg_replace("/^\\++/", "", $q);
    $q = preg_replace("/\\++$/", "", $q);

    // Options for select lists
    $tags = $this->doQuery('select * from tag order by tag');
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

    if ($tag) {
      array_push($params, $tag);
      $frag .= " and V.tag=?";
    }

    if ($user_ident) {
      array_push($params, $user_ident);
      $frag .= " and V.usr_ident=?";
    }

    // Crazy grouping statement to get aggregate totals for datasets
    $sql = "select V.source_ident, V.source_name, " .
      "V.dataset_ident, V.dataset_name, " .
      "V.tag, V.tag_name, " .
      "V.value, V.usr_ident, V.usr_name, " .
      "count(V.id) as row_count " .
      $frag . ' ' .
      "group by V.source_ident, V.source_name, " .
      "V.dataset_ident, V.dataset_name, " .
      "V.tag, V.tag_name, " .
      "V.value, V.usr_ident, V.usr_name " .
      "order by row_count desc";
    array_unshift($params, $sql);
    $values = call_user_method_array('doQuery', $this, $params);

    array_shift($params);
    array_unshift($params, "select count(V.*) $frag");
    $result_count = call_user_method_array('doQuery', $this, $params)->fetchColumn();

    // Set up the template parameters
    $response->setParameter('q', $q);

    $response->setParameter('tags', $tags);
    $response->setParameter('sources', $sources);
    $response->setParameter('users', $users);

    $response->setParameter('source_ident', $source_ident);
    $response->setParameter('tag', $tag);
    $response->setParameter('user_ident', $user_ident);
    $response->setParameter('values', $values);
    $response->setParameter('result_count', $result_count);

    $response->setTemplate('search');
  }

}