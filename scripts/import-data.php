<?php
////////////////////////////////////////////////////////////////////////
// Import HXL data from a CSV file
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

$dataset = @$argv[1] || die("Usage: php import-data.php <dataset> < DATA.csv\n");

// Use a transaction, so that it's all or nothing
$connection->beginTransaction();

$statement = $connection->prepare('select add_import(?)');
if (!$statement->execute(array($dataset))) {
  die($statement->errorInfo()[2] . "\n");
}
$import_ref = $statement->fetchColumn();
print_r($import_ref); exit;

$hxl_row = fgetcsv(STDIN);
$header_row = fgetcsv(STDIN);

// a prepared statement can pay off here
$statement = $connection->prepare('insert into code (code, name) values (?, ?)');

$headers = fgetcsv(STDIN);
$n = 1; // count rows for error reporting
while ($row = fgetcsv(STDIN)) {
  $n++;
}

$connection->commit();
