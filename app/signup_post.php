<?php

require("../libs/functions.php");
require("../libs/UserDAO.php");

// csrf_tokenが届いているか判定
$csrf_token = (string)filter_input(INPUT_POST, "csrf_token");
if(validate_csrf_token($csrf_token) === false){
	set_message(MESSAGE_SIGNUP_ERROR);
	header("Location: error.php");
	exit;
}

// Nameが適切か判定
$name = (string)filter_input(INPUT_POST, "name");
if($name == ""){
	set_message(MESSAGE_NULL_ERROR);
	header("Location: signin.php");
	exit;
}
if(strlen($name) > 20){
	set_message(MESSAGE_VALUE_ERROR);
	header("Location: signin.php");
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

$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

try{
	$pdo = new_PDO();

	$user_dao = new userDAO($pdo);
	$user_dao->insert($name, $email, $hashed_pass);

	// sign in process
	$user_info = $user_dao->selectByEmail(h($email));
	sign_in($user_info);
	set_message(MESSAGE_SIGNUP_SUCCESS);
	header("Location: home.php");
} catch(PDOException $e){
	error_log($e->getMessage());
	set_message(MESSAGE_SIGNUP_ERROR);
	header("Location: error.php");
}