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
  
  private $statement;
  private $row_count;
  private $current_row = array();

  function __construct(PDOStatement $statement) {
    $this->statement = $statement;
  }

  function rewind() {
    $this->next();
  }

  function current() {
    return $this->current_row;
  }

  function key() {
    return $this->current_row_number;
  }

  function next() {
    $n = -1;
    $this->current_row = array();
    foreach ($this->statement as $value) {
      if ($value->row != $n && $n != -1) {
        $this->current_row_number++;
        return;
      } else {
        $n = $value->row;
        array_push($this->current_row, $value);
      }
    }
    $this->current_row_number = -1;
  }

  function valid() {
    return ($this->current_row_number > -1);
  }

}