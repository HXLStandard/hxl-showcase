<?php

class SourceController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $source = $this->doQuery('select * from source where ident=?', $request->get('source'))->fetch();
    $datasets = $this->doQuery('select * from dataset_view where source=?', $source->id);

    $response->setParameter('source', $source);
    $response->setParameter('datasets', $datasets);
    $response->setTemplate('source');
  }

}