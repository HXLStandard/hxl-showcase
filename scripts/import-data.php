<?php
////////////////////////////////////////////////////////////////////////
// Import HXL data from a CSV file
//
// Expecting "code" and "name" headers in the CSV.
//
// If there's any problem, the script will fail completely, and the
// database will be unchanged.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

// Use a transaction, so that it's all or nothing
$connection->beginTransaction();

// a prepared statement can pay off here
$statement = $connection->prepare('insert into code (code, name) values (?, ?)');

$headers = fgetcsv(STDIN);
$n = 1; // count rows for error reporting
while ($row = fgetcsv(STDIN)) {
  $n++;
}

$connection->commit();
