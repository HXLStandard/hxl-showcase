<?php
////////////////////////////////////////////////////////////////////////
// Application configuration
////////////////////////////////////////////////////////////////////////

global $APP;

//
// Google Analytics tracking id (uncomment if available)
//
//$APP->ga_tracking_id = 'XXXXXX-XX'; 

//
// Database configuration
//
$APP->config = new stdClass();
$APP->config->database_dsn = 'mysql:host=localhost;dbname=hxl';
$APP->config->database_username = 'username';
$APP->config->database_password = 'password';

if (@$APP->config->database_dsn) {
  $APP->pdo = new PDO($APP->config->database_dsn, @$APP->config->database_username, @$APP->config->database_password);
}

// end
