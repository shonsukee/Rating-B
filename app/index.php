<?php

require_once("../libs/functions.php");
require("../libs/ImageDAO.php");
require("../libs/CommentDAO.php");

try{
	$pdo = new_PDO();
	$image_dao = new ImageDAO($pdo);
	$comment_dao = new CommentDAO($pdo);

	$images = $image_dao->selectAll();

	require("../view/index_view.php");
} catch(PDOException $e) {
	error_log($e->getMessage());
	header("Location: error.php");
}

?>
