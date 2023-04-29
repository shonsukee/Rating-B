<?php

class ImageDAO{
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	/* 画像すべて*/
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

	/* ID指定して一冊の情報を返す*/
	function selectById($image_id){
		$sql = "select 
					*
				from
					images
				where
					id = :image_id
				order by
					create_date"; 

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
		$stmt->execute();
		$image = $stmt->fetch();

		return $image;
	}

	/* URLから画像が投稿されているか確認し，情報があれば返す*/
	function checkImage($book_url){
		$sql = "select
					id
				from
					images
				where
					book_url = :book_url";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":book_url", $book_url, PDO::PARAM_STR);
		$stmt->execute();
		$image = $stmt->fetch();

		return $image;
	}

	/**ユーザがコメントした本の情報を返す */
	function getBookInfo()
	{
		$user_id = $_SESSION[SESSION_ACCOUNT]["id"];
		$sql = 	"SELECT 
					*
				FROM
					images
				where 
					id 
				IN 
					(SELECT 
						image_id
					FROM 
						comments
					where 
						user_id = :user_id)";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$image = $stmt->fetchAll();
		
		return $image;
	}

	/**本を投稿 */
	function insertBook($url)
	{
		/**画像をアップロード */
		$sql = "INSERT INTO images (book_url) VALUES (:url)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":url", $url, PDO::PARAM_STR);
		$stmt->execute();
	}

}
?>