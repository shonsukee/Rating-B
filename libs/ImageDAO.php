<?php

class ImageDAO{
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	function selectAll(){
		$sql = "select 
					*
				from
					images
				order by
					id";
		$st = $this->pdo->query($sql);
		$courses = $st->fetchAll();

		return $courses;
	}
	
	function selectById($image_id){
		$sql = "select 
					book_url,
					book_name
				from
					images
				where
					id = :image_id
				order by
					create_date"; //ここ要修正！！！！！！！！！！！！！！！！！！！！！！！！！
		
				// 	$sql = "select 
				// 	img.book_url,
				// 	img.book_name,
				// 	cmt.comment,
				// 	cmt.comment_eva,
				// 	cmt.create_date
				// from
				// 	images img,
				// 	comments cmt
				// where
				// 	img.id = :image_id
				// and
				// 	cmt.image_id = :image_id
				// order by
				// 	cmt.create_date";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
		$stmt->execute();
		$image = $stmt->fetch();

		return $image;
	}
}
?>