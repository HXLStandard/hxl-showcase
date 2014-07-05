<?php
/**
 * List all known usrs in CSV format.
 *
 * Usage: php list-usrs.php
 */

require_once(__DIR__ . '/lib/database.php');

fputcsv(STDOUT, array('id', 'ident', 'name'));

$statement = _query('select * from usr order by id');
while ($row = $statement->fetch()) {
  fputcsv(STDOUT, array($row->id, $row->ident, $row->name));
}

// end


