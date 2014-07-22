<?php
/**
 * Utility functions
 */

/**
 * Dump a CSV spreadsheet.
 */
function dump_csv($cols, $values, $output) {

  $code_row = array();
  $header_row = array();

  // HXL codes and original headers
  foreach ($cols as $col) {
    array_push($code_row, $col->code_code);
    array_push($header_row, $col->header);
  }
  fputcsv($output, $code_row);
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
  $ident = ($item->usr_ident ? $item->usr_ident : $item->ident);
  return sprintf('/user/%s', urlencode($ident));
}

/**
 * Make a link to a HXL code
 */
function code_link($item) {
  $code = ($item->code_code ? $item->code_code : $item->code);
  return sprintf('/code/%s', urlencode($code));
}

/**
 * Make a link to a source
 */
function source_link($item) {
  $ident = ($item->source_ident ? $item->source_ident : $item->ident);
  return sprintf('/data/%s', urlencode($ident));
}

/**
 * Make a link to a dataset
 */
function dataset_link($item) {
  $ident = ($item->dataset_ident ? $item->dataset_ident : $item->ident);
  return sprintf(
    '/data/%s/%s',
    urlencode($item->source_ident),
    urlencode($ident)
  );
}

/**
 * Make a link to an import
 */
function import_link($item) {
  return sprintf(
    '/data/%s/%s/%s',
    urlencode($item->source_ident),
    urlencode($item->dataset_ident),
    urlencode($item->stamp)
  );
}

