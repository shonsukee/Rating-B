<?php

class UserDAO{
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	function getName($user_id){
		$sql = "select 
					name
				from
					register_user
				where
					id = :user_id"; 

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$name = $stmt->fetch();

		return $name;
	}
	
	function selectByEmail($email){
		$sql = "select
					*
				from
					register_user
				where
					mail = :email";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":email", $email, PDO::PARAM_STR);
		$stmt->execute();
		$account = $stmt->fetch();

		return $account;
	}

	function insert($name, $email, $hashed_pass){
		$sql = "insert into register_user (name, mail, password) value (:name, :mail, :password)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":name", $name, PDO::PARAM_STR);
		$stmt->bindValue(":mail", $email, PDO::PARAM_STR);
		$stmt->bindValue(":password", $hashed_pass, PDO::PARAM_STR);
		$stmt->execute();
	}
}