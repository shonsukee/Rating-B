<?php

require_once("../libs/functions.php");
require_once("../libs/ImageDAO.php");
require_once("../libs/AverageDAO.php");
require_once("../libs/CommentDAO.php");

$image_id = (string)filter_input(INPUT_GET, "image_id"); //image_idのリクエストパラメータを取得,ex)~?id=1&~ の時の1
if($image_id === ""){
	set_message("Error: Image id is required.");
	header("Location: error.php");
	exit();
}
if(filter_var($image_id, FILTER_VALIDATE_INT) === false){ //整数型であることを確認
	set_message("Error: Image id isn't int.");
	header("Location: error.php");
	exit();
}

try{
	$pdo = new_PDO();

	$image_dao = new ImageDAO($pdo);
	$average_dao = new AverageDAO($pdo);
	$comment_dao = new CommentDAO($pdo);
	$images = $image_dao->selectById($image_id);
	if($images === false){
		set_message("Error: Invalid image id." . $image_id);
		header("Location: error.php");
		exit;
	}

	$comments = $comment_dao->allComment($image_id);
	if($comments === false){
		set_message("Error: Invalid image id." . $image_id);
		header("Location: error.php");
		exit;
	}
	
	// $section_dao = new SectionDAO($pdo);
	// $account_id = get_account_id();
	// if($account_id === true){ // サインインしている時
	// 	$sections = $section_dao->selectByIdAndAccountId($image_id, $account_id);
	// } else {
	// 	$sections = $section_dao->selectById($image_id);
	// }
	// if(count($sections) == 0){
	// 	error_log("Invalid sections." . $image_id);
	// 	header("Location: error.php");
	// 	exit();
	// }

	// $current_section = $sections[0];
	// foreach($sections as $section){
	// 	if((int)$section["id"] === (int)$section_id) {
	// 		$current_section = $section;
	// 		break;
	// 	}
	// }
	if(is_sign_in()){
		$csrf_token = generate_csrf_token();
	}

	require("../view/detail_view.php");
} catch(PDOException $e){
	error_log($e->getMessage());
	header("Location: error.php");
}

?>

