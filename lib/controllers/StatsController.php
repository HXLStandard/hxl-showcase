<?php

/**
 * Controller to generate statistics
 */
class StatsController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {

    $format = $request->get('format');

    $params->dataset = $request->get('dataset');
    $params->import = $request->get('import');
    $params->tag = $request->get('tag');

    $import = get_import($params->dataset, $params->import);
    $tag = get_tag($params->tag);

    list($filter_fragment, $filters) = process_filters($request, $import->import, get_tags());

    $stats = do_query(
      'select value, count(distinct row) as count' .
      ' from value_view' .
      ' where tag=? and row in ' . $filter_fragment .
      ' group by value' .
      ' order by count(distinct row) desc',
      $params->tag
    );

    switch ($format) {
    case 'csv':
      self::dump_csv($stats);
      exit;
    case 'json':
      self::dump_json($stats);
      exit;
    default:
      $response->setParameter('params', $params);
      $response->setParameter('filters', $filters);
      $response->setParameter('import', $import);
      $response->setParameter('tag', $tag);
      $response->setParameter('stats', $stats);
      $response->setTemplate('stats');
      break;
    }

  }

  private static function dump_csv($stats) {
    header('Content-type: text/csv;charset=utf8');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('value', 'count'));
    foreach ($stats as $stat) {
      fputcsv($output, array(($stat->value?$stat->value:'<none>'), $stat->count));
    }
    fclose($output);
  }

  private static function dump_json($stats) {
    header('Content-type: application/json;charset=utf8');

    print "[";
    $is_first = true;
    foreach ($stats as $stat) {
      if ($is_first) {
        $is_first = false;
      } else {
        print(',');
      }
      print("\n  " . json_encode(
        array(
          $stat->value,
          $stat->count,
        ), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE
      ));
    }
    print("\n]\n");
  }

    

}