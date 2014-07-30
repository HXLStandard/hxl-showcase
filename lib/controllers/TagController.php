<?php

class TagController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $tag = $request->get('tag');
    $tag = $this->doQuery('select * from tag where tag=?', $tag)->fetch();

    $frag = "from import_view I join col C on I.id=C.import join tag CD on C.tag=CD.id join latest_import_view LI on C.import=LI.id where CD.tag=?";

    $imports = $this->doQuery("select distinct I.* $frag", $tag);
    $dataset_count = $this->doQuery("select count(distinct I.*) $frag", $tag)->fetchColumn();;

    $response->setParameter('tag', $tag);
    $response->setParameter('imports', $imports);
    $response->setParameter('dataset_count', $dataset_count);
    $response->setTemplate('tag');
  }

}