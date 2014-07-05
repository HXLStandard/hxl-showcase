<?php

class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $dataset = $this->doQuery('select * from dataset_view where source_ident=? and ident=? order by ident', $request->get('source'), $request->get('dataset'))->fetch();
    $imports = $this->doQuery('select * from import_view where dataset=?', $dataset->id);

    $response->setParameter('dataset', $dataset);
    $response->setParameter('imports', $imports);
    $response->setTemplate('dataset');
  }

}