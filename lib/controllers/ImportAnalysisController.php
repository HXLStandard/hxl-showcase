<?php
/**
 * Controller to analyse an imported dataset.
 *
 * This controller renders HTML by default, but can also render CSV if
 * the parameter 'format' is set to 'csv'.
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
    $n = 0;
    foreach ($filter_map as $http => $hxl) {
      $value = $request->get($http);
      if ($value) {
        $n++;
        if (is_array($value)) {
          $value = array_pop($value);
        }
        $active_filters[$http] = $value;
        $sql_filter .= sprintf(
          ' join value_view V%d on R.row=V%d.row and V%d.code_code=\'%s\' and V%d.value=\'%s\'',
          $n, $n, $n, $hxl, $n, $value
        );
      }
    }

    //
    // Metrics
    //

    $total = $this->doQuery(
      'select count(distinct R.row) from row R' . $sql_filter .
      ' where R.import=?',
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
      'select count(distinct R.value) as count' .
      ' from value_view R ' . $sql_filter .
      ' where R.import=? and R.code_code=?',
      $import->id, $code
    )->fetchColumn();
  }

  /**
   * Get the top 5 values for a column.
   */
  private function get_value_preview($import, $code, $sql_filter = '') {
    return $this->doQuery(
      "select V.value, count(distinct V.row) as count " .
      ' from value_view V' . $sql_filter .
      ' where V.import=? and V.code_code=?' .
      ' group by V.value' .
      " order by count(distinct V.row) desc, value",
      $import->id, $code
    );
  }


}