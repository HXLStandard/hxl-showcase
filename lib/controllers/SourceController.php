<?php

/**
 * Data provider page controller.
 *
 * Lists all datasets uploaded by a source.
 */
class SourceController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source = $this->doQuery('select * from source where source=?', $request->get('source'))->fetch();

    $uploads = $this->doQuery(
      'select I.* ' .
      'from import_view I ' .
      'join latest_import_view L using(import) ' .
      'where source=?',
      $source->source);

    $response->setParameter('source', $source);
    $response->setParameter('uploads', $uploads);
    $response->setTemplate('source');
  }

}