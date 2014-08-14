<?php
/**
 * Data access functions.
 */

/**
 * Escape a string for SQL.
 */
function escape_sql($s) {
  $s = str_replace("'", "''", $s);
  return $s;
}

/**
 * Get the database connection.
 */
function db() {
  global $APP;
  return $APP->pdo;
}

/**
 * Execute a SQL query and return the statement with results.
 */
function do_query() {
  $args = func_get_args();
  $query = array_shift($args);
  $statement = db()->prepare($query);
  $statement->execute($args);
  return $statement;
}

/**
 * Start a database transaction.
 */
function begin_db_transaction() {
  db()->beginTransaction();
}

/**
 * Commit a database transaction.
 */
function commit_db_transaction() {
  db()->commit();
}


////////////////////////////////////////////////////////////////////////
// User
////////////////////////////////////////////////////////////////////////

function add_usr($usr, $usr_name) {
  do_query('insert into usr (usr, usr_name) values (?, ?)', $usr, $usr_name);
}


////////////////////////////////////////////////////////////////////////
// Tag
////////////////////////////////////////////////////////////////////////

/**
 * Add a HXL tag.
 */
function add_tag($tag, $tag_name, $datatype) {
  do_query('insert into tag (tag, tag_name, datatype) values (?, ?, ?)', $tag, $tag_name, $datatype);
}

function get_tag($tag_param) {
  return do_query(
    'select * from tag_view where tag=?',
    $tag_param
  )->fetch();
}

function get_tags() {
  static $tags;
  if ($tags == null) {
    $tags = array();
    $result = do_query(
      'select tag from tag'
    );
    foreach ($result as $tag) {
      array_push($tags, $tag->tag);
    }
  }
  return $tags;
}

////////////////////////////////////////////////////////////////////////
// Source
////////////////////////////////////////////////////////////////////////

function add_source($source, $source_name) {
  do_query('insert into source (source, source_name) values (?, ?)', $source, $source_name);
}


////////////////////////////////////////////////////////////////////////
// Dataset
////////////////////////////////////////////////////////////////////////

/**
 * Add a new dataset.
 */
function add_dataset($source, $dataset, $dataset_name) {
  do_query('insert into dataset (source, dataset, dataset_name) values (?, ?, ?)', $source, $dataset, $dataset_name);
}

function get_dataset($dataset_param) {
  return do_query(
    'select * from dataset_view where dataset=?',
    $dataset_param
  )->fetch();
}

////////////////////////////////////////////////////////////////////////
// Import
////////////////////////////////////////////////////////////////////////

/**
 * Add a new import for a dataset.
 */
function add_import($usr, $dataset) {
  do_query('insert into import (usr, dataset) values (?, ?)', $usr, $dataset);
  return do_query('select lastval()')->fetchColumn();
}

function get_imports($dataset_param) {
  return do_query(
    'select V.*, (select count(distinct row) from value_view where import=V.import) as row_count ' .
    'from import_view V ' .
    'where dataset=? order by stamp desc',
    $dataset_param
  );
}

/**
 * Fetch an import for a dataset.
 *
 * @param $dataset_param The identifier of the dataset.
 * @param $stamp_param The timestamp (latest if unspecified).
 * @return The import (from import_view).
 */
function get_import($dataset_param, $stamp_param = null) {
  if ($import_param) {
    return do_query(
      'select * from import_view' .
      ' where dataset=? and stamp=?',
      $dataset_param, $stamp_param
    )->fetch();
  } else {
    return do_query(
      'select * from import_view' .
      ' join latest_import_view using(import)' .
      ' where dataset=?',
      $dataset_param
    )->fetch();
  }
}

////////////////////////////////////////////////////////////////////////
// Column
////////////////////////////////////////////////////////////////////////

/**
 * Add a new column for an import.
 */
function add_col($import, $tag, $header) {
  do_query('insert into col (import, tag, header) values (?, ?, ?)', $import, $tag, $header);
  return do_query('select lastval()')->fetchColumn();
}

/**
 * Get the columns for an import.
 */
function get_cols($import) {
  return do_query(
    'select * from col_view' .
    ' where import=?' .
    ' order by col',
    $import->import
  )->fetchAll();
}

////////////////////////////////////////////////////////////////////////
// Row
////////////////////////////////////////////////////////////////////////

/**
 * Add a new row for an import.
 *
 * @param $import_id the import id (long int)
 * @return the row id (long int)
 */
function add_row($import) {
  do_query('insert into row (row) values (default)');
  return do_query('select lastval()')->fetchColumn();
}

////////////////////////////////////////////////////////////////////////
// Value
////////////////////////////////////////////////////////////////////////

/**
 * Add a new value (cell).
 *
 * @param $row_id the database id of the row (long int)
 * @param $col_id the database id of the column (long int)
 * @param $content the cell content (string)
 */
function add_value($row, $col, $content, $norm = null) {
  do_query('insert into value(row, col, content, norm) values (?, ?, ?, ?)', $row, $col, $content, $norm);
  return do_query('select lastval()')->fetchColumn();
}

/**
 * Get the values for an import.
 */
function get_values($filter_fragment) {
  return do_query(
    'select * from value_view' .
    ' where row in ' . $filter_fragment .
    ' order by row, col'
  );
}

/**
 * Get the values for an import organised by row.
 */
function get_rows($filter_fragment) {
  return new RowIterator(get_values($filter_fragment));
}

/**
 * Return the number of rows in an import.
 */
function get_row_count($import) {
  return do_query(
    'select count(distinct row) from value_view' .
    ' where import=?',
    $import->import
  )->fetchColumn();
}

/**
 * Generate a histogram of a numeric value.
 *
 * Currently hard-coded to 25 buckets.
 */
function get_histogram($tag, $filter_fragment) {
  // Get the bucket size
  $max_value = do_query('select max(norm::float8) from value_view where tag=? and row in ' . $filter_fragment, $tag->tag)->fetchColumn();
  $bucket_size = ceil($max_value / 25);

  $stats = do_query(
    'select bucket || \' to \' || (bucket + ? - 1) as content, count(V.row) as count' .
    ' from generate_series(0, ?, ?) bucket' .
    ' left join value_view V on V.tag=? and bucket=floor(V.norm::float8 / ?)*?' .
    ' where V.value is null or V.row in ' . $filter_fragment .
    ' group by bucket order by bucket', $bucket_size, $max_value, $bucket_size, $tag->tag, $bucket_size, $bucket_size);

  return $stats;
}


/**
 * Process the requested filters, and create a SQL (sub)query.
 *
 * @param $request The incoming HTTP request object.
 * @param $allowed_filters An array of allowed tags for filtering.
 * @return A list containing the SQL fragment and an array of the actual filters selected.
 */
function process_filters(HttpRequest $request, $import_id, $allowed_filters) {

  // Return values
  $sql_filter = '';
  $active_filters = array();

  // Iterate through the filter map and construct the SQL query
  $n = 0;
  foreach ($allowed_filters as $tag) {
    $content = $request->get($tag);
    if ($content !== null) {
      $n++;
      if (is_array($content)) {
        $content = array_pop($content);
      }
      $active_filters[$tag] = $content;

      // Different treatment for the first one
      if ($n == 1) {
        $sql_filter = 'select V1.row from value_view V1';
        $where_clause = sprintf(" where V1.import=%d and V1.tag='%s' and V1.norm='%s'", $import_id, escape_sql($tag), escape_sql(normalise_text($content)));
      } else {
        $sql_filter .= sprintf(
          ' join value_view V%d on V1.row=V%d.row and V%d.tag=\'%s\' and V%d.norm=\'%s\'',
          $n, $n, $n, escape_sql($tag), $n, escape_sql(normalise_text($content))
        );
      }
    }
  }

  if ($sql_filter) {
    $sql_filter = sprintf('(%s %s)', $sql_filter, $where_clause);
  } else {
    // count all rows
    $sql_filter = sprintf('(select R.row from row R join value V using(row) join col C using(col) where C.import=%d)', $import_id);
  }

  // Return the results
  return array($sql_filter, $active_filters);
}

