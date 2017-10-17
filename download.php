<?php
	session_start();

	$db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "mikanyo";  // ユーザー名
    $db['pass'] = "mikanyo";  // ユーザー名のパスワード
    $db['dbname'] = "mikanyo";  // データベース名

    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
	$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

	$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ? AND file_name = ?");
	$stmt->execute(array($_SESSION["id"], $_POST['dlfile']));
	$result = $stmt->fetchAll();

	$filepath = $result[0]['path'];
	$filename = $result[0]['file_name'];
		
	header('Content-Type: application/force-download');
	//header('Content-Length: '.filesize($filepath));
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	readfile($filepath);
?>