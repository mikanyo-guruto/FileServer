<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="admin/signup.php" method="POST">
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