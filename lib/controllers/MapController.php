<?php

/**
 * Controller to generate a map
 */
class MapController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');
    $params->tag = $request->get('tag');

    $import = get_import($params->dataset, $params->import);
    $tag = get_tag($params->tag);

    list($filter_fragment, $filters) = process_filters($request, $import->import, get_tags());

    $locations = do_query(
      'select LAT.norm as lat_deg, LON.norm as lon_deg, TAG.content as value ' .
      'from value_view LAT ' .
      'join value_view LON using(row) ' .
      'join value_view TAG using(row) ' .
      "where LAT.tag='lat_deg' and LON.tag='lon_deg' and TAG.tag=? " .
      " and LAT.content <> '' and LON.content <> '' " .
      ' and row in ' . $filter_fragment .
      'order by row',
      $params->tag
    );

    switch ($format) {
    case 'csv':
      self::dump_csv($locations, $params->tag);
      exit;
    case 'json':
      self::dump_json($locations, $params->tag);
      exit;
    default:
      $filter_tags = get_filter_tags($params->tag, $filters, get_cols($import));
      sort($filter_tags);
      $response->setParameter('params', $params);
      $response->setParameter('filters', $filters);
      $response->setParameter('filter_tags', $filter_tags);
      $response->setParameter('import', $import);
      $response->setParameter('tag', $tag);
      $response->setParameter('cols', $cols);
      $response->setParameter('locations', $locations);
      $response->setParameter('aggregates', $aggregates);
      $response->setTemplate('map');
      break;
    }

  }

  private static function dump_csv($locations, $tag) {
    header('Content-type: text/plain;charset=utf8');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('#lat_deg', '#lon_deg', "#$tag"));
    foreach ($locations as $location) {
      fputcsv($output, array($location->lat_deg, $location->lon_deg, $location->value));
    }
    fclose($output);
  }

  private static function dump_json($locations) {
    header('Content-type: application/json;charset=utf8');

    print "[";
    $is_first = true;
    foreach ($locations as $location) {
      if ($is_first) {
        $is_first = false;
      } else {
        print(',');
      }
      print("\n  " . json_encode(array(
        0 + $location->lat_deg,
        0 + $location->lon_deg,
        $location->value,
      )));
    }
    print("\n]\n");
  }

}