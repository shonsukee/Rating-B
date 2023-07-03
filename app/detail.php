<?php

require_once("../libs/functions.php");
require_once("../libs/ImageDAO.php");
require_once("../libs/CommentDAO.php");
require_once("../libs/UserDAO.php");

//image_idのリクエストパラメータを取得,ex)~?id=1&~ の時の1
$image_id = (string)filter_input(INPUT_GET, "image_id"); 
if($image_id === ""){
	set_message("Error: Image id is required.");
	header("Location: error.php");
	exit();
}

//整数型であることを確認
if(filter_var($image_id, FILTER_VALIDATE_INT) === false){ 
	set_message("Error: Image id isn't int.");
	header("Location: error.php");
	exit();
}

try{
	$pdo = new_PDO();

	$image_dao = new ImageDAO($pdo);
	$comment_dao = new CommentDAO($pdo);
	$user_dao = new UserDAO($pdo);
	$image = $image_dao->selectById($image_id);
	if($image === false){
		set_message("Error: Invalid image id:" . $image_id);
		header("Location: error.php");
		exit;
	}

	$comments = $comment_dao->allComment($image_id);
	if($comments === false){
		set_message("Error: Invalid image id:" . $image_id);
		header("Location: error.php");
		exit;
	}
	
	if(is_sign_in()){
		$csrf_token = generate_csrf_token();
	}

	$list = [
		1 => '★',
		2 => '★★',
		3 => '★★★',
		4 => '★★★★',
		5 => '★★★★★',
	];

	require("../view/detail_view.php");
} catch(PDOException $e){
	error_log($e->getMessage());
	header("Location: error.php");
}

?>

