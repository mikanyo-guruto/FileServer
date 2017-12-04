<?php
    // セッション開始
    session_start();
    ini_set('display_errors', 1);
    require_once('./dbh.php');

    // エラーメッセージ、登録完了メッセージの初期化
    $errorMessage = "";
    $signUpMessage = "";

    // ログインボタンが押された場合
    if (isset($_POST["signUp"])) {
        // 1. ユーザIDの入力チェック
        if (empty($_POST["user_id"])) {  // 値が空のとき
            $errorMessage = 'ユーザーIDが未入力です。';
        } else if (empty($_POST["name"])) {
            $errorMessage = 'ユーザー名が未入力です。';
        } else if (empty($_POST["pass"])) {
            $errorMessage = 'パスワードが未入力です。';
        }

        if (!empty($_POST["user_id"]) && !empty($_POST["name"]) && !empty($_POST["pass"])) {
            // 入力したユーザIDとパスワードを格納
            $userid = $_POST["user_id"];
            $username = $_POST["name"];
            $pass = $_POST["pass"];

            // 2. ユーザIDとパスワードが入力されていたら認証する
            //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

            // 3. エラー処理
            try {
                //$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

                //$stmt = $pdo->prepare("INSERT INTO users(user_id, name, pass) VALUES (?, ?, ?)");

                //$stmt->execute(array($userid, $username, password_hash($pass, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
                //$userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

                $dbh = get_dbh();
                $sql = "INSERT INTO users(user_id, name, pass, create_time) VALUES(?, ?, ?, ?)";
                $pre = $dbh->prepare($sql);
                $pre->execute(array($userid, $username, password_hash($pass, PASSWORD_DEFAULT), date("Y-m-d H:i:s")));
                //$userid = $dbh->lastinsertid();

                $signUpMessage = '登録が完了しました。';  // ログイン時に使用するIDとパスワード
                echo $signUpMessage;
            } catch (PDOException $e) {
                $errorMessage = 'データベースエラー';
                $e->getMessage(); // でエラー内容を参照可能（デバック時のみ表示）
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<hrml>
    <head>
        <meta charset="UTF-8">
        <title>新規登録結果</title>
    </head>
    <body>
        <ul>
            <li><a href="../index.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</hrml>