<?php
////////////////////////////////////////////////////////////////////////
// Database configuration
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->config = new stdClass();
$APP->config->database_dsn = 'pgsql:host=localhost;dbname=blue';
$APP->config->database_username = 'blue';
$APP->config->database_password = 'monster';

if (@$APP->config->database_dsn) {
  $APP->pdo = new PDO($APP->config->database_dsn, @$APP->config->database_username, @$APP->config->database_password);
  $APP->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $APP->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
