<?php

class Users
{

	public $db = null;

	public function __construct($db) 
	{
		$this->db = $db;
	}
	public function getAll() 
	{
		$query = "SELECT id, login, password FROM admins";
		$sth = $this->db->prepare($query);
		$sth->execute(); 
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function add($login, $password) 
	{
		$query = "INSERT INTO admins (login, password) VALUES (?, ?)";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $login, PDO::PARAM_STR);
		$sth->bindValue(2, $password, PDO::PARAM_STR);
		return $sth->execute();
	}

	public function delete($id) 
	{
		$query = "DELETE FROM admins WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	public function update($id, $password) 
	{
		$query = "UPDATE admins SET password = ? WHERE id = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $password, PDO::PARAM_STR);
		$sth->bindValue(2, $id, PDO::PARAM_INT);
		return $sth->execute();
	}
	
	public function getAdmin($login, $password) 
	{
		$query = "SELECT id FROM admins WHERE login = ? and password = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $login, PDO::PARAM_STR);
		$sth->bindValue(2, $password, PDO::PARAM_STR);
		$sth->execute(); 
		return $sth->fetch(PDO::FETCH_ASSOC);
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