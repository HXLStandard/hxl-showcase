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

    //
    // Import
    //
    $source_ident = $request->get('source');
    $dataset_ident = $request->get('dataset');
    $stamp = $request->get('import');
    $format = $request->get('format');

    $import = $this->doQuery(
      'select * from import_view ' .
      ' where source_ident=? and dataset_ident=? and stamp=?',
      $source_ident, $dataset_ident, $stamp
    )->fetch();

    //
    // Filters
    //
    $filter_map = array(
      'country' => 'country',
      'adm1' => 'adm1',
      'sector' => 'sector',
      'org' => 'org',
    );

    $sql_filter = '';
    $active_filters = array();
    foreach ($filter_map as $http => $sql) {
      $value = $request->get($http);
      if ($value) {
        if (is_array($value)) {
          $value = array_pop($value);
        }
        $active_filters[$http] = $value;
        $sql_filter .= sprintf(" and %s='%s'", $sql, self::escape_sql($value));
      }
    }

    //
    // Metrics
    //
    $total = $this->doQuery(
      'select count(distinct row) from report_3w_view' .
      ' where import=?' . $sql_filter,
      $import->id
    )->fetchColumn();

    // Get the preview counts
    if (!$active_filters['country']) {
      $country_count = $this->get_value_count($import, 'country', $sql_filter);
      $countries = $this->get_value_preview($import, 'country', $sql_filter);
    }

    if (!$active_filters['adm1'] && !@$country_count) {
      $adm1_count = $this->get_value_count($import, 'adm1', $sql_filter);
      $adm1s = $this->get_value_preview($import, 'adm1', $sql_filter);
    }

    if (!$active_filters['sector']) {
      $sector_count = $this->get_value_count($import, 'sector', $sql_filter);
      $sectors = $this->get_value_preview($import, 'sector', $sql_filter);
    }

    if (!$active_filters['org']) {
      $org_count = $this->get_value_count($import, 'org', $sql_filter);
        $orgs = $this->get_value_preview($import, 'org', $sql_filter);
    }

    $response->setParameter('import', $import);
    $response->setParameter('total', $total);
    $response->setParameter('sector_count', $sector_count);
    $response->setParameter('sectors', $sectors);
    if ($country_count > 0) {
      $response->setParameter('country_count', $country_count);
      $response->setParameter('countries', $countries);
    } else {
      $response->setParameter('adm1_count', $adm1_count);
      $response->setParameter('adm1s', $adm1s);
    }
    $response->setParameter('org_count', $org_count);
    $response->setParameter('orgs', $orgs);
    $response->setParameter('filters', $active_filters);

    $response->setTemplate('import-analysis');
  }

  private function get_value_count($import, $code, $sql_filter = '') {
    return $this->doQuery(
      "select count(distinct $code) as count" .
      ' from report_3w_view ' .
      " where import=? and $code is not null $sql_filter",
      $import->id
    )->fetchColumn();
  }

  /**
   * Get the top 5 values for a column.
   */
  private function get_value_preview($import, $code, $sql_filter = '') {
    return $this->doQuery(
      "select $code, count(distinct row) as count " .
      ' from report_3w_view' .
      " where import=? and $code is not null $sql_filter" .
      " group by $code" .
      " order by count(distinct row) desc, $code" .
      ' limit 5',
      $import->id
    );
  }


}