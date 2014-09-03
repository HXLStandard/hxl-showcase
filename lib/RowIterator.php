<?php

/**
 * Class to iterate over values by row.
 *
 * Values returned by a database query are in a single long
 * stream. This iterator breaks those up into individual rows. It
 * reads the values from a SQL query as needed, so that they aren't
 * all in memory at once for large result sets.
 *
 * This interface does not implement Countable, so a call to
 * iterator_count will exhaust the rows.
 */
class RowIterator implements Iterator {

  private $cols;
  private $statement;
  private $row_count;
  private $current_row_number = -1;
  private $next_row_value = null;

  /**
   * @param $cols An array of col items for structuring each row.
   * @param $statement A PDO statement for retrieving the values,
   * sorted by row and col.
   */
  function __construct($cols, PDOStatement $statement) {
    $this->cols = $cols;
    $this->statement = $statement;
  }

  /**
   * Implement Iterator->rewind()
   */
  function rewind() {
    $this->next();
  }

  /**
   * Implement Iterator->current()
   */
  function current() {
    return $this->current_row;
  }

  /**
   * Implement Iterator->key()
   */
  function key() {
    return $this->current_row_number;
  }

  /**
   * Implement Iterator->next()
   */
  function next() {
    $n = -1;

    $lazy_values = array();

    // Do we have a value left over from the last pass?
    if ($this->next_row_value !== null) {
      $lazy_values[$this->next_row_value->col] = $this->next_row_value;
      $this->next_row_value = null;
    }

    // Read all the values that belong to the same row.
    foreach ($this->statement as $value) {

      // Terminal condition: a new row has started.
      if ($value->row != $n && $n != -1) {
        $this->current_row_number++;
        $this->next_row_value = $value;
        $this->current_row = $this->make_row($lazy_values);
        return;
      } 

      // Regular condition: add to the current row.
      else {
        $n = $value->row;
        $lazy_values[$value->col] = $value;
      }
    }

    // End of file condition: we didn't find any values.
    $this->current_row_number = -1;
  }

  /**
   * Implement Iterator->valid()
   */
  function valid() {
    return ($this->current_row_number > -1);
  }

  /**
   * Order and pad a lazy row of values.
   *
   * @param $lazy_values An array of values with nulls omitted.
   * @return An array of values sorted in col order, with null padding added.
   */
  private function make_row($lazy_values) {
    $row = array();
    foreach ($this->cols as $col) {
      $row[$col->col] = $lazy_values[$col->col];
    }
    return $row;
  }

}