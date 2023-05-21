<?php

require_once("../libs/functions.php");
require_once("../libs/ImageDAO.php");
require_once("../libs/CommentDAO.php");

/* 投稿フォームから画像が送られているか確認 */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["link"])) {
	try{
		$pdo = new_PDO();
		$image_dao = new ImageDAO($pdo);
		$comment_dao = new CommentDAO($pdo);
		
		$user_id = $_SESSION[SESSION_ACCOUNT]["id"];
		$comment = $_POST["comment"];
		$evalution = $_POST["num"];
		$url = $_GET["link"];
		$image_dao->insertBook($url); //すでに投稿されていたら新しく本を保存しない機能追加
		
		$image_id = $image_dao->checkImage($url);
		$comment_dao->insertComment($image_id["id"], $user_id, $comment, $evalution);
	
	} catch(PDOException $e){
		error_log($e->getMessage());
		header("Location: error.php");
	}
}

header('Location: index.php', true, 303); //指定ページに遷移