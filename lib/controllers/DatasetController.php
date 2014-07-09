<?php

class DatasetController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');

    // Latest import for the dataset
    $import = $this->doQuery(
      'select I.* from import_view I ' .
      'join latest_import_view LI on I.id=LI.id ' .
      'where I.source_ident=? and I.dataset_ident=?',
      $source_ident, $dataset_ident
    )->fetch();

    // Columns for the import
    $cols = $this->doQuery(
      'select C.* from col_view C ' .
      'where import=? ' .
      'order by C.id',
      $import->id
    );

    // Values for the import
    $values = $this->doQuery(
      'select V.* from value_view V ' .
      'where import=? ' .
      'order by row, col',
      $import->id
    );

    // Change history (query from value table to get row count)
    $imports = $this->doQuery(
      'select stamp, usr_ident, usr_name, count(distinct row) as row_count ' .
      'from value_view ' .
      'where dataset=? ' .
      'group by dataset, stamp, usr_ident, usr_name ' .
      'order by stamp desc',
      $import->dataset
    );

    $response->setParameter('cols', $cols);
    $response->setParameter('values', $values);

    $response->setParameter('import', $import);
    $response->setParameter('imports', $imports);

    $response->setTemplate('dataset');
  }

}