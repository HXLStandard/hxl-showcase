<?php

class SourceListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $sources = $this->doQuery('select S.*, CNT.dataset_count from source S join (select source, count(*) as dataset_count from dataset group by source) CNT on S.id=CNT.source order by S.ident');

    $response->setParameter('sources', $sources);
    $response->setTemplate('source-list');
  }

}