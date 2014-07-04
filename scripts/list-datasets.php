<?php
/**
 * List all known datasets in CSV format.
 *
 * Usage: php list-datasets.php
 */

require_once(__DIR__ . '/lib/database.php');

fputcsv(STDOUT, array('id', 'ident', 'name'));

$statement = _query('select * from dataset');
while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->ident, $row->name));
}

// end


