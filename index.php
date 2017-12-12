<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>

        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="message_area">
                <p><?php echo $_SESSION['msg']; ?></p>
            </div>
        <?php unset($_SESSION['msg']); } ?>

        <form action="admin/login.php" method="post">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"></font></div>
                <label>ユーザーID</label><input type="text" name="id" value="" placeholder="ユーザーIDを入力">
                <br>
                <label>パスワード</label><input type="password" name="pw" value="" placeholder="パスワードを入力">
                <br>
                <button>ログイン</button>
            </fieldset>
        </form>
        <br>
        <form action="signuppage.php">
            <fieldset>          
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>
    </body>
</html>