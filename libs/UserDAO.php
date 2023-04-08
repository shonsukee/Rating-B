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
					id = :user_id
				order by
					create_date"; 

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$name = $stmt->fetch();

		return $name;
	}
}