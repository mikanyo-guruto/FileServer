<?php
require 'password.php';
// セッション開始
session_start();

$db['host'] = "localhost";	// DBサーバのURL
$db['user'] = "mikanyo";	// ユーザ名
$db['pass'] = "pass";		// ユーザ名のパスワード
$db['dbname'] = "mikanyo";	// DB名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
	// 1.ユーザIDの入力チェック
	if (empty($_POST["userid"])) {
		$errorMessage = 'ユーザIDが未入力です。';
	} else if (empty($_POST["password"])) {
		$errorMessage = 'パスワードが未入力です。';
	}

	if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
		// 入力したユーザIDを格納
		$userid = $_POST["userid"];

		// 2.ユーザIDとパスワードが入力されていたら認証
		$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

		// 3.エラー処理
		try {
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO))
		}
	}
}







http://qiita.com/KosukeQiita/items/b56b3004413c999b9858