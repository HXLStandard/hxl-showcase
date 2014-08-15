<?php
/**
 * Global initialisation file for each HTTP request.
 */

//
// Global application state
//
$APP = new StdClass();
$APP->root = __DIR__ . '/..';
set_include_path(get_include_path() . PATH_SEPARATOR .
                 $APP->root . "/lib/controllers" . PATH_SEPARATOR .
                 $APP->root . "/lib");

//
// Local configuration
//
$APP->config = new StdClass();
require_once(__DIR__ . '/../config/config.php');

//
// Load source code modules
//
require_once(__DIR__ . '/smarty/Smarty.class.php');
require_once(__DIR__ . '/util.php');
require_once(__DIR__ . '/data.php');
require_once(__DIR__ . '/output.php');
require_once(__DIR__ . '/paths.php');

//
// Configure the database connection
//
if (@$APP->config->database_dsn) {
  $APP->pdo = new PDO($APP->config->database_dsn, @$APP->config->database_username, @$APP->config->database_password);
  $APP->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $APP->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}

//
// Configure the template engine
//
$APP->smarty = new Smarty();
$APP->smarty->error_reporting = 0;
$APP->smarty->template_dir = $APP->root . "/views/templates/";
$APP->smarty->compile_dir = $APP->root . "/views/templates_c/";
$APP->smarty->config_dir = $APP->root . "/views/config/";
$APP->smarty->cache_dir = $APP->root . "/views/cache/";
$APP->smarty->addPluginsDir($APP->root . "/views/plugins");

//
// Autoload classes from <classname>.php (needs to stay at end)
//
spl_autoload_register(function ($class_name) {
  require_once $class_name . '.php';
});

// end
