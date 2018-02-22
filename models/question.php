<?php

class Question
{

	public $db = null;

	/**
	* Question constructor.
	* @param object(PDO) $db
	*/

	public function __construct($db) 
	{
		$this->db = $db;
	}

	/**
	* @param int $id
	* @return array
	*/

	public function get($id) 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id 
		WHERE questions.id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $id
	* @param string $question
	* @param string $author
	* @param string $email
	* @param string $answer
	* @return boolean
	*/

	public function update($id, $question, $author, $email, $answer) 
	{
		$query = "UPDATE questions SET question = ?, author = ?, email = ?, answer = ?, visibility = NULL WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $question, PDO::PARAM_STR);
		$sth->bindValue(2, $author, PDO::PARAM_STR);
		$sth->bindValue(3, $email, PDO::PARAM_STR);
		$sth->bindValue(4, $answer, PDO::PARAM_STR);
		$sth->bindValue(5, $id, PDO::PARAM_INT);
		return $sth->execute(); 
	}

	/**
	* @param int $id
	* @param string $question
	* @param string $author
	* @param string $email
	* @param string $answer
	* @return boolean
	*/

	public function updatePublic($id, $question, $author, $email, $answer) 
	{
		$query = "UPDATE questions SET question = ?, author = ?, email = ?, visibility = 1, answer = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $question, PDO::PARAM_STR);
		$sth->bindValue(2, $author, PDO::PARAM_STR);
		$sth->bindValue(3, $email, PDO::PARAM_STR);
		$sth->bindValue(4, $answer, PDO::PARAM_STR);
		$sth->bindValue(5, $id, PDO::PARAM_INT);
		return $sth->execute(); 
	}
	
	/**
	* @return array
	*/

	public function countQuestions() 
	{
		$query = "SELECT count(question) as questions, count(answer) as answers FROM questions";
		$sth = $this->db->prepare($query);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $id
	* @return array
	*/

	public function getForTelegram($id) 
	{
		$query = "SELECT chat_id FROM questions WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $id
	* @param string $action
	* @param string $session_user
	* @return boolean
	*/

	public function writeLogs($id, $action, $session_user) 
	{
		$query = "SELECT questions.id, categories.category, questions.category_id 
		FROM questions INNER JOIN categories 
		ON questions.category_id = categories.id
		WHERE questions.id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		$sth->execute();
		$array = $sth->fetchAll(PDO::FETCH_ASSOC); 
		foreach ($array as $value) {
			$category_name = $value['category'];
			$question_id = $value['id'];
			$category_id = $value['category_id'];
			if ($action == 'update') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' обновил данные по вопросу ('. $question_id . ') из темы "' . $category_name . '" (' . $category_id . ') без публикации и добавления ответа';
			}
			if($action == 'update_and_visible') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' обновил и опубликовал вопрос ('. $question_id . ') в тему "' . $category_name . '" (' . $category_id . ')';
			}
			if($action == 'update_and_invisible') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' обновил (без публикации) вопрос ('. $question_id . ') из темы "' . $category_name . '" (' . $category_id . ')';
			}
		}
		$file = fopen(ROOT.'/logs/logs.txt', 'a');
		fwrite($file, $str . "\r\n");
		return fclose($file);
	}

}

?>