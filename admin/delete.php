<?php
	session_start();
	ini_set('display_errors', 1);

	require_once('./dbh.php');

	function redirect($msg) {
		// indexに返す
		$_SESSION['msg'] = $msg;
		header('Location: ../top.php');
		exit;
	}

	// DBにアクセス
	$dbh = get_dbh();
	// ファイル情報を読み込む
	$sql = "SELECT * FROM files WHERE user_id = ? AND id = ?";
	$pre = $dbh->prepare($sql);
	$pre->execute(array($_SESSION['user']['id'], $_POST['file_id']));
	$result = $pre->fetch(PDO::FETCH_ASSOC);

	// ファイルが存在しているパス
	$filepath = "{$up_dir}{$result['path']}";
	if(file_exists($filepath)) {
		$delsql = "DELETE FROM files WHERE user_id = ? AND id = ?";
    	$pre = $dbh->prepare($delsql);
    	// ファイルを削除する
    	// ディレクトリを削除する
    	// DBを削除する
    	if (unlink("{$filepath}{$result['file_name']}") && 
    		rmdir($filepath) && 
    		$pre->execute(array($_SESSION['user']['id'], $_POST['file_id']))) {
			//echo "削除しました。";
			redirect("ファイルを削除しました。");
		} else {
			redirect("削除できませんでした。");
		}
	} else {
		redirect("ファイルが存在しません。");
	}
