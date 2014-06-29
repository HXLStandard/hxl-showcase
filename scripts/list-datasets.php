<?php

require_once(__DIR__ . '/lib/database.php');

$statement = $connection->prepare('select * from dataset');

if ($statement->execute()) {
  print_r($statement->fetchAll());
} else {
  die($statement->errorInfo()[2] . "\n");
}

