<?php

class CodeListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $codes = $this->doQuery(
      'select C.*, CNT.col_count from code_view C ' .
      'left join (select code, count(*) col_count ' .
      'from col group by code) CNT on C.id=CNT.code ' .
      'order by C.code'
    );

    $response->setParameter('codes', $codes);
    $response->setTemplate('code-list');
  }

}