<?php
////////////////////////////////////////////////////////////////////////
// Add a new dataset in the database
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-dataset.php <ident> <name>\n");
}

list($script, $ident, $name) = $argv;

$statement = $connection->prepare('select add_dataset(?, ?)');
if ($statement->execute(array($ident, $name))) {
  printf("Added dataset %s (%s)\n", $ident, $name);
} else {
  die($statement->errorInfo()[2] . "\n");
}

