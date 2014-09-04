<?php

/**
 * Controller to select a tag as a filter.
 */
class FilterController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $params->filter_tag = $request->get('filter_tag'); // tag on which to filter
    $params->tag = $request->get('tag'); // tag being viewed
    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');
    $params->type = $request->get('type'); // type (stats or data)

    $import = get_import($params->dataset, $params->import);

    $filter_tag = get_tag($params->filter_tag);

    list($filter_fragment, $filters) = process_filters($request, $import->import, get_tags());

    $options = do_query(
      'select norm as content, count(distinct row) as count' .
      ' from value_view' .
      ' where tag=? and row in ' . $filter_fragment .
      ' group by norm' .
      ' order by norm',
      $params->filter_tag
    );

    $response->setParameter('params', $params);
    $response->setParameter('filter_tag', $filter_tag);
    $response->setParameter('filters', $filters);
    $response->setParameter('import', $import);
    $response->setParameter('options', $options);
    $response->setTemplate('filter');
  }

}