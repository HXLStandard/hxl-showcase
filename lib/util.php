<?php
/**
 * Utility functions
 */

/**
 * Dump a dataset as CSV.
 */
function dump_csv($cols, $values, $output) {

  header('Content-type: text/plain');

  $tag_row = array();
  $header_row = array();

  // HXL tags and original headers
  foreach ($cols as $col) {
    array_push($header_row, $col->header);
    array_push($tag_row, '#' . $col->tag);
  }
  fputcsv($output, $header_row);
  fputcsv($output, $tag_row);

  $last_row = -1;
  $row = array();
  foreach ($values as $value) {
    if ($last_row != $value->row && $row) {
      dump_csv_row($cols, $row, $output);
      $row = array();
    }
    array_push($row, $value);
    $last_row = $value->row;
  }
  if ($row) {
    dump_csv_row($cols, $row, $output);
  }

}


/**
 * Dump a row of a CSV spreadsheet
 */
function dump_csv_row($cols, $values, $output) {
  $row = array();
  foreach ($cols as $col) {
    $v = null;
    foreach ($values as $i => $value) {
      if ($col->col == $value->col) {
        $v = $value->value;
        unset($values[$i]);
        break;
      }
    }
    array_push($row, $v);
  }
  fputcsv($output, $row);
}

/**
 * Dump a dataset as JSON.
 */
function dump_json($cols, $values, $output) {
  $opts = JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE;
  header('Content-type: application/json');
  print("{");
  print("\n  \"cols\": [");
  $is_first = true;
  foreach ($cols as $col) {
    if ($is_first) {
      $is_first = false;
    } else {
      print(',');
    }
    print("\n    " . json_encode(array(
      'hxl' => '#' . $col->tag,
      'hxl_name' => $col->tag_name,
      'hxl_datatype' => $col->datatype,
      'original_header' => $col->header,
    ), $opts));
  }
  print("\n  ],");
  print("\n  \"rows\": [");
  $last_row = -1;
  $row = array();
  $is_first = true;
  foreach ($values as $value) {
    if ($last_row != $value->row && $row) {
      dump_json_row($cols, $row, $is_first);
      $is_first = false;
      $row = array();
    }
    array_push($row, $value);
    $last_row = $value->row;
  }
  if ($row) {
    dump_json_row($cols, $row, $is_first);
  }
  print("\n  ]");
  print("\n}\n");
}

/**
 * Dump a row of a CSV spreadsheet
 */
function dump_json_row($cols, $values, $is_first) {
  $opts = JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE;
  $row = array();
  foreach ($cols as $col) {
    $v = null;
    foreach ($values as $i => $value) {
      if ($col->col == $value->col) {
        $v = $value->value;
        unset($values[$i]);
        break;
      }
    }
    array_push($row, $v);
  }
  if (!$is_first) {
    print(',');
  }
  print("\n    " . json_encode($row, $opts));
  
}


////////////////////////////////////////////////////////////////////////
// Link generators.
////////////////////////////////////////////////////////////////////////

/**
 * Make a link to a user
 */
function user_link($item) {
  return sprintf('/user/%s', urlencode($item->usr));
}

/**
 * Make a link to a HXL tag
 */
function tag_link($item) {
  return sprintf('/tag/%s', urlencode($item->tag));
}

/**
 * Make a link to a source
 */
function source_link($item) {
  return sprintf('/data/%s', urlencode($item->source));
}

/**
 * Make a link to a dataset
 */
function dataset_link($item) {
  return sprintf(
    '/data/%s/%s',
    urlencode($item->source),
    urlencode($item->dataset)
  );
}

/**
 * Make a link to an import
 */
function import_link($item) {
  return sprintf(
    '/data/%s/%s/%s',
    urlencode($item->source),
    urlencode($item->dataset),
    urlencode($item->stamp)
  );
}

