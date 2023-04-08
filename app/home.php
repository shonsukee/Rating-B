<?php

require_once("../libs/functions.php");
require("../libs/ImageDAO.php");
require("../libs/CommentDAO.php");
// require("../libs/AverageDAO.php");


try{
	$pdo = new_PDO();
	$image_dao = new ImageDAO($pdo);
	$comment_dao = new CommentDAO($pdo);
	// $average_dao = new AverageDAO($pdo);

	$images = $image_dao->selectAll();

	require("../view/home_temp.php");
	// require("../view/home_view.php");
} catch(PDOException $e) {
	error_log($e->getMessage());
	header("Location: error.php");
}

?>
