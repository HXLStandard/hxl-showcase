<?php

class TagController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $tag_param = $request->get('tag');
    $tag = $this->doQuery('select * from tag_view where tag=?', $tag_param)->fetch();

    $frag = "from import_view I join col C using(import) join tag T using(tag) join latest_import_view LI using(import) where T.tag=?";

    $imports = $this->doQuery("select distinct I.* $frag", $tag_param);
    $dataset_count = $this->doQuery("select count(distinct I.*) $frag", $tag_param)->fetchColumn();;

    $response->setParameter('tag', $tag);
    $response->setParameter('imports', $imports);
    $response->setParameter('dataset_count', $dataset_count);
    $response->setTemplate('tag');
  }

}