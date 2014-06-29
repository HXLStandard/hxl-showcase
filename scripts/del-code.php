<?php
////////////////////////////////////////////////////////////////////////
// Delete a HXL code in the database
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 2) {
  die("Usage: php del-code.php <code>\n");
}

list($script, $code) = $argv;

$statement = $connection->prepare('delete from code where code=?');
if ($statement->execute(array($code))) {
  printf("Deleted code %s\n", $code);
} else {
  die($statement->errorInfo()[2] . "\n");
}

