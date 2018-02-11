<?php
	error_reporting( E_ERROR );
	ob_start();
	session_start();
	define('ROOT', dirname(__FILE__));
	require_once(ROOT.'/vendor/autoload.php');
	require_once(ROOT.'/config/database.php');
	$config = require_once(ROOT.'/config/dbdata.php');
	$db = DataBase::connect(
	$config['mysql']['host'],
	$config['mysql']['dbname'],
	$config['mysql']['user'],
	$config['mysql']['pass']
	);
	require_once('/app/Router.php');
	$router = new Router();
	$router->run($db);

?>