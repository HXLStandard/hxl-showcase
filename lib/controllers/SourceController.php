<?php

/**
 * Data provider page controller.
 *
 * Lists all datasets uploaded by a source.
 */
class SourceController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source = $this->doQuery('select * from source where ident=?', $request->get('source'))->fetch();

    $uploads = $this->doQuery(
      'select I.* ' .
      'from import_view I ' .
      'join latest_import_view L using(id) ' .
      'where source_ident=?',
      $source->ident);

    $response->setParameter('source', $source);
    $response->setParameter('uploads', $uploads);
    $response->setTemplate('source');
  }

}