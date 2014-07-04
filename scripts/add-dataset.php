<?php
/**
 * Add a new dataset to the database
 *
 * Usage: php add-dataset.php <source> <ident> <name>
 *
 * source: the unique identifier for the source (e.g. "unhcr")
 *
 * ident: the short identifier for the dataset (e.g. "refugees")
 *
 * name: the human-readable name for the dataset (e.g. "UNHCR refugee
 * statistics")
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 4) {
  die("Usage: php add-dataset.php <source> <ident> <name>\n");
} else {
  list($script, $source, $ident, $name) = $argv;
}

add_dataset($source, $ident, $name);

printf("Added dataset %s/%s (%s)\n", $source, $ident, $name);

// end

