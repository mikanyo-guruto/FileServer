<?php
	session_start();
	ini_set('display_errors', 1);
    require_once('./dbh.php');

	$dbh = get_dbh();
    $sql = "SELECT * FROM files WHERE user_id = ? AND id = ?";
    $pre = $dbh->prepare($sql);
    $pre->execute(array($_SESSION['user']['id'], $_POST['file_id']));
    $result = $pre->fetchAll();

    $filepath = $result[0]['path'];
    $filename = $result[0]['file_name'];

    header('Content-Type: application/octet-stream');
	header('Content-Length: '.filesize($filepath));
	header('Content-disposition: attachment; filename='.$filename);
	readfile($filepath);