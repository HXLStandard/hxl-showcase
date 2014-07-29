<?php

/**
 * Home-page controller.
 */
class HomeController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $uploads = $this->doQuery(
      'select I.* ' .
      'from import_view I ' .
      'order by stamp desc limit 10'
    );

    $response->setParameter('uploads', $uploads);
    $response->setTemplate('home');
  }

}