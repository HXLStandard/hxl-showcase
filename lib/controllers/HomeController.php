<?php

class HomeController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $uploads = $this->doQuery(
      'select source_ident, source_name, dataset_ident, dataset_name, usr_ident, usr_name, stamp, count(distinct row) as row_count ' .
      'from value_view ' .
      'group by import, source_ident, source_name, dataset_ident, dataset_name, usr_ident, usr_name, stamp ' .
      'order by stamp desc limit 5'
    );

    $response->setParameter('uploads', $uploads);
    $response->setTemplate('home');
  }

}