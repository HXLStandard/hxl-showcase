<?php
/**
 * Add a new source to the database
 *
 * Usage: php add-source.php <ident> <name>
 *
 * ident: the short identifier for the source (e.g. "unhcr")
 *
 * name: the human-readable name for the dataset (e.g. "United Nations
 * High Commissioner for Refugees").
 */

require_once(__DIR__ . '/../lib/init.php');

if (count($argv) != 3) {
  die("Usage: php add-source.php <ident> <name>\n");
} else {
  list($script, $ident, $name) = $argv;
}

add_source($ident, $name);

printf("Added source %s (%s)\n", $ident, $name);

// end
