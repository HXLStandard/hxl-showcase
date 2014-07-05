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
    die($statement->errorInfo()[2] . "\n");
  }
}

/**
 * Execute a SQL query containing a stored function.
 *
 * By convention, the function returns a single result value.
 */
function _function() {
  $statement = call_user_func_array("_query", func_get_args());
  return $statement->fetchColumn();
}

function add_source($ident, $name) {
  return _function('select add_source(?, ?)', $ident, $name);
}

function add_usr($ident, $name) {
  return _function('select add_usr(?, ?)', $ident, $name);
}

/**
 * Add a HXL code.
 *
 * @param $code the HXL code.
 * @param $name the name of the HXL data element.
 * @return the code database id (long int)
 */
function add_code($code, $name) {
  return _function('select add_code(?, ?)', $code, $name);
}

/**
 * Delete a HXL code.
 *
 * @param $code the HXL code.
 * @return the code database id (long int)
 */
function del_code($code) {
  return _function('select del_code(?)', $code);
}

/**
 * Add a dataset.
 *
 * @param $source the unique source identifier (string)
 * @param $ident the unique dataset identifier (string)
 * @param $name the dataset name (string)
 * @return the dataset database id (long int)
 */
function add_dataset($source, $ident, $name) {
  return _function('select add_dataset(ref_source(?), ?, ?)', $source, $ident, $name);
}

/**
 * Look up the id of a dataset.
 *
 * @param $ident the dataset identifier (string)
 * @return the dataset database id (long int)
 */
function ref_dataset($ident) {
  return _function('select ref_dataset(?)', $ident);
}

/**
 * Add a new import for a dataset.
 *
 * @param $dataset_id the dataset identifier (long int)
 * @return the import id (long int)
 */
function add_import($usr_ident, $source_ident, $dataset_ident) {
  return _function('select add_import(ref_dataset(?, ?), ref_usr(?))', $source_ident, $dataset_ident, $usr_ident);
}

/**
 * Add a new column for an import.
 *
 * @param $import_id the import id (long int)
 * @param $code the HXL field code (string)
 * @param $header the text of the spreadsheet header (string)
 * @return the column id (long int)
 */
function add_col($import_id, $code, $header) {
  return _function('select add_col(?, ref_code(?), ?)', $import_id, $code, $header);
}

/**
 * Add a new row for an import.
 *
 * @return the row id (long int)
 */
function add_row() {
  return _function('select add_row()');
}

/**
 * Add a new value (cell).
 *
 * @param $row_id the database id of the row (long int)
 * @param $col_id the database id of the column (long int)
 * @param $value the cell value (string)
 */
function add_value($row_id, $col_id, $value) {
  return _function('select add_value(?, ?, ?)', $row_id, $col_id, $value);
}

// end
