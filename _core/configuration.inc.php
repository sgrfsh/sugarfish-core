<?php
/**
 * File: configuration.inc.php
 * Created on: Thu Sep 21 17:15 CST 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 *
 * Global Definitions file
 */

/**
 * Set the timezone
 * 
 */
putenv("TZ=America/Los_Angeles");

/**
 * Setup the default timezone (if not already specified in php5.ini)
 * 
 */
if ((function_exists('date_default_timezone_set')) && (!ini_get('date.timezone'))) {
	date_default_timezone_set('America/Los_Angeles');
}

/**
 * Set locale currency type (USD)
 * 
 */
setlocale(LC_MONETARY, 'en_US.UTF-8');

define ('__URL_REWRITE__', 'apache');

/**
 * Versioning information
 */
define('__VERSION__', '0.3.0');
define('__ASSET_VERSION__', '2011.11.09');

/**
 * All your base are belong to us ...
 * Domain Settings
 * Docroot Settings
 * Database Settings
 * Google Maps API Key
 * Server Name
 */
define('__DOMAIN__', 'http://sugarfish-core.dev');
define('__COOKIE_DOMAIN__', 'sugarfish-core.dev');

define('__DOCROOT__', '/repo/www/htdocs');

/**
 * Database settings
 */
// core db
define('__DB__', 'dev');
define('__DB_SERVER__', 'localhost');
define('__DB_USERNAME__', 'username');
define('__DB_PASSWORD__', 'password');

/**
 * Third party settings
 */
//define('__GOOGLE_MAPS_API_KEY__', 'ABQIAAAAQFRLPHKFxepWZj5hvfdErRQYcbFcMftnpwXU0Y_lTUyVdYoPdxQ6MVrKwPqKMd96-TWB3rP31r-TVQ');

/**
 * Class and Include locations
 */
define('__CORE__', __DOCROOT__ . '/_core');
define('__INCLUDES__', __CORE__ . '/includes');
define('__CLASSES__', __CORE__ . '/classes');
define('__CUSTOM__', __CLASSES__ . '/custom');
define('__SERVICES__', __CLASSES__ . '/services');

define('__USER__', __DOCROOT__ . '/_user');
define('__USER_CLASSES__', __USER__ . '/classes');

/**
 * Define asset locations
 */
define('__ASSETS__', '/assets');
define('__CSS__', __ASSETS__ . '/css');
define('__IMAGES__', __ASSETS__ . '/images');
define('__JAVASCRIPT__', __ASSETS__ . '/js');
define('__XML__', __DOCROOT__ . '/assets/xml');

/**
 * Logging
 */
define('__LOG_VERBOSE__', true);

/**
 * Default Controller
 */
define('__DEFAULT_CONTROLLER__', 'index');
?>
