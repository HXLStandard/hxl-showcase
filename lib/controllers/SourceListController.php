<?php

class SourceListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $statement = $this->doQuery('select * from source order by ident');

    $sources = $statement->fetchAll();
    $response->setParameter('sources', $sources);
    $response->setTemplate('source-list');
  }

}