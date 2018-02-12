<?php

class AdminController 
{

	public $model = null;
	public function __construct($db, $twig)
	{
		include_once 'models/admin.php';
		$this->model = new Admin($db);
		$this->twig = $twig;
	}

	public function actionLogin() 
	{
		if (!empty($_POST['login']) && !empty($_POST['password'])) 
		{
			$login = trim(strip_tags($_POST['login']));
			$password = md5(trim(strip_tags($_POST['password'])));
			if (!($this->model->getAdmin($login, $password))) 
			{
				$errors = 'неверные данные';
			}
		}
		else
		{
			$errors = 'Не все поля введены';
		}
		$template = $this->twig->loadTemplate('login.php');
		echo $template->render(['errors'=>$errors, 'checklogin'=>$_POST['checklogin']]);

	}

	public function actionCheck() 
	{
		if (isset($_POST['checklogin'])) 
		{
			if (!empty($_POST['login']) && !empty($_POST['password'])) 
			{
				$login = trim(strip_tags($_POST['login']));
				$password = md5(trim(strip_tags($_POST['password'])));
				if ($this->model->getAdmin($login, $password)) 
				{
					$_SESSION['user'] = $login;
					header("Location:/admin/questions");
				}
				else 
				{
					$errors = 'неверные данные';
				}
			}
			else
			{
				$errors = 'Не все поля введены';
			}
		}
	}

	public function actionLogOut() 
	{
		session_destroy();
		header("Location: /main");
	}
}

?>