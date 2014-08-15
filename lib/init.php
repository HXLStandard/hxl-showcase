<?php
error_reporting(E_ALL|E_STRICT);

//
// Global application state
//
$APP = new StdClass();

$APP->root = __DIR__ . '/..';

set_include_path(get_include_path() . PATH_SEPARATOR .
                 $APP->root . "/lib/controllers" . PATH_SEPARATOR .
                 $APP->root . "/lib");

// autoload classes from <classname>.php
spl_autoload_register(function ($class_name) {
  require_once $class_name . '.php';
});

//
// Local configuration
//
$APP->config = new StdClass();
require_once(__DIR__ . '/../config/config.php');

//
// Other includes
//
require_once(__DIR__ . '/smarty/Smarty.class.php');
require_once(__DIR__ . '/util.php');
require_once(__DIR__ . '/data.php');
require_once(__DIR__ . '/output.php');
require_once(__DIR__ . '/paths.php');

//
// Set up the database
//

//
// Fire up the Smarty template engine.
//
// load and configure Smarty
$APP->smarty = new Smarty();
$APP->smarty->error_reporting = 0;
$APP->smarty->template_dir = $APP->root . "/views/templates/";
$APP->smarty->compile_dir = $APP->root . "/views/templates_c/";
$APP->smarty->config_dir = $APP->root . "/views/config/";
$APP->smarty->cache_dir = $APP->root . "/views/cache/";
$APP->smarty->addPluginsDir($APP->root . "/views/plugins");

// end
