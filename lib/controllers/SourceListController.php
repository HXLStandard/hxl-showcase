<?php

class SourceListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $imports = $this->doQuery(
      'select source, source_name, ' .
      ' max(stamp) as stamp, ' .
      ' count(distinct dataset) as dataset_count, ' .
      ' count(distinct import) as import_count ' .
      'from import_view '.
      'group by source, source_name'
    );


    $response->setParameter('imports', $imports);
    $response->setTemplate('source-list');
  }

}