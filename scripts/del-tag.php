<?php
/**
 * Delete a HXL tag from the database
 *
 * Usage: php del-tag.php <tag>
 *
 * tag: the unique HXL tag (e.g. "sector").
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 2) {
  die("Usage: php del-tag.php <tag>\n");
} else {
  list($script, $tag) = $argv;
}

if (del_tag($tag)) {
  printf("Deleted tag %s\n", $tag);
} else {
  printf("Tag %s not found\n", $tag);
}

// end


