<?php
/**
 * Import HXL data from a CSV file
 *
 * Usage: php import-data.php <dataset> < DATA.csv
 *
 * dataset: the unique dataset identifier (e.g. "unhcr")
 *
 * DATA.csv: the source CSV file, containing HXL codes on the first
 * line, and human-readable headers on the second. Remaining lines are
 * data rows.
 *
 * Will fail if it finds an unrecognized HXL code.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) == 2) {
  $dataset = @$argv[1];
} else {
  die("Usage: php import-data.php <dataset> < DATA.csv\n");
}

// Use a transaction, so that it's all or nothing
_db()->beginTransaction();

// Create a new import session
$import_id = add_import($dataset);

// First row is HXL codes; second row is text headers
$code_row = fgetcsv(STDIN);
$header_row = fgetcsv(STDIN);

// Get codes for headers
$cols = array();
for ($i = 0; $i < count($code_row); $i++) {
  array_push($cols, add_col($import_id, $code_row[$i], $header_row[$i]));
}

// Read each row
$n = 0;
while ($row = fgetcsv(STDIN)) {
  $n++;
  $row_id = add_row();
  // Read each value in the row
  for ($i = 0; $i < count($code_row); $i++) {
    $col_id = $cols[$i];
    if ($row) {
      add_value($row_id, $col_id, $row[$i]);
    }
  }
}

_db()->commit();

printf("Added %d rows of data in %d columns\n", $n, count($code_row));

// end
