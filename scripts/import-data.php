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

require_once(__DIR__ . '/../lib/init.php');
require_once(__DIR__ . '/../lib/libhxl-php/HXL/HXL.php');

if (count($argv) == 4) {
  list($script, $usr, $source, $dataset) = $argv;
} else {
  die("Usage: php import-data.php <usr> <source> <dataset> < DATA.csv\n");
}

// Use a transaction, so that it's all or nothing
begin_db_transaction();

db()->exec('set constraints all deferred');

// Create a new import session
$import_id = add_import($usr, $dataset);

// Prepare to loop through the input dataset
$n = 0;
$hxl = new HXLReader(STDIN);
$first_row = true;
$col_ids = [];

// Process each row
foreach ($hxl as $row) {
  $n++;
  if (($n % 50) == 0) {
    print "$n...";
  }
  $row_id = add_row($import_id);
  foreach ($row as $i => $value) {
    if ($first_row) {
      // If it's the first row, we need to create each column as we go (and save for future use)
      if (!get_tag($value->column->hxlTag)) {
        printf("Adding previously-unknown HXL tag %s\n", $value->column->hxlTag);
        add_tag($value->column->hxlTag, $value->column->headerText, 'Text');
      }
      array_push($col_ids, add_col($import_id, $value->column->hxlTag, $value->column->headerText));
    }
    // add the actual value
    add_value($row_id, $col_ids[$i], $value->content, $value->content);
  }
  // Past the first row
  $first_row = false;
}

commit_db_transaction();

printf("Added %d rows of data in %d columns\n", $n, count($col_ids));

// end
