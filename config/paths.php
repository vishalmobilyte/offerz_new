<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

define ("MAX_SIZE","20000"); // 20MB MAX file size

$host = $_SERVER['HTTP_HOST'];
$root_path = $_SERVER['DOCUMENT_ROOT'];
//print_r($_SERVER); die;
	if($host == 'localhost' || $host == 'betasoftdev.com' ){
	define('FRONT_SITE_LINK', "http://". $host."/darren_front/");
	$req_uri = explode('/',$_SERVER['REQUEST_URI']);
	$proj_folder_name = $req_uri[1];
	define('SITE_URL', "http://". $host."/".$proj_folder_name."/");
	define('DOCUMENT_ROOT', $root_path."/".$proj_folder_name);
	if( $host == 'betasoftdev.com'){
	define('DB_NAME', 'darren_offerz');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'darren_offerz');
	define('DB_PASS', 'mind@123');
	
	}
	else{
	define('DB_NAME', 'darren_offerz');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	}
	}
	
	else{
	
	define('FRONT_SITE_LINK', "http://dev.offerz.co");
	define('SITE_URL', "http://". $host."/");
	define('DOCUMENT_ROOT', $root_path."/");
	
	define('DB_NAME', 'offerz_new');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'offerz_darren');
	define('DB_PASS', 'mind@123');
	
	}
	
