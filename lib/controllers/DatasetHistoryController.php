<?php

class DatasetHistoryController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $params['dataset'] = $request->get('dataset');

    $dataset = get_dataset($params['dataset']);

    $imports = get_imports($params['dataset']);

    $response->setParameter('dataset', $dataset);
    $response->setParameter('imports', $imports);
    $response->setTemplate('dataset-history');
  }

}
