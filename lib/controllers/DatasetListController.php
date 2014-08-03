<?php

class DatasetListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $imports = $this->doQuery(
      'select * from import_view ' .
      'where import in ' .
      ' (select * from latest_import_view) ' .
      'order by stamp desc'
    );

    $response->setParameter('imports', $imports);
    $response->setTemplate('dataset-list');
  }

}