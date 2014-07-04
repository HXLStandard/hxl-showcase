<?php
/**
 * Add a new HXL code to the database.
 *
 * Usage: php add-code.php <code> <name>
 *
 * code: the unique HXL code (e.g. "sector")
 *
 * name: the human-readable name of the data element (e.g. "Cluster or
 * sector").
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-code.php <code> <name>\n");
} else {
  list($script, $code, $name) = $argv;
}

add_code($code, $name);

printf("Added HXL code %s (%s)\n", $code, $name);

// end

