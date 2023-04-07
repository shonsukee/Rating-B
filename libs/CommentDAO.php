<?php

class CommentDAO{

	function __construct($pdo){
		$this->pdo = $pdo;
	}
	
	function allComment($image_id) { 
		$sql = "select
					*
				from
					comments
				where
					image_id = :image_id
				order by
					create_date";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
		$stmt->execute();
		$comments = $stmt->fetchAll();

		return $comments;
	}
}