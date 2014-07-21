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

    // Get the import
    $import = $this->doQuery(
      'select * from import_view ' .
      ' where source_ident=? and dataset_ident=? and stamp=?',
      $source_ident, $dataset_ident, $stamp
    )->fetch();

    // Get the total rows
    $total = $this->doQuery(
      'select count(distinct row) from value_view where import=?',
      $import->id
    )->fetchColumn();

    // Get the preview counts
    $country_count = $this->get_value_count($import, 'country');

    if ($country_count > 0) {
      $countries = $this->get_value_preview($import, 'country');
    } else {
      $adm1_count = $this->get_value_count($import, 'adm1');
      $adm1s = $this->get_value_preview($import, 'adm1');
    }

    $sector_count = $this->get_value_count($import, 'sector');
    $sectors = $this->get_value_preview($import, 'sector');

    $org_count = $this->get_value_count($import, 'org');
    $orgs = $this->get_value_preview($import, 'org');

    $response->setParameter('import', $import);
    $response->setParameter('total', $total);
    $response->setParameter('sector_count', $sector_count);
    $response->setParameter('sectors', $sectors);
    $response->setParameter('country_count', $country_count);
    $response->setParameter('countries', $countries);
    $response->setParameter('org_count', $org_count);
    $response->setParameter('orgs', $orgs);

    $response->setTemplate('import-analysis');
  }

  private function get_value_count($import, $code) {
    return $this->doQuery(
      'select count(distinct value) as count' .
      ' from value_view ' .
      ' where import=? and code_code=?',
      $import->id, $code
    )->fetchColumn();
  }

  /**
   * Get the top 5 values for a column.
   */
  private function get_value_preview($import, $code) {
    return $this->doQuery(
      'select value, count(distinct row) as count ' .
      ' from value_view' .
      ' where import=? and code_code=?' .
      ' group by value' .
      ' order by count(distinct row) desc' .
      ' limit 5',
      $import->id, $code
    );
  }


}