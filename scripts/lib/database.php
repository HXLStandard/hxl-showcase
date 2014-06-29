<?php

require_once(__DIR__ . '/config.php');

global $connection;

$dsn = sprintf("pgsql:host=%s;dbname=%s;user=%s;password=%s", $DB['hostname'], $DB['database'], $DB['username'], $DB['password']);
$connection = new PDO($dsn);