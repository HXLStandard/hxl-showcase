<?php
////////////////////////////////////////////////////////////////////////
// Import HXL data from a CSV file
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

($dataset = @$argv[1]) || die("Usage: php import-data.php <dataset> < DATA.csv\n");

// Use a transaction, so that it's all or nothing
$connection->beginTransaction();

// Create a new import session
$import_id = add_import($dataset);

// First row is HXL codes; second row is text headers
$code_row = fgetcsv(STDIN);
$header_row = fgetcsv(STDIN);

// Get codes for headers
$cols = array();
for ($i = 0; $i < count($code_row); $i++) {
  array_push($cols, add_col($import_id, $code_row[$i], $header_row[$i]));
}

$n = 0;
$statement = $connection->prepare('select add_value(?, ?, ?)');
while ($row = fgetcsv(STDIN)) {
  $n++;
  if (($n % 100) == 0) {
    printf("%d...", $n);
  }
  $row_id = add_row($import_id);
  for ($i = 0; $i < count($code_row); $i++) {
    $col_id = $cols[$i];
    if ($row) {
      if (!$statement->execute(array($row_id, $col_id, $row[$i]))) {
        die($statement->errorInfo()[2] . "\n");
      }
    }
  }
}

$connection->commit();
