<?php
	session_start();
	ini_set('display_errors', 1);

	// 共通エラー処理
	function error() {
		// indexに返す
		header('Location: ../index.php');
		exit;
	}

	/*
	 * 認証処理(authentication)を行う
	 */
	//
	require_once('./dbh.php');


	// 画面入力のIDとパスワードを取得
	$id = (string)@$_POST['id'];
	$pw = (string)@$_POST['pw'];

	// varidate
	if ( ('' === $id) ||('' === $pw) ) {
		// エラー処理
		error();
	}

	/*
	 * DB内のIDとパスワードを取得
	 */
	// DBハンドル取得
	$dbh = get_dbh();

	// SELECTを発行
	// ---------------------------
	// プリペアドステートメント
	$sql = 'SELECT * FROM users WHERE user_id = :user_id';
	$pre = $dbh->prepare($sql);
	// バインド
	$pre->bindValue(':user_id', $id);
	// 実行
	$r = $pre->execute();
	if (false === $r) {
		// エラー処理
		echo 'DBでエラーが発生しました。';
		echo $pre->errorInfo();
		exit;
	}

	// データを取得する
	$admin_user = $pre->fetch(PDO::FETCH_ASSOC);
	if (false === $admin_user) {
		// エラー処理
		error();
	}

	// IDとパスワードを比較
	$r = password_verify($pw, $admin_user['pass']);
	if (false === $r) {
		// エラー処理
		error();
	}

	// 認証okなら許可用の準備をする
	session_regenerate_id(true); // 脆弱性対策
	$_SESSION['users'][':user_id'] = $id;
	$_SESSION['user'] = array('name'=>$admin_user['name'], 'id'=>$admin_user['id']);

	// ログイン後にメイン画面に遷移
	header('Location: ../top.php');