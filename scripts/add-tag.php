<?php
/**
 * Add a new HXL tag to the database.
 *
 * Usage: php add-tag.php <tag> <name>
 *
 * tag: the unique HXL tag (e.g. "sector")
 *
 * name: the human-readable name of the data element (e.g. "Cluster or
 * sector").
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-tag.php <tag> <name>\n");
} else {
  list($script, $tag, $name) = $argv;
}

add_tag($tag, $name);

printf("Added HXL tag %s (%s)\n", $tag, $name);

// end

