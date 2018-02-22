<?php
class QuestionController 
{

	public $model = null;
	public function __construct($db, $twig)
	{
		include_once 'models/question.php';
		$this->model = new Question($db);
		$this->twig = $twig;
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
		$template = $this->twig->loadTemplate('adminQuestion.php');
		echo $template->render(['error'=>$_GET['error'], 'questions'=>$question, 'session_user'=>$_SESSION['user'], 'fullquestions'=>$fullquestions, 'answers'=>$answers]);
	}
	
	public function actionUpdateQuestion() 
	{
		if(isset($_POST['update'])) {
			$id = (int)$_POST['id'];
			$question = trim(strip_tags($_POST['question']));
			$answer = trim(strip_tags($_POST['answer']));
			$author = trim(strip_tags($_POST['author']));
			$email = trim(strip_tags($_POST['email']));

			if ($_POST['visibility'] == 'NULL' && !empty($_POST['answer'])) {
				$upd = $this->model->update($id, $question, $author, $email, $answer);
				$action = 'update_and_invisible';
				$this->model->writeLogs($id, $action, $_SESSION['user']);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == '1' && !empty($_POST['answer'])) {
				$upd = $this->model->updatePublic($id, $question, $author, $email, $answer);
				$chat_id = $this->model->getForTelegram($id);
				$answer_for_telegram = "Мы подготовили ответ на Ваш вопрос \r\n" . $question . " \r\n \r\n" . $answer;
				sendRequest('sendMessage', ['chat_id' => $chat_id['chat_id'], 'text' => $answer_for_telegram]);
				$action = 'update_and_visible';
				$this->model->writeLogs($id, $action, $_SESSION['user']);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == 'NULL' && empty($_POST['answer'])) {
				$upd = $this->model->update($id, $question, $author, $email);
				$action = 'update';
				$this->model->writeLogs($id, $action, $_SESSION['user']);
				header("Location:/admin/questions");
			}

			elseif($_POST['visibility'] == '1' && empty($_POST['answer'])) {
				header("Location:/admin/edit-question/$id?error=true");
			}
		}
	}

}
?>