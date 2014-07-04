<?php
/**
 * Product a CSV-formatted list of all HXL codes known to the system.
 *
 * Usage: php list-codes.php
 *
 * The output is suitable for use by the import-codes.php script.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 1) {
  die("Usage: php list-codes.php\n");
}

fputcsv(STDOUT, array('code', 'name'));

$statement = _query('select * from code');
while ($code = $statement->fetch()) {
  fputcsv(STDOUT, array($code->code, $code->name));
}

// end
