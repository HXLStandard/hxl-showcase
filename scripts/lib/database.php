<?php
/**
 * Simple functions to abstract database access.
 */

require_once(__DIR__ . '/config.php');

/**
 * Get a database connection.
 *
 * This function is safe to call multiple times: it will still create
 * just one connection.
 *
 * @return a PDO database connection.
 */
function _db() {
  static $connection = null;

  if ($connection == null) {
    global $DB;
    $dsn = sprintf("pgsql:host=%s;dbname=%s;user=%s;password=%s", $DB['hostname'], $DB['database'], $DB['username'], $DB['password']);
    $connection = new PDO($dsn);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  }

  return $connection;
}

/**
 * Compile a prepared statement and execute it.
 *
 * This function will automatically save prepared statements for
 * reuse, so it's safe to call it repeatedly.
 *
 * @param $query the first argument is a SQL query with placeholders for arguments.
 * @param ... remaining arguments are parameters for the query.
 * @return the integer result of running a stored procedure.
 */
function _query() {
  static $statements = array();

  // Get the variable-length arguments
  $args = func_get_args();
  $query = array_shift($args);

  // See if we've already prepared the statement
  $statement = @$statements[$query];
  if (!$statement) {
    $statement = _db()->prepare($query);
    $statements[$query] = $statement;
  }

  // Execute the statement
  if ($statement->execute($args)) {
    return $statement;
  } else {
    $err = $statement->errorInfo();
    die($err[2] . "\n");
  }
}

/**
 * Add a new source.
 */
function add_source($source, $source_name) {
  _query('insert into source (source, source_name) values (?, ?)', $source, $source_name);
  return $source;
}

/**
 * Add a new user.
 */
function add_usr($usr, $usr_name) {
  _query('insert into usr (usr, usr_name) values (?, ?)', $usr, $usr_name);
  return $usr;
}

/**
 * Add a HXL tag.
 */
function add_tag($tag, $tag_name, $datatype) {
  _query('insert into tag (tag, tag_name, datatype) values (?, ?, ?)', $tag, $tag_name, $datatype);
}

function get_tag($tag) {
  return _query('select * from tag_view where tag=?', $tag)->fetch();
}

/**
 * Add a dataset.
 */
function add_dataset($source, $dataset, $dataset_name) {
  _query('insert into dataset (source, dataset, dataset_name) values (?, ?, ?)', $source, $dataset, $dataset_name);
  return $dataset;
}

/**
 * Add a new import for a dataset.
 */
function add_import($usr, $dataset) {
  _query('insert into import (usr, dataset) values (?, ?)', $usr, $dataset);
  return _query('select lastval()')->fetchColumn();
}

/**
 * Add a new column for an import.
 */
function add_col($import, $tag, $header) {
  _query('insert into col (import, tag, header) values (?, ?, ?)', $import, $tag, $header);
  return _query('select lastval()')->fetchColumn();
}

/**
 * Add a new row for an import.
 *
 * @param $import_id the import id (long int)
 * @return the row id (long int)
 */
function add_row($import) {
  _query('insert into row (row) values (default)');
  return _query('select lastval()')->fetchColumn();
}

/**
 * Add a new value (cell).
 *
 * @param $row_id the database id of the row (long int)
 * @param $col_id the database id of the column (long int)
 * @param $content the cell content (string)
 */
function add_value($row, $col, $content, $norm = null) {
  _query('insert into value(row, col, content, norm) values (?, ?, ?, ?)', $row, $col, $content, $norm);
  return _query('select lastval()')->fetchColumn();
}

// end
