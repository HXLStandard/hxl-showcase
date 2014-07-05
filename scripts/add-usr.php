<?php
/**
 * Add a new user to the database
 *
 * Usage: php add-user.php <ident> <name>
 *
 * ident: the short identifier for the user (e.g. "jsmith")
 *
 * name: the human-readable name for the dataset (e.g. "Jane Smith")
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) != 3) {
  die("Usage: php add-usr.php <ident> <name>\n");
} else {
  list($script, $ident, $name) = $argv;
}

add_usr($ident, $name);

printf("Added user %s (%s)\n", $ident, $name);

// end

