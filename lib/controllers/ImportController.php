<?php

class ImportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $import = $this->doQuery('select * from import_view where source_ident=? and dataset_ident=? and stamp=? order by stamp desc',
                             $request->get('source'),
                             $request->get('dataset'),
                             $request->get('import'))->fetch();
    $cols = $this->doQuery('select * from col_view where import=? order by id', $import->id)->fetchAll();
    $values = $this->doQuery('select * from value_view where import=? order by row, col', $import->id);

    $response->setParameter('import', $import);
    $response->setParameter('cols', $cols);
    $response->setParameter('values', $values);
    $response->setTemplate('import');
  }

}