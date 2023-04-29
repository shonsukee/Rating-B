<?php

require_once("../libs/functions.php");
require_once("../libs/ImageDAO.php");

try {
	$pdo = new_PDO();
	$image_dao = new ImageDAO($pdo);
	
	$link = filter_input(INPUT_GET, "link");
	
	//SQLにすでに保存されていないか確認する
	if($image_dao->checkImage($link) !== null){
		$json = file_get_contents($link);		// 書籍情報を取得
		$book = json_decode($json);				// デコード（objectに変換）
	} else {
		print("already post!");
	}
	
	require("../view/post_one_view.php");
} catch (PDOException $e) {
	error_log($e->getMessage());
	header("Location: error.php");
}