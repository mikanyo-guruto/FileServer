<?php
    // セッション開始
    session_start();
    ini_set('display_errors', 1);
	require_once('./dbh.php');

	function redirect($msg) {
		// indexに返す
		$_SESSION['msg'] = $msg;
		header('Location: ../top.php');
		exit;
	}

	// 一時ファイルができているか（アップロードされているか）チェック
	if(is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
		// ディレクトリ内のファイル名重複を防ぐ為にpathにはユニークな名前のディレクトリを作成する
		$path = hash('sha512', uniqid(rand(),1), false) . "/";
		if (!mkdir($up_dir . $path, 0777, true)) {
			redirect("ディレクトリの作成に失敗しました。");
		}

		// 一時ファイルを保存ファイルにコピーできたか
		// なおかつ、権限の変更を加えられたか
		if(move_uploaded_file($_FILES['upfile']['tmp_name'], 
			"{$up_dir}{$path}{$_FILES['upfile']['name']}") && 
			chmod("{$up_dir}{$path}{$_FILES['upfile']['name']}", 0644)) 
		{
			// DBへアクセス
			$dbh = get_dbh();
			$sql = "INSERT INTO files(user_id, dir_id, file_name, path, create_time, update_time) VALUES (:user_id, :dir_id, :file_name, :path, :create_time, :update_time)";
			$pre = $dbh->prepare($sql);
			// データのバインド
			$pre->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_STR);
			$pre->bindValue(':dir_id', 0, PDO::PARAM_INT);
			$pre->bindValue(':file_name', $_FILES["upfile"]["name"], PDO::PARAM_STR);
			$pre->bindValue(':path', $path, PDO::PARAM_STR);
			$pre->bindValue(':create_time', date("Y-m-d H:i:s") , PDO::PARAM_STR);
			$pre->bindValue(':update_time', date("0000-00-00 00:00:00") , PDO::PARAM_STR);

			if ($pre->execute()) {
				redirect($_FILES["upfile"]["name"]."をアップロードしました。");
			} else {
				redirect("ファイルをアップロードできませんでした。");
			}
		} else {
			redirect("ファイルをアップロードできませんでした。");
		}
	} else {
		redirect("ファイルが選択されていません。");
	}
