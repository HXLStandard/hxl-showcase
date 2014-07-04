<?php
/**
 * List all known datasets in CSV format.
 *
 * Usage: php list-datasets.php [source?]
 */

require_once(__DIR__ . '/lib/database.php');

$source = @$argv[1];

if ($source) {
  $statement = _query('select * from dataset_view where source_ident=?', $source);
} else {
  $statement = _query('select * from dataset_view order by id');
}

fputcsv(STDOUT, array('id', 'ident', 'name', 'source_ident', 'source_name'));

while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->ident, $row->name, $row->source_ident, $row->source_name));
}

// end


