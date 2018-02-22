<?php

class Questions
{

	public $db = null;

	/**
	* Questions constructor.
	* @param object(PDO) $db
	*/

	public function __construct($db) 
	{
		$this->db = $db;
	}

	/**
	* @return array
	*/

	public function getAll() 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id
		WHERE questions.blocked = 0";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $category_id
	* @return array
	*/

	public function getAllByCategory($category_id) 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id 
		WHERE category_id = ? and questions.blocked = 0";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @return array
	*/

	public function getAllByAnswer() 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id 
		WHERE answer IS NULL and questions.blocked = 0";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $category_id
	* @return array
	*/

	public function getAllSort($category_id) 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id 
		WHERE answer IS NULL AND category_id = ? and questions.blocked = 0";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @return array
	*/

	public function getCategories() 
	{
		$query = "SELECT id, category FROM categories";
		$sth = $this->db->prepare($query); 
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param int $id
	* @return boolean
	*/

	public function getVisible($id) 
	{
		$query = "UPDATE questions SET visibility = 1 WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	/**
	* @param int $id
	* @return boolean
	*/

	public function getInvisible($id) 
	{
		$query = "UPDATE questions SET visibility = NULL WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	/**
	* @param int $id
	* @return boolean
	*/

	public function delete($id) 
	{
		$query = "DELETE FROM questions WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	/**
	* @param int $id
	* @param int $category_id
	* @return boolean
	*/

	public function changeCategory($id, $category_id) 
	{
		$query = "UPDATE questions SET category_id = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	/**
	* @param int $id
	* @return boolean
	*/

	public function unlockQuestion($id) 
	{
		$query = "UPDATE questions SET blocked = 0 WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
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
	* @return array
	*/

	public function getAllBlocked() 
	{
		$query = "SELECT questions.id, questions.question, questions.author,
		questions.email, questions.answer, questions.category_id,
		questions.visibility, questions.date_added, categories.category 
		FROM questions INNER JOIN categories ON questions.category_id = categories.id
		WHERE questions.blocked = 1";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param string $str
	* @return array
	*/

	public function findStopWord($str) 
	{
		$file = file(ROOT.'/stopsheets/stopwords.txt', FILE_SKIP_EMPTY_LINES);
		foreach ($file as $word) {
			$stopword = "~".trim($word)."~u";
			if (preg_match_all($stopword, $str)) {
				$array[]=$word;
			}
		}
		return $array;
	}

	/**
	* @param int $id
	* @return array
	*/

	public function getForTelegram($id) 
	{
		$query = "SELECT chat_id, question, answer FROM questions WHERE id = ?";
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
			if ($action == 'delete') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' удалил вопрос ('. $question_id . ') из темы "' . $category_name . '" (' . $category_id . ')';
			}
			if($action == 'change_category') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' переместил вопрос ('. $question_id . ') в тему "' . $category_name . '" (' . $category_id . ')';
			}
			if($action == 'visible') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' опубликовал вопрос ('. $question_id . ') из темы "' . $category_name . '" (' . $category_id . ')';
			}
			if($action == 'invisible') {
				$str = '[ '. date("Y-m-d H:i:s") . ' ] ' . $session_user . ' снял с публикации вопрос ('. $question_id . ') из темы "' . $category_name . '" (' . $category_id . ')';
			}
		}
		$file = fopen(ROOT.'/logs/logs.txt', 'a');
		fwrite($file, $str . "\r\n");
		return fclose($file);
	}

	/**
	* @param string $str
	* @return boolean
	*/

	public function addStopWord($str) 
	{
		$file = fopen(ROOT.'/stopsheets/stopwords.txt', 'a');
		fwrite($file, $str . "\r\n");
		return fclose($file);
	}

}

?>