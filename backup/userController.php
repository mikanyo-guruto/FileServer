<?php

require 'User.php';

// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// エラーボタンが押された場合
if (isset($_POST["login"]))