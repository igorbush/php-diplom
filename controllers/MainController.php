<?php
class MainController 
{

	public $model = null;
	public function __construct($db)
	{
		include_once 'models/main.php';
		$this->model = new Main($db);
	}

	public function actionIndex() 
	{
		$categories = $this->model->getCategories();
		$questions = $this->model->getQuestionsByCat($category['category']);
		if (isset($_POST['insertQuestion']) && (empty($_POST['question']) || empty($_POST['author']) || empty($_POST['email']) || empty($_POST['category_id']))) 
		{
			$alert = 'Не все поля введены';
		} 
		else
		{
			$alert = 'Заполните форму, что бы задать вопрос';
		}
		
		include_once('views/main.php');
	}

	public function actionAdd() 
	{
		if (isset($_POST['insertQuestion'])) 
		{
			if (!empty($_POST['question']) && !empty($_POST['author']) && !empty($_POST['email']) && !empty($_POST['category_id']))
			{
				$question = trim(strip_tags($_POST['question']));
				$author = trim(strip_tags($_POST['author']));
				$email = trim(strip_tags($_POST['email']));
				$category_id = $_POST['category_id'];
				$this->model->addQuestion($question, $author, $email, $category_id);
				header("Location: /main");
			}
		}
	}

}
?>