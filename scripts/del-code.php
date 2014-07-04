<?php
/**
 * Delete a HXL code from the database
 *
 * Usage: php del-code.php <code>
 *
 * code: the unique HXL code (e.g. "sector").
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 2) {
  die("Usage: php del-code.php <code>\n");
} else {
  list($script, $code) = $argv;
}

if (del_code($code)) {
  printf("Deleted code %s\n", $code);
} else {
  printf("Code %s not found\n", $code);
}

// end


