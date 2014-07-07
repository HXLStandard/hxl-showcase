<?php

class CodeController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $code_code = $request->get('code');
    $code = $this->doQuery('select * from code where code=?', $code_code)->fetch();
    $datasets = $this->doQuery('select distinct D.* from dataset_view D join import I on D.id=I.dataset join col C on I.id=C.import join code CD on C.code=CD.id where CD.code=?', $code_code);
    $dataset_count = $this->doQuery('select count(distinct D.*) from dataset_view D join import I on D.id=I.dataset join col C on I.id=C.import join code CD on C.code=CD.id where CD.code=?', $code_code)->fetchColumn();;

    $response->setParameter('code', $code);
    $response->setParameter('datasets', $datasets);
    $response->setParameter('dataset_count', $dataset_count);
    $response->setTemplate('code');
  }

}