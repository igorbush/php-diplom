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
	
	define('TOKEN', '345048729:AAFDtYHaor5E-5NxcL8Kd1BpAeu7Gujex60');
	define('BASE_URL', 'https://api.telegram.org/bot' . TOKEN . '/');
	$update = json_decode(file_get_contents('php://input'), true);

	function sendRequest($method, $params = [])
	{
		if (!empty($params)) {
			$url = BASE_URL . $method . '?' . http_build_query($params);
		} else {
			$url = BASE_URL . $method;
		}
		return json_decode(file_get_contents($url), true);
	}
	$time = date('H:m:s');
	$chat_id = $update['message']['chat']['id'];
	$mesage = $update['message']['text'];
	if ($mesage == '/start') {
		sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Спросите у меня время']);
	} else {
		sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $time]);
	}
	
	require_once'app/Router.php';
	$router = new Router();
	$router->run($db, $twig);

?>