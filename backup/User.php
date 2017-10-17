<?php

try {

	// データベースに接続
	$pdo = new PDO(
		'mysql:dbname=mikanyo;host=localhost;charset=utf8',
		'mikanyo',
		'mikanyo',
		[
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]
	);
} catch (PDOException $e) {
	header('Content-Type: text/plain; charset=UTF-8', true, 500);
	exit($e->getMessage());
}

