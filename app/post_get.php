<?php

require_once("../libs/functions.php");

// 検索条件を配列にする
$params = array(
  'intitle'  => $_POST["bookTitle"],  //書籍タイトル
  'inauthor' => $_POST["author"],       //著者
);

$params["intitle"] = str_replace(array(" ", "　"), "", $params["intitle"]);
$params["inauthor"] = str_replace(array(" ", "　"), "", $params["inauthor"]);

$maxResults = 40;
$startIndex = 0;

$base_url = 'https://www.googleapis.com/books/v1/volumes?q=';

if($params["intitle"] == "" && $params["inauthor"] == ""){
	set_message(MESSAGE_NO_QUERY);
	header('Location:../view/post_search_view.php');
	exit();
}

if($params["intitle"] != ""){
	$base_url .= 'intitle:' . $params["intitle"] . '+';
}
if($params["inauthor"] != ""){
	$base_url .= 'inauthor:' . $params["inauthor"] . '+';
}

// 末尾につく「+」を削除
$params_url = substr($base_url, 0, -1);

// 件数情報を設定
$url = $params_url.'&maxResults='.$maxResults.'&startIndex='.$startIndex;

// 書籍情報を取得
$json = file_get_contents($url);

// デコード（objectに変換）
$data = json_decode($json);

if(isset($data->items)){
	// 書籍情報を取得
	$books = $data->items;
	
	// 実際に取得した件数
	$get_count = count($books);
} else {
	$get_count = 0;
}

require("../view/post_get_view.php");
?>
