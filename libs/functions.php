<?php
define("SESSION_ACCOUNT", "SESSION_ACCOUNT");
define("SESSION_MESSAGE", "SESSION_MESSAGE");
define("SESSION_CSRF_TOKEN", "SESSION_CSRF_TOKEN");

define("MESSAGE_SIGNIN_SUCCESS", "Sign in successful.");
define("MESSAGE_SIGNIN_ERROR", "Sign in error.");
define("MESSAGE_SIGNUP_SUCCESS", "Sign up successful.");
define("MESSAGE_SIGNUP_ERROR", "Sign up error.");
define("MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME", "Sign up error. This name is not available.");
define("MESSAGE_FINISH_SECTION", "Learning completed.");
define("MESSAGE_NO_LEARNING_HISTORY", "No learning history.");

session_start();

function h($str) // HTML特殊文字を変換
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function new_PDO() //PDOインスタンスを返却
{
    $user = "shonsuke";
	$pass = "ShonsukePass12";
    $pdo = new PDO("mysql:host=localhost;dbname=ratingb;charset=utf8", $user, $pass, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
	
    return $pdo;
}

function sign_in($account) //セッションにアカウントデータを保存
{
    session_regenerate_id();
    $_SESSION[SESSION_ACCOUNT] = $account;
}

function is_sign_in()//セッションにアカウントデータが保存されているか確認
{
    return isset($_SESSION[SESSION_ACCOUNT]);
}

function sign_out()//セッションを破棄
{
    if (is_sign_in() === false) {
        return false;
    }

    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

function get_account()//セッションからアカウントデータを取得
{
    if (is_sign_in() === false) {
        return false;
    }
    return $_SESSION[SESSION_ACCOUNT];
}

function get_account_id()//セッションからアカウントIDを取得
{
    $account = get_account();
    if ($account === false) {
        return false;
    }
    return $account["id"];
}

function get_account_name()//セッションからアカウント名を取得
{
    $account = get_account();
    if ($account === false) {
        return false;
    }
    return $account["name"];
}

function set_message($message)//セッションにメッセージを取得
{
    $_SESSION[SESSION_MESSAGE] = $message;
}

function get_message()//セッションからメッセージを取得
{
    if (isset($_SESSION[SESSION_MESSAGE]) === false) {
        return false;
    }
    $message = $_SESSION[SESSION_MESSAGE];
    unset($_SESSION[SESSION_MESSAGE]);
    return $message;
}

function generate_csrf_token()//CSRFトークンを生成
{
    $bytes = random_bytes(32);
    $token = bin2hex($bytes);
    $_SESSION[SESSION_CSRF_TOKEN] = $token;
    return $token;
}

function validate_csrf_token($token)//CSRFトークンを検証
{
    if (isset($_SESSION[SESSION_CSRF_TOKEN]) === false) {
        return false;
    }
    $result = $_SESSION[SESSION_CSRF_TOKEN] === $token;
    unset($_SESSION[SESSION_CSRF_TOKEN]);
    return $result;
}

/////////////////////////////////////////////////////////

function get_book_info($image)//本の情報を取得
{
	$img = $image["book_url"];
	$json = file_get_contents($img);	// 書籍情報を取得
	$book = json_decode($json);			// デコード（objectに変換）
	
	return $book;
}

function get_author($book){
	$author_count = 0;
	$all_author = "";
	foreach($book->volumeInfo->authors as $author){
		if($author_count < 2){
			$all_author .= $author; 
		} else if ($authcount == 2){
			$all_author = "...etc";
		}
		$author_count++;
	}
	
	return $all_author;
}

//book block
/**
 * 
 */
function create_block($book, $count, $evaluation){
	$image_link = $book->volumeInfo->imageLinks->thumbnail;
	$title = $book->volumeInfo->title;
	$authors = $book->volumeInfo->authors;
	$percentage = $evaluation * 20;

	

	print("<img src=$image_link alt='画像'> ");
		print("<p>");
			print("<b>『 $title 』</b><br />");
			print("著者：");
			foreach($authors as $author){
				echo $author . " ";
			}
		print("</p>");
	print("<div class='average-score mb3'>");
		print("<div class='star-rating ml-2'>");
			print("<div class='star-rating-front' style='width:$percentage%' >★★★★★</div>");
			print("<div class='star-rating-back'>★★★★★</div>");
		print("</div>");
		print("<div class='average-score-display'>");
			print("( $evaluation 点)");
		print("</div>");
		print("<div class='commentNum'>");
			print("コメント: $count 件");
		print("</div>");
	print("</div>");
}
