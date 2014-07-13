<?php
/**
 * Controller to analyse an imported dataset.
 *
 * This controller renders HTML by default, but can also render CSV if
 * the parameter 'format' is set to 'csv'.
 * 
 * The controller takes advantage of a special view (report_3w_view)
 * that already arranges the values into a tabular format, so that
 * it's easy to perform aggregate operations on them.
 */
class ImportAnalysisController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // Get the request parameters (see .htaccess)
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');
    $group_by = $request->get('groupBy'); // this is an array

    // Grab the metadata for this import (version)
    $import = $this->doQuery('select * from import_view ' .
                             'where source_ident=? and dataset_ident=? and stamp=? ' .
                             'order by stamp desc',
                             $source_ident, $dataset_ident, $stamp)->fetch();

    // Escape to protect from SQL injection attacks
    // TODO look up codes here, instead
    $allowed_fields = array('country', 'adm1', 'adm2', 'adm3', 'sector', 'subsector');
    foreach ($group_by as $i => $field) {
      if (!in_array($field, $allowed_fields)) {
        unset($group_by[$i]);
      }
    }
    $col_names = join($group_by, ',');

    // If we have any columns to group, do the main query now
    if ($col_names) {

      $data = $this->doQuery(
        sprintf('select %s, count(*) as count ' .
                'from report_3w_view ' .
                'where import=? ' .
                'group by %s ' .
                'order by %s',
                $col_names, $col_names, $col_names),
        $import->id
      );
    } else {
      $data = null;
    }

    // Render the results
    if ($format == 'csv') {

      // TODO HXL codes and names

      $output = fopen('php://output', 'w');
      
      // special case: dump CSV and exit
      header('Content-type: text/csv;charset=utf-8');

      $headers = $group_by;
      array_push($headers, 'count');

      fputcsv($output, $headers);
      foreach ($data as $row) {
        $fields = array();
        foreach ($headers as $code) {
          array_push($fields,$row->$code);
        }
        fputcsv($output, $fields);
      }
      exit;

    } else {

      // Need to reconstruct the original query string for a CSV link
      $elements = array();
      foreach ($group_by as $code) {
        array_push($elements, sprintf('%s=%s', urlencode('groupBy[]'), urlencode($code)));
      }
      $response->setParameter('queryString', join('&', $elements));

      // otherwise, show a web page
      $response->setParameter('import', $import);
      $response->setParameter('allowed_fields', $allowed_fields);
      $response->setParameter('group_by', $group_by);
      $response->setParameter('data', $data);
      $response->setTemplate('import-analysis');

    }
  }

}