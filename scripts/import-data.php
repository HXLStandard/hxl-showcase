<?php
/**
 * Import HXL data from a CSV file
 *
 * Usage: php import-data.php <source> <dataset> < DATA.csv
 *
 * source: the unique source identifier (e.g. "unhcr")
 *
 * dataset: the unique dataset identifier (e.g. "refugees")
 *
 * DATA.csv: the source CSV file, containing HXL tags on the first
 * line, and human-readable headers on the second. Remaining lines are
 * data rows.
 *
 * Will fail if it finds an unrecognized HXL tag.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) == 4) {
  list($script, $usr, $source, $dataset) = $argv;
} else {
  die("Usage: php import-data.php <usr> <source> <dataset> < DATA.csv\n");
}

// Use a transaction, so that it's all or nothing
_db()->beginTransaction();

_db()->exec('set constraints all deferred');

// Create a new import session
$import_id = add_import($usr, $dataset);

// First row is text headers; second row is HXL tags
$header_row = fgetcsv(STDIN);
$tag_row = fgetcsv(STDIN);

// Get tags for headers
$cols = array();
for ($i = 0; $i < count($tag_row); $i++) {
  printf("Trying %s...", $tag_row[$i]);
  if ($tag_row[$i]) {
    if (substr($tag_row[$i], 0, 1) != '#') {
      die(sprintf("Tag \"%s\" does not start with '#'\n", $tag_row[$i]));
    } else {
      $tag = substr($tag_row[$i], 1);
      array_push($cols, add_col($import_id, $tag, $header_row[$i]));
      print("success\n");
    }
  } else {
    printf("Skipping column \"%s\" (no HXL tag)\n", $header_row[$i]);
    array_push($cols, null);
  }
}

// Read each row
$n = 0;
while ($row = fgetcsv(STDIN)) {
  $n++;
  if (($n % 100) == 0) {
    print "$n...";
  }
  $row_id = add_row($import_id);
  // Read each value in the row
  for ($i = 0; $i < count($tag_row); $i++) {
    $col_id = $cols[$i];
    if ($row && $col_id) {
      add_value($row_id, $col_id, $row[$i]);
    }
  }
}

_db()->commit();

printf("Added %d rows of data in %d columns\n", $n, count($tag_row));

// end
