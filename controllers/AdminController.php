<?php

class AdminController 
{

	public $model = null;
	public function __construct($db)
	{
		include_once 'models/admin.php';
		$this->model = new Admin($db);
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
		require_once 'views/login.php';

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