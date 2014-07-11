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
      if ($col->id == $value->col) {
        $v = $value->value;
        unset($values[$i]);
        break;
      }
    }
    array_push($row, $v);
  }
  fputcsv($output, $row);
}