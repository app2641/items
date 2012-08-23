<?php
/**
 * GEMINI
 * Copyright (c) 2011 iii-planning.com
 */

/* APCバグのため無効化 */
ini_set('apc.cache_by_default', 0);
 
set_include_path('../library' . PATH_SEPARATOR . get_include_path());

require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->unregisterNamespace(array('Zend_', 'ZendX_'))
           ->setFallbackAutoloader(true);


defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

if (in_array(getenv('REMOTE_ADDR'), array('127.0.0.1'))) {
    $env = 'development';

} else {
    $env = 'production';
}

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : $env));


$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/api.ini'
);

try {

    $application->bootstrap();
    $front = $application->getBootstrap()->getResource('FrontController');
    $front->addControllerDirectory(APPLICATION_PATH.'/modules/direct/controllers');
    $front->setDefaultControllerName('api');
    $application->run();
} catch (Exception $e) {

    print_r($e);
    exit();
}

