<?php
class QuestionsController 
{

	public $model = null;
	public function __construct($db, $twig)
	{
		include_once 'models/questions.php';
		$this->model = new Questions($db);
		$this->twig = $twig;
	}

	public function actionGetQuestions() 
	{
		$counts = $this->model->countQuestions();
		foreach($counts as $count) {
			$fullquestions = $count['questions'];
			$answers = $count['answers'];
		}
		$categories = $this->model->getCategories();
		if (!isset($_POST['sort'])) {
			$questions = $this->model->getAll();
		} else {
			$category = $_POST['category'];
			$answer = $_POST['answer'];
			if(!empty($answer) && $answer == 'yes' && !empty($category)) {
				$questions = $this->model->getAllSort($category);
			}
			elseif (!empty($category)) {
				$questions = $this->model->getAllByCategory($category);
			}
			elseif (!empty($answer) && $answer == 'yes') {
				$questions = $this->model->getAllByAnswer();
			} else {
				$questions = $this->model->getAll();
			}
		}
		$template = $this->twig->loadTemplate('adminQuestions.php');
		echo $template->render(['categories'=>$categories, 'questions'=>$questions, 'session_user'=>$_SESSION['user'], 'fullquestions'=>$fullquestions, 'answers'=>$answers]);
	}

	public function actionVisibleQuestion($id) 
	{
		$this->model->getVisible($id);
		$action = 'visible';
		$this->model->writeLogs($id, $action, $_SESSION['user']);
		header("Location:/admin/questions");
	}

	public function actionInvisibleQuestion($id) 
	{
		$this->model->getInvisible($id);
		$action = 'invisible';
		$this->model->writeLogs($id, $action, $_SESSION['user']);
		header("Location:/admin/questions");
	}

	public function actionDeleteQuestion($id) 
	{
		$action = 'delete';
		$this->model->writeLogs($id, $action, $_SESSION['user']);
		$this->model->delete($id);
		header("Location:/admin/questions");
	}

	public function actionChangeCategory() 
	{
		if(isset($_POST['change'])) {
			$id = $_POST['id'];
			$category_id = $_POST['category_id'];
			$this->model->changeCategory($id, $category_id);
			$action = 'change_category';
			$this->model->writeLogs($id, $action, $_SESSION['user']);
			header("Location:/admin/questions");
		}
	}

}
?>