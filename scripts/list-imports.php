<?php
/**
 * List imports for a specific dataset in CSV format.
 *
 * Usage: php list-imports.php <dataset>
 *
 * dataset: the unique identifier for the dataset (e.g. "unhcr")
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) == 2) {
  $dataset = $argv[1];
} else {
  die("Usage: php list-imports.php <dataset>\n");
}

$statement = _query('select * from import_view where dataset=ref_dataset(?)', $dataset);

fputcsv(STDOUT, array('id, dataset, stamp'));
while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->dataset_ident, $row->stamp));
}

// end
