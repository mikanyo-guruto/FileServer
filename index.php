<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>ログインページ</title>
		<!-- CSS読み込み -->
		<link href="css/style.css" rel="stylesheet">
	</head>

	<body>
		<div id="tabmenu">
			<div id="tab">
				<a href="#signin">Sign In</a>
				<a href="#signup">Sign Up</a>
			</div>

			<div id="tab_contents">
				<ul>
					<li id="signin" name="signin">
						<h4>Sign In</h4>
                        <form>
                            <p>ID：<input type="text" name="id" size="32"></p>
                            <p>PASS：<input type="text" name="pass" size="29"></p>
                            <p>NAME：<input type="text" name="name" size="27"></p>
                            <p><input type="button" onclick="location.href='mainmenu.php'" value="Sign In"></p>
                        </form>
					</li>

					<li id="signup" name="signup">
						<h4>Sign Up</h4>
                        <form>
                            <p>ID：<input type="text" name="id" size="32"></p>
                            <p>PASS：<input type="text" name="pass" size="29"></p>
                            <p>NAME：<input type="text" name="name" size="27"></p>
                            <p><input type="button" onclick="location.href='mainmenu.php'" value="Sign Up"></p>
                        </form>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>