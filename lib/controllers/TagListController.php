<?php

class TagListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $tags = $this->doQuery(
      'select C.*, CNT.col_count from tag_view C ' .
      'left join (select tag, count(*) col_count ' .
      'from col group by tag) CNT on C.id=CNT.tag ' .
      'order by C.tag'
    );

    $response->setParameter('tags', $tags);
    $response->setTemplate('tag-list');
  }

}