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

    // First, get the import
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');

    $import = $this->doQuery(
      'select * from import_view ' .
      'where source_ident=? and dataset_ident=? and stamp=?',
      $source_ident, $dataset_ident, $stamp
    )->fetch();

    // Map request params to columns in the SQL view
    $filter_map = array(
      'country' => 'country',
      'adm1' => 'adm1',
      'adm2' => 'adm2',
      'sector' => 'sector',
      'subsector' => 'subsector',
    );

    // Build the SQL query fragment to filter
    $filter_sql = '';
    foreach ($filter_map as $http => $sql) {
      $values = $request->get($http);
      if (!$values) {
        continue;
      }
      // FIXME logic is wrong -- should be "or" at this level
      if (!is_array($values)) {
        $values = array($values);
      }
      foreach ($values as $value) {
        $filter_sql .= sprintf(" and %s='%s'", $sql, self::escape_sql($value));
      }
    }

    // Fetch the matching rows
    $data = $this->doQuery(
      'select country, adm1, adm2, sector, subsector ' .
      'from report_3w_view ' .
      'where import=?' . $filter_sql,
      $import->id
    );

    $headers = array('#country', '#adm1', '#adm2', '#sector', '#subsector');

    // Render the results
    if ($format == 'csv') {

      // TODO HXL codes and names

      $output = fopen('php://output', 'w');
      
      // special case: dump CSV and exit
      header('Content-type: text/csv;charset=utf-8');

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

      // otherwise, show a web page
      $response->setParameter('import', $import);
      $response->setParameter('data', $data);
      $response->setParameter('headers', $headers);
      $response->setTemplate('import-analysis');

    }
  }

}