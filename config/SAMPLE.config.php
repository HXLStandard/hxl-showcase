<?php
////////////////////////////////////////////////////////////////////////
// Application configuration
////////////////////////////////////////////////////////////////////////

//
// Set your preferred error reporting here.
//
error_reporting(E_ALL|E_STRICT);

//
// Google Analytics tracking id (uncomment if available)
//
//$APP->config->ga_tracking_id = 'XXXXXX-XX'; 

//
// Database configuration
//
$APP->config = new stdClass();
$APP->config->database_dsn = 'mysql:host=localhost;dbname=hxl';
$APP->config->database_username = 'username';
$APP->config->database_password = 'password';

// end
