<?php
/**
 * Controller to analyse an imported dataset.
 */
class ImportAnalysisController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    // Output format
    $format = $request->get('format', 'html');

    //
    // Get the import record
    //
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');

    $import = $this->doQuery(
      'select * from import_view ' .
      ' where source_ident=? and dataset_ident=? and stamp=?',
      $source_ident, $dataset_ident, $stamp
    )->fetch();

    //
    // Set the filters
    //
    $filter_map = array(
      'country' => '#country',
      '#country' => '#country',
      'adm1' => '#adm1',
      '#adm1' => '#adm1',
      'sector' => '#sector',
      '#sector' => '#sector',
      'org' => '#org',
      '#org' => '#org',
    );
    list($sql_filter, $active_filters) = self::process_filters($request, $import->id, $filter_map);

    //
    // Get the output
    //
    $cols = $this->doQuery('select * from col_view where import=? order by col', $import->id)->fetchAll();
    $values = $this->doQuery('select * from value_view where row in ' . $sql_filter . ' order by row, col');

    //
    // Early cut-off if it's CSV
    if ($format == 'csv') {
      header('Content-type: text/csv;charset=utf-8');
      dump_csv($cols, $values, fopen('php://output', 'w'));
      exit;
    }

    //
    // Metrics
    //
    $total = $this->get_total_count($sql_filter);

    // Get the preview counts
    if (!@$active_filters['#country']) {
      $country_count = $this->get_value_count('#country', $sql_filter);
      $countries = $this->get_value_preview('#country', $sql_filter);
    }

    if (!@$active_filters['#adm1'] && !@$country_count) {
      $adm1_count = $this->get_value_count('#adm1', $sql_filter);
      $adm1s = $this->get_value_preview('#adm1', $sql_filter);
    }

    if (!@$active_filters['#sector']) {
      $sector_count = $this->get_value_count('#sector', $sql_filter);
      $sectors = $this->get_value_preview('#sector', $sql_filter);
    }

    if (!@$active_filters['#org']) {
      $org_count = $this->get_value_count('#org', $sql_filter);
      $orgs = $this->get_value_preview('#org', $sql_filter);
    }

    //
    // Set the response parameters for the template
    //
    $response->setParameter('import', $import);
    $response->setParameter('total', $total);
    $response->setParameter('filters', $active_filters);
    $response->setParameter('cols', $cols);
    $response->setParameter('values', $values);

    if ($sector_count > 0) {
      $response->setParameter('sector_count', $sector_count);
      $response->setParameter('sectors', $sectors);
    }

    if ($country_count > 0) {
      $response->setParameter('country_count', $country_count);
      $response->setParameter('countries', $countries);
    }

    if ($adm1_count > 0) {
      $response->setParameter('adm1_count', $adm1_count);
      $response->setParameter('adm1s', $adm1s);
    }

    if ($org_count > 0) {
      $response->setParameter('org_count', $org_count);
      $response->setParameter('orgs', $orgs);
    }

    $response->setTemplate('import-analysis');
  }

  /**
   * Count the total number of rows matching the filter.
   */
  private function get_total_count($sql_filter) {
    return 0 + $this->doQuery(
      'select count(distinct R.row) from (' . $sql_filter . ') R'
    )->fetchColumn();
  }

  /**
   * Count the number of distinct values for a column.
   *
   * @param $import The import identifier (long integer).
   * @param $code The HXL code.
   * @param $sql_filter The SQL filter subquery (optional).
   * @return The number of distinct values (integer).
   */
  private function get_value_count($code, $sql_filter) {
    return 0 + $this->doQuery(
      'select count(distinct V.value) as count' .
      ' from value_view V ' .
      ' where V.code_code=? and V.row in ' . $sql_filter,
      $code
    )->fetchColumn();
  }

  /**
   * Get the top values for a column.
   *
   * The result objects will have a "count" property with the number
   * of matches, and a "value" property with the cell value.
   *
   * @param $import The import identifier (long integer).
   * @param $code The HXL code.
   * @param $sql_filter The SQL filter subquery (optional).
   * @return A list of result objects.
   */
  private function get_value_preview($code, $sql_filter) {
    return $this->doQuery(
      'select V.value, count(distinct V.row) as count ' .
      ' from value_view V' .
      ' where V.code_code=? and V.row in ' . $sql_filter .
      ' group by V.value' .
      ' order by count(distinct V.row) desc, V.value',
      $code
    );
  }

  /**
   * Static: process the requested filters, and create a SQL (sub)query.
   *
   * @param $request The incoming HTTP request object.
   * @param $filter_map An associative array of request parameters mapped to HXL codes.
   * @return A list containing the SQL fragment and an array of the actual filters selected.
   */
  private static function process_filters(HttpRequest $request, $import_id, $filter_map) {

    // Return values
    $sql_filter = '';
    $active_filters = array();

    // Iterate through the filter map and construct the SQL query
    $n = 0;
    foreach ($filter_map as $http => $hxl) {
      $value = $request->get($http);
      if ($value) {
        $n++;
        if (is_array($value)) {
          $value = array_pop($value);
        }
        $active_filters[$http] = $value;

        // Different treatment for the first one
        if ($n == 1) {
          $sql_filter = 'select V1.row from value_view V1';
          $where_clause = sprintf(" where V1.import=%d and V1.code_code='%s' and V1.value='%s'", $import_id, self::escape_sql($hxl), self::escape_sql($value));
        } else {
        $sql_filter .= sprintf(
          ' join value_view V%d on V1.row=V%d.row and V%d.code_code=\'%s\' and V%d.value=\'%s\'',
          $n, $n, $n, self::escape_sql($hxl), $n, self::escape_sql($value)
        );
        }
      }
    }

    if ($sql_filter) {
      $sql_filter = sprintf('(%s %s)', $sql_filter, $where_clause);
    } else {
      // count all rows
      $sql_filter = sprintf('(select row from row where import=%d)', $import_id);
    }

    // Return the results
    return array($sql_filter, $active_filters);
  }


}