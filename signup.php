<?php
    // セッション開始
    session_start();

    $db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "mikanyo";  // ユーザー名
    $db['pass'] = "mikanyo";  // ユーザー名のパスワード
    $db['dbname'] = "mikanyo";  // データベース名

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
            $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

            // 3. エラー処理
            try {
                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

                $stmt = $pdo->prepare("INSERT INTO users(user_id, name, pass) VALUES (?, ?, ?)");

                $stmt->execute(array($userid, $username, password_hash($pass, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
                $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

                $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $pass. ' です。';  // ログイン時に使用するIDとパスワード
            } catch (PDOException $e) {
                $errorMessage = 'データベースエラー';
                $e->getMessage(); // でエラー内容を参照可能（デバック時のみ表示）
                echo $e->getMessage();
            }
        }
    }
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="user_id">ユーザーID</label><input type="text" id="user_id" name="user_id" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["user_id"])) {echo htmlspecialchars($_POST["user_id"], ENT_QUOTES);} ?>">
                <br>
                <label for="name">ユーザー名</label><input type="text" id="name" name="name" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["name"])) {echo htmlspecialchars($_POST["name"], ENT_QUOTES);} ?>">
                <br>
                <label for="pass">パスワード</label><input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>