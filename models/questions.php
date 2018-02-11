<?php

class Questions
{

	public $db = null;
	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function getAll() 
	{
		$query = "SELECT questions.id, questions.question, questions.author, questions.email, questions.answer, questions.category_id, questions.visibility, questions.date_added, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getAllByCategory($category_id) 
	{
		$query = "SELECT questions.id, questions.question, questions.author, questions.email, questions.answer, questions.category_id, questions.visibility, questions.date_added, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id WHERE category_id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getAllByAnswer() 
	{
		$query = "SELECT questions.id, questions.question, questions.author, questions.email, questions.answer, questions.category_id, questions.visibility, questions.date_added, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id WHERE answer IS NULL";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getAllSort($category_id) 
	{
		$query = "SELECT questions.id, questions.question, questions.author, questions.email, questions.answer, questions.category_id, questions.visibility, questions.date_added, categories.category FROM questions INNER JOIN categories ON questions.category_id = categories.id WHERE (answer IS NULL) AND (category_id = ?)";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCategories() 
	{
		$query = "SELECT id, category FROM categories";
		$sth = $this->db->prepare($query); 
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getVisible($id) 
	{
		$query = "UPDATE questions SET visibility = 1 WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function getInvisible($id) 
	{
		$query = "UPDATE questions SET visibility = NULL WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function delete($id) 
	{
		$query = "DELETE FROM questions WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function changeCategory($id, $category_id) 
	{
		$query = "UPDATE questions SET category_id = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $category_id, PDO::PARAM_INT);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function countQuestions() 
	{
		$query = "SELECT count(question) as questions, count(answer) as answers FROM questions";
		$sth = $this->db->prepare($query);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>