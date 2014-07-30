<?php

class TagListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $tags = $this->doQuery(
      'select T.*, CNT.col_count' .
      ' from tag_view T' .
      ' left join (select tag, count(*) col_count from col group by tag) CNT using(tag)' .
      ' order by T.tag'
    );

    $response->setParameter('tags', $tags);
    $response->setTemplate('tag-list');
  }

}