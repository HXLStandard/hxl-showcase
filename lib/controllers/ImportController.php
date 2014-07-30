<?php
/**
 * Controller to show a specific import (version) of a dataset.
 *
 * This controller renders HTML by default, but can also render CSV if
 * the parameter 'format' is set to 'csv'.
 */
class ImportController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // Get the request parameters (see .htaccess)
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');

    // Grab the metadata for this import (version)
    $import = $this->doQuery('select * from import_view ' .
                             'where source=? and dataset=? and stamp=? ' .
                             'order by stamp desc',
                             $source_ident, $dataset_ident, $stamp)->fetch();

    // Grab the contents of the data table
    $cols = $this->doQuery('select * from col_view where import=? order by col', $import->import)->fetchAll();
    $values = $this->doQuery('select * from value_view where import=? order by row, col', $import->import);

    // Render the results
    if ($format == 'csv') {

      // special case: dump CSV and exit
      header('Content-type: text/csv;charset=utf-8');
      dump_csv($cols, $values, fopen('php://output', 'w'));
      exit;

    } else {

      // otherwise, show a web page
      $response->setParameter('import', $import);
      $response->setParameter('cols', $cols);
      $response->setParameter('values', $values);
      $response->setTemplate('import');

    }
  }

}