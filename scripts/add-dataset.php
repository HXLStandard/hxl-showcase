<?php
/**
 * Add a new dataset to the database
 *
 * Usage: php add-dataset.php <ident> <name>
 *
 * ident: the short identifier for the dataset (e.g. "unhcr")
 *
 * name: the human-readable name for the dataset (e.g. "UNHCR refugee
 * statistics")
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-dataset.php <ident> <name>\n");
} else {
  list($script, $ident, $name) = $argv;
}

add_dataset($ident, $name);

printf("Added dataset %s (%s)\n", $ident, $name);

// end

