<?php
/**
 * List imports for a specific dataset in CSV format.
 *
 * Usage: php list-imports.php <source> <dataset>
 *
 * source: the unique identifier for the source (e.g. "unhcr")
 *
 * dataset: the unique identifier for the dataset (e.g. "refugees")
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) <= 3) {
  @list($script, $source, $dataset) = $argv;
} else {
  die("Usage: php list-imports.php <source> <dataset>\n");
}

if ($dataset) {
  $statement = _query('select * from import_view where source_ident=? and dataset_ident=?', $source, $dataset);
} else if ($source) {
  $statement = _query('select * from import_view where source_ident=?', $source);
} else {
  $statement = _query('select * from import_view');
}

fputcsv(STDOUT, array('id', 'stamp', 'dataset_ident', 'dataset_name', 'source_ident', 'source_name'));
while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->stamp, $row->dataset_ident, $row->dataset_name, $row->source_ident, $row->source_name));
}

// end
