<?php
////////////////////////////////////////////////////////////////////////
// Dump an import as a spreadsheet.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

($import_id = @$argv[1]) || die("Usage: php list-import.php <import_id>\n");

// Get the column headers
$statement = $connection->prepare('select * from col_view where import=? order by id');
if (!$statement->execute(array($import_id))) {
  die($statement->errorInfo()[2] . "\n");
}

// Generate the code and header rows
$codes = array();
$headers = array();
while ($col = $statement->fetch()) {
  array_push($codes, $col->code_code);
  array_push($headers, $col->header);
}
fputcsv(STDOUT, $codes);
fputcsv(STDOUT, $headers);

// Generate the value rows
$statement = $connection->prepare('select * from value_view where import=? order by row, col');
if (!$statement->execute(array($import_id))) {
  die($statement->errorInfo()[2] . "\n");
}

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