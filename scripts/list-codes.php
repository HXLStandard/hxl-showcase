<?php

require_once(__DIR__ . '/lib/database.php');

$statement = $connection->prepare('select * from code');

fputcsv(STDOUT, array('code', 'name'));
if ($statement->execute()) {
  while ($code = $statement->fetch()) {
    fputcsv(STDOUT, array($code->code, $code->name));
  }
} else {
  die($statement->errorInfo()[2] . "\n");
}

