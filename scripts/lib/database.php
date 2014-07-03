<?php

require_once(__DIR__ . '/config.php');

global $connection;

$dsn = sprintf("pgsql:host=%s;dbname=%s;user=%s;password=%s", $DB['hostname'], $DB['database'], $DB['username'], $DB['password']);
$connection = new PDO($dsn);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

function _call() {
  global $connection;
  $args = func_get_args();
  $query = array_shift($args);
  $statement = $connection->prepare($query);
  if ($statement->execute($args)) {
    return $statement->fetchColumn();
  } else {
    die($statement->errorInfo()[2] . "\n");
  }
}

function ref_dataset($ident) {
  return _call('select ref_dataset(?)', $ident);
}

function add_import($dataset_ident) {
  return _call('select add_import(?)', $dataset_ident);
}

function add_col($import_id, $code, $header) {
  return _call('select add_col(?, ?, ?)', $import_id, $code, $header);
}

function add_row($import_id) {
  return _call('select add_row(?)', $import_id);
}

function add_value($row_id, $col_id, $value) {
  return _call('select add_value(?, ?, ?)', $row_id, $col_id, $value);
}
