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
    $sources = $this->doQuery('select * from source order by source');
    $users = $this->doQuery('select * from usr order by usr');

    //
    // Construct the search query incrementally, depending on what facets
    // the user has specified
    //
    $params = array($q);
    $frag = "from search_view join latest_import_view LI using(import) where to_tsvector('english', content) @@ to_tsquery('english', ?)";

    if ($source_ident) {
      array_push($params, $source_ident);
      $frag .= " and source=?";
    }

    if ($tag) {
      array_push($params, $tag);
      $frag .= " and tag=?";
    }

    if ($user_ident) {
      array_push($params, $user_ident);
      $frag .= " and usr=?";
    }

    // Crazy grouping statement to get aggregate totals for datasets
    $sql = "select source, source_name, " .
      "dataset, dataset_name, " .
      "tag, " .
      "content, usr, " .
      "count(id) as row_count " .
      $frag . ' ' .
      "group by source, source_name, " .
      "dataset, dataset_name, " .
      "tag, " .
      "content, usr " .
      "order by row_count desc";
    array_unshift($params, $sql);
    $values = call_user_method_array('doQuery', $this, $params);

    array_shift($params);
    array_unshift($params, "select count(*) $frag");
    $result_count = call_user_method_array('doQuery', $this, $params)->fetchColumn();

    // Set up the template parameters
    $response->setParameter('q', $q);

    $response->setParameter('tags', $tags);
    $response->setParameter('sources', $sources);
    $response->setParameter('users', $users);

    $response->setParameter('source_ident', $source_ident);
    $response->setParameter('tag_ident', $tag);
    $response->setParameter('user_ident', $user_ident);
    $response->setParameter('values', $values);
    $response->setParameter('result_count', $result_count);

    $response->setTemplate('search');
  }

}