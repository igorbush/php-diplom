<?php
class QuestionsController 
{

	public $model = null;
	public function __construct($db)
	{
		include_once 'models/questions.php';
		$this->model = new Questions($db);
	}

	public function actionGetQuestions() 
	{
		$counts = $this->model->countQuestions();
		foreach($counts as $count) 
		{
			$fullquestions = $count['questions'];
			$answers = $count['answers'];
		}
		$categories = $this->model->getCategories();
		if (isset($_POST['sort'])) 
		{
			if (!empty($_POST['category'])) 
			{
				$category_id = $_POST['category'];
				$questions = $this->model->getAllByCategory($category_id);
			}
			elseif (!empty($_POST['answer']) && $_POST['answer'] == 'yes') 
			{
				$questions = $this->model->getAllByAnswer();
			}
			elseif (!empty($_POST['answer']) && $_POST['answer'] == 'no') 
			{
				$questions = $this->model->getAll();
			}
			elseif ((!empty($_POST['answer'])) && ($_POST['answer'] == 'yes') && (!empty($_POST['category'])))
			{
				$category_id = $_POST['category'];
				$questions = $this->model->getAllSort($category_id);
			}
			elseif (!empty($_POST['answer']) && $_POST['answer'] == 'no' && !empty($_POST['category']))
			{
				$category_id = $_POST['category'];
				$questions = $this->model->getAllByCategory($category_id);
			}
			else
			{
				$questions = $this->model->getAll();
			}
		}
		else 
		{
		$questions = $this->model->getAll();
		}
		require_once 'views/adminQuestions.php';
	}

	public function actionVisibleQuestion($id) 
	{
		$this->model->getVisible($id);
		header("Location:/admin/questions");
	}

	public function actionInvisibleQuestion($id) 
	{
		$this->model->getInvisible($id);
		header("Location:/admin/questions");
	}

	public function actionDeleteQuestion($id) 
	{
		$this->model->delete($id);
		header("Location:/admin/questions");
	}

	public function actionChangeCategory() 
	{
		if(isset($_POST['change'])) 
		{
			$id = $_POST['id'];
			$category_id = $_POST['category_id'];
			$this->model->changeCategory($id, $category_id);
			header("Location:/admin/questions");
		}
	}

}
?>