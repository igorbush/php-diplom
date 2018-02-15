<?php

class Admin 
{

	public $db = null;

	/**
	* Admin constructor.
	* @param object(PDO) $db
	*/

	public function __construct($db) 
	{
		$this->db = $db;
	}

	/**
	* @param string $login
	* @param string $password
	* @return array
	*/

	public function getAdmin($login, $password) 
	{
		$query = "SELECT id FROM admins WHERE login = ? and password = ?";
		$sth = $this->db->prepare($query);
		$sth->bindValue(1, $login, PDO::PARAM_STR);
		$sth->bindValue(2, $password, PDO::PARAM_STR);
		$sth->execute(); 
		return $sth->fetch(PDO::FETCH_ASSOC);
	}
}

?>