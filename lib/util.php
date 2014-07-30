<?php
/**
 * Utility functions
 */

/**
 * Dump a CSV spreadsheet.
 */
function dump_csv($cols, $values, $output) {

  $tag_row = array();
  $header_row = array();

  // HXL tags and original headers
  foreach ($cols as $col) {
    array_push($tag_row, $col->tag);
    array_push($header_row, $col->header);
  }
  fputcsv($output, $tag_row);
  fputcsv($output, $header_row);

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

