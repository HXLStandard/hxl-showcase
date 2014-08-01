<?php

class DatasetHistoryController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');

    $dataset = $this->doQuery(
      'select * from dataset_view ' .
      'where source=? and dataset=?',
      $source_ident, $dataset_ident)->fetch();

    // Change history (query from value table to get row count)
    $imports = $this->doQuery(
      'select stamp, source, dataset, usr, usr_name, count(distinct row) as row_count ' .
      'from search_view ' .
      'join usr using(usr) ' .
      'where dataset=? ' .
      'group by dataset, stamp, source, dataset, usr, usr_name ' .
      'order by stamp desc',
      $dataset->dataset
    );

    $response->setParameter('dataset', $dataset);
    $response->setParameter('imports', $imports);
    $response->setTemplate('dataset-history');
  }

}
