<?php
////////////////////////////////////////////////////////////////////////
// Application configuration
////////////////////////////////////////////////////////////////////////

global $APP;

//
// Google Analytics tracking id (uncomment if available)
//
$APP->ga_tracking_id = 'UA-48221887-4';

//
// Database configuration
//
$APP->config = new stdClass();
$APP->config->database_dsn = 'pgsql:host=localhost;dbname=blue';
$APP->config->database_username = 'blue';
$APP->config->database_password = 'monster';

if (@$APP->config->database_dsn) {
  $APP->pdo = new PDO($APP->config->database_dsn, @$APP->config->database_username, @$APP->config->database_password);
  $APP->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $APP->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
