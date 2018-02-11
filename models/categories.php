<?php

class Categories
{

	public $db = null;
	public function __construct($db) 
	{
		$this->db = $db;
	}

	public function getAll() 
	{
		$query = "SELECT categories.id, categories.category, count(questions.category_id) as count_questions, count(questions.answer) as count_answer, count(questions.visibility) as count_visible FROM `categories` LEFT JOIN `questions` ON questions.category_id = categories.id GROUP BY categories.category";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delete($id) 
	{
		$query = "DELETE FROM categories WHERE id = ?; DELETE FROM questions WHERE category_id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function create($name) 
	{
		$query = "INSERT INTO categories (category) VALUES (?)";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $name, PDO::PARAM_STR);
		return $sth->execute();
	}

	public function update($id, $name) 
	{
		$query = "UPDATE categories SET category = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $name, PDO::PARAM_STR);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function getCategories() 
	{
		$query = "SELECT id, category FROM categories";
		$sth = $this->db->prepare($query); 
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
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