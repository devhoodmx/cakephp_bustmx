<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));
define('APP_DIR', basename(dirname(dirname(__FILE__))));
define('WEBROOT_DIR', basename(dirname(__FILE__)));
define('WWW_ROOT', dirname(__FILE__) . DS);

if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	if (function_exists('ini_set')) {
		ini_set('include_path', ROOT . DS . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
	}
	if (!include('Cake' . DS . 'bootstrap.php')) {
		$failed = true;
	}
} else {
	if (!include(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'bootstrap.php')) {
		$failed = true;
	}
}
if (!empty($failed)) {
	trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
}

App::uses('Package', 'Lib/Utility');

$resources = isset($_GET['resources']) ? explode(',', $_GET['resources']) : array();
$compressed = isset($_GET['compressed']) ? $_GET['compressed'] : false;
$cache = isset($_GET['cache']) ? $_GET['cache'] : true;
$package = new Package($resources, 'js', $compressed, $cache);
$package->render();
?>