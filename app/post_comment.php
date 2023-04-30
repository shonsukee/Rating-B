<?php

require_once("../libs/functions.php");
require_once("../libs/ImageDAO.php");
require_once("../libs/CommentDAO.php");

/*画像アップロード先を指定*/
$url = $_GET["link"];
$evalution = $_POST["num"];
$comment = $_POST["comment"];

// 書籍情報を取得
$json = file_get_contents($url);
// デコード（objectに変換）
$book = json_decode($json);

/* 投稿フォームから画像が送られているか確認 */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($url)) {
	try{
		$pdo = new_PDO();
	
		$image_dao = new ImageDAO($pdo);
		$comment_dao = new CommentDAO($pdo);

		$user_id = $_SESSION[SESSION_ACCOUNT]["id"];
		$image_dao->insertBook($url);
		$image_id = $image_dao->checkImage($url);
		$comment_dao->insertComment($image_id["id"], $user_id, $comment, $evalution);
	
	} catch(PDOException $e){
		error_log($e->getMessage());
		header("Location: error.php");
	}
}

header('Location: ./index.php', true, 303); //指定ページに遷移