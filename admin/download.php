<?php
	session_start();
	ini_set('display_errors', 1);
    require_once('./dbh.php');

    function redirect($msg) {
        // indexに返す
        $_SESSION['msg'] = $msg;
        header('Location: ../index.php');
        exit;
    }

	$dbh = get_dbh();
    $sql = "SELECT * FROM files WHERE user_id = ? AND id = ?";
    $pre = $dbh->prepare($sql);
    $pre->execute(array($_SESSION['user']['id'], $_POST['file_id']));
    $result = $pre->fetch();

    $filename = $result['file_name'];
    $path = $result['path'];
    // ダウンロードしてくるファイルのパス
    $filepath = $up_dir . $path . $filename;

    if (file_exists($filepath)) {
        // ファイルのダウンロード処理
        header('Content-Type: application/octet-stream');
    	header('Content-Length: '.filesize($filepath));
    	header('Content-disposition: attachment; filename='.$filename);
        header("Connection: close");
    	readfile($filepath);
    } else {
    	redirect("ファイルが存在しません。");
    }

    // ヘッダの送信チェックにheaders_sent()を使ったほうがいいかもしれない
    /*
	if (!headers_sent()) {
		header('Location: ../top.php')
	} else {
		// エラー処理
	}
    */

    //header('Location: ../top.php');
    exit;
