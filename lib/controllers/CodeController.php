<?php

class CodeController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $code_code = $request->get('code');
    $code = $this->doQuery('select * from code where code=?', $code_code)->fetch();

    $frag = "from import_view I join col C on I.id=C.import join code CD on C.code=CD.id join (select dataset, max(stamp) as stamp from import group by dataset) S using(dataset, stamp) where CD.code=?";

    $imports = $this->doQuery("select distinct I.* $frag", $code_code);
    $dataset_count = $this->doQuery("select count(distinct I.*) $frag", $code_code)->fetchColumn();;

    $response->setParameter('code', $code);
    $response->setParameter('imports', $imports);
    $response->setParameter('dataset_count', $dataset_count);
    $response->setTemplate('code');
  }

}