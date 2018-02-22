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
	$chat_id = $update['message']['chat']['id'];
	$mesage = $update['message']['text'];
	$author = $update['message']['from']['first_name'] .' '. $update['message']['from']['last_name'];
	$email = $update['message']['from']['id'];
	if ($mesage == '/start') {
		sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Задайте вопрос по теме веб-разработки']);
	} else {
		$query = "INSERT INTO questions (question, date_added, author, email, chat_id, category_id) VALUES (?, now(), ?, ?, ?, 11)";
		$sth = $db->prepare($query); 
		$sth->bindValue(1, $mesage, PDO::PARAM_STR);
		$sth->bindValue(2, $author, PDO::PARAM_STR);
		$sth->bindValue(3, $email, PDO::PARAM_STR);
		$sth->bindValue(4, $chat_id, PDO::PARAM_INT);
		$sth->execute();
		sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Спасибо за обращение! Мы ответим Вам в ближайшее время.']);
	}
	
	require_once'app/Router.php';
	$router = new Router();
	$router->run($db, $twig);

?>