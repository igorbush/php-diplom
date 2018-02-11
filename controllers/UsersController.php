<?php

class UsersController 
{

	public $model = null;
	public function __construct($db)
	{
		include_once 'models/users.php';
		$this->model = new Users($db);
	}

	public function actionUsers() 
	{
		$counts = $this->model->countQuestions();
		foreach($counts as $count) 
		{
			$fullquestions = $count['questions'];
			$answers = $count['answers'];
		}
		$admins = $this->model->getAll();
		require_once 'views/adminUsers.php';
	}

	public function actionAddUser() 
	{
		if (isset($_POST['newadmin'])) 
		{
			if (!empty($_POST['login']) && !empty($_POST['password'])) 
			{
				$login = trim(strip_tags($_POST['login']));
				$password = md5(trim(strip_tags($_POST['password'])));
				if (!$this->model->getAdmin($login, $password))
				{
					$this->model->add($login, $password);
					header("Location:/admin/users");
				}
				else
				{
					header("Location:/admin/users/?error=duble");
				}
			}
			else
			{
				header("Location:/admin/users/?error=empty");
			}
		}
	}

	public function actionDeleteUser($id) 
	{
		$this->model->delete($id);
		header("Location:/admin/users");
	}

	public function actionChangePassword() 
	{
		if (isset($_POST['changepassword'])) 
		{
			if (!empty($_POST['old']) && !empty($_POST['new'])) 
			{
				$id = $_POST['id'];
				$login = trim(strip_tags($_POST['login']));
				$oldpass = md5(trim(strip_tags($_POST['old'])));
				$newpass = md5(trim(strip_tags($_POST['new'])));
				if ($this->model->getAdmin($login, $oldpass)) 
				{
					$this->model->update($id, $newpass);
					header("Location:/admin/users");
				}
				else 
				{
					header("Location:/admin/users/?error=wrongpass");
					
				}
			}
			else
			{
				header("Location:/admin/users/?error=empty");
				
			}
		}	
	}

}

?>