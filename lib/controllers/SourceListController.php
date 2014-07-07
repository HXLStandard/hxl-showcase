<?php

class SourceListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $sources = $this->doQuery('select * from source order by ident');

    $response->setParameter('sources', $sources);
    $response->setTemplate('source-list');
  }

}