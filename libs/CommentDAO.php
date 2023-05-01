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

	
	function avgScore($image_id, $num) { 
		// 評価の平均を返す，引数の$imageIdはindexのimageId
		// ($num == 0)-> コメント数，($num != 0)-> %表記
		//indexのimageIdと，同じimageIdをもつimageのevaluationをcommentsテーブルから取ってくる
		$sql = "SELECT 
					comment_eva 
				from 
					comments
				where 
					image_id = :image_id 
				order by 
					create_date"; 

		$sth = $this->pdo->prepare($sql);
		$sth->bindValue(":image_id", $image_id, PDO::PARAM_INT);
		$sth->execute();
		$evaluation = $sth->fetchAll(); 
		$count = count($evaluation);
		
		if($num == 0){
			return $count;
		}
		
		$avg_score = 0; 
		for($i=0; $i < $count; $i++){
			$avg_score += $evaluation[$i]['comment_eva'];
		}

		$avg_score = round($avg_score / $count, 1) * $num;

		return $avg_score;
	}

	/**本を投稿 */
	function insertComment($image_id, $user_id, $comment, $comment_eva)
	{
		$sql = "INSERT INTO comments (image_id, user_id, comment, comment_eva) VALUES (:image_id, :user_id, :comment, :comment_eva)";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
		$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindValue(":comment", $comment, PDO::PARAM_STR);
		$stmt->bindValue(":comment_eva", $comment_eva, PDO::PARAM_INT);
		$stmt->execute();
	}
}