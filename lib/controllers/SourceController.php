<?php

class SourceController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source = $this->doQuery('select * from source where ident=?', $request->get('source'))->fetch();

    $uploads = $this->doQuery(
      'select max(stamp) as stamp, dataset_ident, dataset_name, source_ident, source_name, usr_ident, usr_name, count(distinct row) as row_count ' .
      'from value_view ' .
      'where source=? ' .
      'group by dataset_ident, dataset_name, source_ident, source_name, usr_ident, usr_name ',
      $source->id);

    $response->setParameter('source', $source);
    $response->setParameter('uploads', $uploads);
    $response->setTemplate('source');
  }

}