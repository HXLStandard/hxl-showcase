<?php
/**
 * List all known datasets in CSV format.
 *
 * Usage: php list-datasets.php [source?]
 *
 * source: the short identifier for the source
 *
 * If no source is specified, show all datasets in the system.
 */

require_once(__DIR__ . '/lib/database.php');

$source = @$argv[1];

if ($source) {
  $statement = _query('select * from dataset_view where source_ident=? order by id', $source);
} else {
  $statement = _query('select * from dataset_view order by id');
}

fputcsv(STDOUT, array('id', 'ident', 'name', 'source_ident', 'source_name'));

while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->ident, $row->name, $row->source_ident, $row->source_name));
}

// end


