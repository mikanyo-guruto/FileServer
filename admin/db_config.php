<?php

// DB接続設定をreturnする
function db_config() {
		// 
		return array(
			'user' => '',
			'database' => '',
			'pass' => '',
			'host' => 'localhost',
			'charset' => 'utf8mb4',
		);
	}
	$up_dir = realpath("../") . "/files/";
