<?php
/**
 * Import HXL codes from a CSV file
 *
 * Usage: php import-codes.php [-r] < SOURCE.csv
 *
 * -r means remove all existing codes before reimporting
 *
 * SOURCE.csv is a CSV file with (at least) the headers "code" and
 * "name"
 *
 * If there's any problem, the script will fail completely, and the
 * database will be unchanged.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) > 2 || (count($argv) == 2 && $argv[1] != '-r')) {
  die("Usage: php import-codes.php [-r] < SOURCE.csv\n");
}

// Use a transaction, so that it's all or nothing
_db()->beginTransaction();

// if "-r" is specified, delete old codes first
@list($script, $replace_flag) = $argv;
if ($replace_flag) {
  print("Deleting old codes\n");
  _query('delete from code');
}

$headers = fgetcsv(STDIN);
$n = 1; // count rows for error reporting
while ($row = fgetcsv(STDIN)) {
  $n++;
  $fields = array_combine($headers, $row);
  if ($fields['code']) {
    if ($fields['name']) {
      add_code($fields['code'], $fields['name']);
      printf("Added code %s (%s)\n", $fields['code'], $fields['name']);
    } else {
      die("Missing name in row $n\n");
    }
  } else {
    die("Missing code in row $n\n");
  }
}

_db()->commit();

// end
