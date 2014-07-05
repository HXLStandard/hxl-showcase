<?php
/**
 * List all known sources in CSV format.
 *
 * Usage: php list-sources.php
 */

require_once(__DIR__ . '/lib/database.php');

fputcsv(STDOUT, array('id', 'ident', 'name'));

$statement = _query('select * from source order by id');
while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->ident, $row->name));
}

// end


