<?php
/**
 * Controller to analyse an imported dataset.
 *
 * This controller renders HTML by default, but can also render CSV if
 * the parameter 'format' is set to 'csv'.
 */
class ImportAnalysisController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // Get the request parameters (see .htaccess)
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');

    $group_by = $request->get('groupBy');

    // Grab the metadata for this import (version)
    $import = $this->doQuery('select * from import_view ' .
                             'where source_ident=? and dataset_ident=? and stamp=? ' .
                             'order by stamp desc',
                             $source_ident, $dataset_ident, $stamp)->fetch();

    // Protect from SQL injection attacks
    $allowed_fields = array('country', 'adm1', 'adm2', 'adm3', 'sector', 'subsector');
    foreach ($group_by as $i => $field) {
      if (!in_array($field, $allowed_fields)) {
        unset($group_by[$i]);
      }
    }
    $col_names = join($group_by, ',');

    $data = $this->doQuery(
      sprintf('select %s, count(*) as count ' .
              'from report_3w_view ' .
              'where import=? ' .
              'group by %s',
              $col_names, $col_names),
      $import->id
    );

    // Render the results
    if ($format == 'csv') {

      // special case: dump CSV and exit
      header('Content-type: text/csv;charset=utf-8');
      // TODO
      exit;

    } else {

      // otherwise, show a web page
      $response->setParameter('import', $import);
      $response->setParameter('allowed_fields', $allowed_fields);
      $response->setParameter('group_by', $group_by);
      $response->setParameter('data', $data);
      $response->setTemplate('import-analysis');

    }
  }

}