<?php
    // セッション開始
    session_start();

    $db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "mikanyo";  // ユーザー名
    $db['pass'] = "mikanyo";  // ユーザー名のパスワード
    $db['dbname'] = "mikanyo";  // データベース名

    // エラーメッセージの初期化
    $errorMessage = "";

    // ログインボタンが押された場合
    if (isset($_POST["login"])) {
        // 1. ユーザIDの入力チェック
        if (empty($_POST["user_id"])) {  // emptyは値が空のとき
            $errorMessage = 'ユーザーIDが未入力です。';
        } else if (empty($_POST["pass"])) {
            $errorMessage = 'パスワードが未入力です。';
        }

        if (!empty($_POST["user_id"]) && !empty($_POST["pass"])) {
            // 入力したユーザIDを格納
            $userid = $_POST["user_id"];
            /*
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = $userid');
            $stmt->execute();
            $result = $stmt->fetchAll();
            $_SESSION["id"] = $result;
            */


            // 2. ユーザIDとパスワードが入力されていたら認証する
            $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

            // 3. エラー処理
            try {
                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                
                $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
                //$stmt->bindValue(':id', "%{$userid}%");
                $stmt->execute(array($userid));

                $pass = $_POST["pass"];

                $row = $stmt->fetchAll();

                if (isset($row)) {
                    if (password_verify($pass, $row[0]['pass'])) {
                        session_regenerate_id(true);

                        $_SESSION["NAME"] = $row[0]['name'];
                        $_SESSION["id"] = $row[0]['id'];
                        header("Location: main.php");  // メイン画面へ遷移
                        exit();  // 処理終了
                    } else {
                        // 認証失敗
                        $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。1';
                    }
                } else {
                    // 4. 認証成功なら、セッションIDを新規に発行する
                    // 該当データなし
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。2';
                }
            } catch (PDOException $e) {
                $errorMessage = 'データベースエラー';
                $errorMessage = $sql;
                $e->getMessage(); // でエラー内容を参照可能（デバック時のみ表示）
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="user_id">ユーザーID</label><input type="text" id="user_id" name="user_id" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["user_id"])) {echo htmlspecialchars($_POST["user_id"], ENT_QUOTES);} ?>">
                <br>
                <label for="pass">パスワード</label><input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>
        <form action="signup.php">
            <fieldset>          
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>
    </body>
</html>