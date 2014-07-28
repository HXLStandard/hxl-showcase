<?php
/**
 * Import HXL tags from a CSV file
 *
 * Usage: php import-tags.php [-r] < SOURCE.csv
 *
 * -r means remove all existing tags before reimporting
 *
 * SOURCE.csv is a CSV file with (at least) the headers "tag" and
 * "name"
 *
 * If there's any problem, the script will fail completely, and the
 * database will be unchanged.
 */

require_once(__DIR__ . '/lib/database.php');

if (count($argv) > 2 || (count($argv) == 2 && $argv[1] != '-r')) {
  die("Usage: php import-tags.php [-r] < SOURCE.csv\n");
}

// Use a transaction, so that it's all or nothing
_db()->beginTransaction();

// if "-r" is specified, delete old tags first
@list($script, $replace_flag) = $argv;
if ($replace_flag) {
  print("Deleting old tags\n");
  _query('delete from tag');
}

$headers = fgetcsv(STDIN);
$n = 1; // count rows for error reporting
while ($row = fgetcsv(STDIN)) {
  $n++;
  $fields = array_combine($headers, $row);

  foreach (array('tag', 'name', 'type') as $header) {
    if (!$fields[$header]) {
      die(sprintf("Missing value %s in row %d\n", $header, $n));
    }
  }

  if (substr($fields['tag'], 0 ,1) != '#') {
    die(sprintf("Tag \"%s\" does not start with '#'\n", $fields['tag']));
  } else {
    $tag = substr($fields['tag'], 1);
  }
      
  add_tag($tag, $fields['name'], $fields['type']);
  printf("Added tag %s (%s) %s\n", $fields['tag'], $fields['name'], $fields['type']);
}

_db()->commit();

// end
