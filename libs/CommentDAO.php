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
		
		// if(isset($evaluation)){
		$avg_score = 0; 
		for($i=0; $i < $count; $i++){
			$avg_score += $evaluation[$i]['comment_eva'];
		}
		// }

		$avg_score = round($avg_score / $count, 1) * $num;
		// $avg_score *= $num;

		return $avg_score;
	}
}