<?php
    // セッション開始
    session_start();
    ini_set('display_errors', 1);
    require_once('./dbh.php');

    function redirect($msg) {
        // indexに返す
        $_SESSION['msg'] = $msg;
        header('Location: ../index.php');
        exit;
    }

    // 入力したユーザIDとパスワードを格納
    $userid = $_POST["user_id"];
    $username = $_POST["name"];
    $pass = $_POST["pass"];

    // ログインボタンが押された場合
    if (isset($_POST["signUp"])) {
        // 1. ユーザIDの入力チェック
        if (empty($userid)) {  // 値が空のとき
            redirect('ユーザーIDが未入力です。');
        } else if (empty($username)) {
            redirect('ユーザー名が未入力です。');
        } else if (empty($pass)) {
            redirect('パスワードが未入力です。');
        }


        // 2. ユーザIDとパスワードが入力されていたら認証する
        //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $dbh = get_dbh();
            $sql = "INSERT INTO users(user_id, name, pass, create_time) VALUES(?, ?, ?, ?)";
            $pre = $dbh->prepare($sql);
            $pre->execute(array($userid, $username, password_hash($pass, PASSWORD_DEFAULT), date("Y-m-d H:i:s")));
            //$userid = $dbh->lastinsertid();

            redirect('登録が完了しました。');  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            redirect('DBで何らかのエラーが発生しました。');
            echo $e->getMessage(); // でエラー内容を参照可能（デバック時のみ表示）
        }
    }
