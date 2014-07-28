<?php
/**
 * Dump an import as a spreadsheet.
 *
 * Usage: php dump-import.php <import-id>
 *
 * This script requires the database id for the import. You can find that using
 * the list-imports.php script.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) == 2) {
  $import_id = @$argv[1];
} else {
  die("Usage: php list-import.php <import_id>\n");
}

// First, get a list of the column headers and tags

$statement = _query('select * from col_view where import=? order by id', $import_id);
$tags = array();
$headers = array();
while ($col = $statement->fetch()) {
  array_push($tags, $col->tag_tag);
  array_push($headers, $col->header);
}
fputcsv(STDOUT, $tags);
fputcsv(STDOUT, $headers);

// Next, get the spreadsheet values
$statement = _query('select * from value_view where import=? order by row, col', $import_id);

// Arrange the values into rows
$last_row = -1;
$row_out = null;
while ($row = $statement->fetch()) {
  if ($row->row != $last_row) {
    if ($row_out) {
      fputcsv(STDOUT, $row_out);
    }
    $row_out = array();
    $last_row = $row->row;
  }
  array_push($row_out, $row->value);
}

if ($row_out) {
  fputcsv(STDOUT, $row_out);
}

// end
