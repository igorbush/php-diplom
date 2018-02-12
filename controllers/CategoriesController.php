<?php
class CategoriesController 
{

	public $model = null;
	public function __construct($db, $twig)
	{
		include_once 'models/categories.php';
		$this->model = new Categories($db);
		$this->twig = $twig;
	}

	public function actionGetCategories() 
	{
		$counts = $this->model->countQuestions();
		foreach($counts as $count) 
		{
			$fullquestions = $count['questions'];
			$answers = $count['answers'];
		}
		$categories = $this->model->getAll();
		$template = $this->twig->loadTemplate('adminCategories.php');
		echo $template->render(['categories'=>$categories, 'error'=>$_GET['error'], 'session_user'=>$_SESSION['user'], 'fullquestions'=>$fullquestions, 'answers'=>$answers]);
	}

	public function actionDeleteCategory($id) 
	{
		$this->model->delete($id);
		header("Location:/admin/categories");
	}

	public function actionCreateCategory() 
	{
		if(isset($_POST['create'])) 
		{
			if(!empty($_POST['category']))
			{
				$name = trim(strip_tags($_POST['category']));
				$this->model->create($name);
				header("Location:/admin/categories");
			}
			else
			{
				header("Location:/admin/categories/?error=empty");
				echo 'вы не ввели название категории';
			}
		}
	}

	public function actionChangeCategory() 
	{
		if(isset($_POST['change'])) 
		{
			if(!empty($_POST['name']))
			{
				$id = $_POST['id'];
				$name = trim(strip_tags($_POST['name']));
				$this->model->update($id, $name);
				header("Location:/admin/categories");
			}
			else
			{
				header("Location:/admin/categories/?error=empty");
				echo 'Вы не ввели название категории';
			}
		}
	}
	
}
?>