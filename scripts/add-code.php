<?php
////////////////////////////////////////////////////////////////////////
// Update a HXL code in the database
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-code.php <code> <name>\n");
}

list($script, $code, $name) = $argv;

$statement = $connection->prepare('insert into code (code, name) values (?, ?)');
if ($statement->execute(array($code, $name))) {
  printf("Added code %s (%s)\n", $code, $name);
} else {
  die($statement->errorInfo()[2] . "\n");
}

