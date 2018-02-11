<?php
class QuestionController 
{

	public $model = null;
	public function __construct($db)
	{
		include_once 'models/question.php';
		$this->model = new Question($db);
	}

	public function actionGetQuestion($id) 
	{
		$counts = $this->model->countQuestions();
		foreach($counts as $count) 
		{
			$fullquestions = $count['questions'];
			$answers = $count['answers'];
		}
		$question = $this->model->get($id);
		require_once 'views/adminQuestion.php';
	}
	
	public function actionUpdateQuestion() 
	{
		if(isset($_POST['update'])) 
		{
			$id = (int)$_POST['id'];
			$question = trim(strip_tags($_POST['question']));
			$answer = trim(strip_tags($_POST['answer']));
			$author = trim(strip_tags($_POST['author']));
			$email = trim(strip_tags($_POST['email']));

			if ($_POST['visibility'] == 'NULL' && !empty($_POST['answer'])) 
			{
				$question = $this->model->update($id, $question, $author, $email, $answer);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == '1' && !empty($_POST['answer'])) 
			{
				$question = $this->model->updatePublic($id, $question, $author, $email, $answer);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == 'NULL' && empty($_POST['answer'])) 
			{
				$question = $this->model->update($id, $question, $author, $email);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == '1' && empty($_POST['answer'])) 
			{
				header("Location:/admin/edit-question/$id?error=true");
			}
		}
	}

}
?>