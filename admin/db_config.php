<?php

	// DB接続設定をreturnする
	function db_config() {
		//
		return array(
			'user' => 'keisuke',
			'database' => 'fileserver',
			'pass' => '2421',
			'host' => 'localhost',
			'charset' => 'utf8mb4',
		);
	}

	$up_dir = "/var/www/html/keisuke/fileserver/files/";