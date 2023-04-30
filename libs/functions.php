<?php
define("SESSION_ACCOUNT", "SESSION_ACCOUNT");
define("SESSION_MESSAGE", "SESSION_MESSAGE");
define("SESSION_CSRF_TOKEN", "SESSION_CSRF_TOKEN");

define("MESSAGE_SIGNIN_SUCCESS", "Sign in successful.");
define("MESSAGE_SIGNIN_ERROR", "Sign in error.");
define("MESSAGE_SIGNUP_SUCCESS", "Sign up successful.");
define("MESSAGE_SIGNUP_ERROR", "Sign up error.");
define("MESSAGE_VALUE_ERROR", "There is an invalid input field.");
define("MESSAGE_NULL_ERROR", "There is an empty input field.");
define("MESSAGE_MAIL_ERROR", "Not registered.");
define("MESSAGE_PASS_ERROR", "Password is different.");
define("MESSAGE_NO_QUERY", "Please enter query.");

session_start();

function h($str) // HTML特殊文字を変換
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function createTableIfNotExists($pdo, $tableName, $columns) {
    $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
    $stmt->execute([$tableName]);
    $result = $stmt->rowCount();
    if ($result == 0) {
        // テーブルが存在しない場合のみクエリを実行する
        $query = "CREATE TABLE " . $tableName . " (" . $columns . ")";
        $pdo->exec($query);
    }
}

function new_PDO() //PDOインスタンスを返却
{
    $user = "gl54p9kpv5ky38vb";
	$pass = "r80pjoeipkepth7f";
    $pdo = new PDO("mysql:host=exbodcemtop76rnz.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=r00g7duuf8nhe35l;charset=utf8", $user, $pass, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

	$tableName = "comments";
	$columns = "id INT(11) NOT NULL AUTO_INCREMENT,
				image_id INT(11) NOT NULL,
				user_id INT(11) NOT NULL,
				comment TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
				comment_eva INT(11) NOT NULL,
				create_date TIMESTAMP NOT NULL DEFAULT current_timestamp()";
		
	createTableIfNotExists($pdo, $tableName, $columns);

	$tableName = "images";
	$columns = "id INT(11) NOT NULL AUTO_INCREMENT,
				book_url VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
				create_date TIMESTAMP NOT NULL DEFAULT current_timestamp()";
		
	createTableIfNotExists($pdo, $tableName, $columns);

	$tableName = "register_user";
	$columns = "id INT(11) NOT NULL AUTO_INCREMENT,
				name TEXT COLLATE utf8mb4_general_ci NOT NULL,
				mail TEXT COLLATE utf8mb4_general_ci NOT NULL,
				password TEXT COLLATE utf8mb4_general_ci NOT NULL,
				status TINYINT(1) NOT NULL DEFAULT '0',
				create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				update_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP";
	
	createTableIfNotExists($pdo, $tableName, $columns);
	
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
	
	foreach ($book->volumeInfo->authors as $author) {
		if ($author_count < 2) {
			$all_author .= ($all_author ? ' ' : '') . $author;
		}
		$author_count++;
	}
	
	if ($author_count > 2) {
		$all_author .= ' ...etc';
	}
	
	return $all_author;
}

function create_block($book, $count, $evaluation){
	$image_link = $book->volumeInfo->imageLinks->thumbnail;
	$title = $book->volumeInfo->title;
	$author = get_author($book);

	if(strlen($title) > 23) {
		$title = mb_substr($title, 0, 6, "UTF-8") . '...';
	}
	print("
		<img src=$image_link alt='画像' class='shadow-sm img-size'>
		<div class='book-text'>
		<hr>
			<h4> <b>『 $title 』</b> </h4>
			著者：$author ");
	if($count != "" && $evaluation != ""){
		print_rate($count, $evaluation);
	} else{
		print("</div>");
	}
}
		
function print_rate($count, $evaluation){
	$percentage = $evaluation * 20;
	print("
			<div class='row'>
				<div class='col-7 justify-content-end d-inline-flex'>
					<div class=' star-rating'>
						<div class='star-rating-front' style='width:$percentage%' >★★★★★</div>
						<div class='star-rating-back'>★★★★★</div>
					</div>
				</div>
				<div>
					( $evaluation 点)
				</div>
			</div>
			コメント: $count 件	
		</div>
	");

}