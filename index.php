<?php
	//error_reporting( E_ERROR );
	//ob_start();
	session_start();
	define('ROOT', dirname(__FILE__));
	require_once(ROOT.'/vendor/autoload.php');
	require_once(ROOT.'/config/database.php');
	$config = require_once(ROOT.'/config/dbdata.php');
	$loader = new Twig_Loader_Filesystem('views');
	$twig = new Twig_Environment($loader, array('cache' => false,));
	$db = DataBase::connect(
	$config['mysql']['host'],
	$config['mysql']['dbname'],
	$config['mysql']['user'],
	$config['mysql']['pass']
	);
	
	$telegram_url = file_get_contents('https://api.telegram.org/bot345048729:AAFDtYHaor5E-5NxcL8Kd1BpAeu7Gujex60/setWebhook?url=http://ibush.herokuapp.com/index.php');
	$data = json_decode($telegram_url, true);
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	
	require_once'app/Router.php';
	$router = new Router();
	$router->run($db, $twig);

?>