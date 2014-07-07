<?php

class CodeListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $codes = $this->doQuery('select * from code order by code');

    $response->setParameter('codes', $codes);
    $response->setTemplate('code-list');
  }

}