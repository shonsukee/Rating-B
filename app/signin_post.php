<?php
require("../libs/functions.php");
require("../libs/UserDAO.php");

// csrf_tokenが届いているか判定
$csrf_token = filter_input(INPUT_POST, "csrf_token");
if(validate_csrf_token($csrf_token) === false){
	set_message("No csrf token");
	header("Location: error.php");
	exit;
}

// Emailが適切か判定
$email = (string)filter_input(INPUT_POST, "email");
if($email == ""){
	set_message(MESSAGE_NULL_ERROR);
	header("Location: signin.php");
	exit;
}
if(strlen($email) > 40){
	set_message(MESSAGE_VALUE_ERROR);
	header("Location: signin.php");
	exit;
}

// Passwordが適切か判定
$password = (string)filter_input(INPUT_POST, "password");
if($password == ""){
	set_message(MESSAGE_NULL_ERROR);
	header("Location: signin.php");
	exit;
}
if(strlen($password) > 20){
	set_message(MESSAGE_VALUE_ERROR);
	header("Location: signin.php");
	exit;
}

try{
	$pdo = new_PDO();
	
	// Email判定
	$user_dao = new UserDAO($pdo);
	$user_info = $user_dao->selectByEmail(h($email));
	if($user_info === false){
		set_message(MESSAGE_MAIL_ERROR);
		header("Location: error.php");
		exit();
	}

	// Password判定
	if(password_verify($password, $user_info["password"]) === false){
		set_message(MESSAGE_PASS_ERROR);
		header("Location: error.php");
		exit();
	}

	// sign_in してログイン
	sign_in($user_info);
	set_message(MESSAGE_SIGNIN_SUCCESS);
	// $_SESSION["signin_user"] = $user_info; 消して！！！！！！！！！！！！
	header("Location: index.php");
} catch(PDOException $e){
	set_message(MESSAGE_SIGNIN_ERROR);
	header("Location: error.php");
}