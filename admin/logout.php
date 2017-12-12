<?php
	session_start();
	// セッションクリア
	session_unset();
	
	$_SESSION['msg'] = "ログアウトしました。";
	header('Location: ../index.php');
