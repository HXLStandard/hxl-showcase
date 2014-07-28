<?php
/**
 * Product a CSV-formatted list of all HXL tags known to the system.
 *
 * Usage: php list-tags.php
 *
 * The output is suitable for use by the import-tags.php script.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 1) {
  die("Usage: php list-tags.php\n");
}

fputcsv(STDOUT, array('tag', 'name'));

$statement = _query('select * from tag');
while ($tag = $statement->fetch()) {
  fputcsv(STDOUT, array($tag->tag, $tag->name));
}

// end
