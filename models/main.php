<?php

class Main 
{

	public $db = null;
	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function getQuestions() 
	{
		$query = "SELECT questions.question, questions.answer, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id WHERE visibility = 1 ORDER BY categories.category DESC";
		$sth = $this->db->prepare($query); 
		$sth->execute(); 
		return $result = $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCategories() 
	{
		$query = "SELECT id, category FROM categories";
		$sth = $this->db->prepare($query); 
		$sth->execute(); 
		return $result = $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addQuestion($question, $author, $email, $category_id) 
	{
		$query = "INSERT INTO questions (question, date_added, author, email, category_id) VALUES (?, now(), ?, ?, ?)";
		$sth = $this->db->prepare($query); 
		$sth->bindValue(1, $question, PDO::PARAM_STR);
		$sth->bindValue(2, $author, PDO::PARAM_STR);
		$sth->bindValue(3, $email, PDO::PARAM_STR);
		$sth->bindValue(4, $category_id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function getQuestionsByCat($category) 
	{
		$query = "SELECT questions.question, questions.answer, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id WHERE visibility = 1 and categories.category = ?";
		$sth = $this->db->prepare($query); 
		$sth->bindValue(1, $category, PDO::PARAM_STR);
		$sth->execute(); 
		return $result = $sth->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>