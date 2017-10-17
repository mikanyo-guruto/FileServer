<?php
	session_start();

	$db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "mikanyo";  // ユーザー名
    $db['pass'] = "mikanyo";  // ユーザー名のパスワード
    $db['dbname'] = "mikanyo";  // データベース名

    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
	$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

	$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = {$_SESSION["id"]}");
	$stmt->execute();
	$result = $stmt->fetchAll();

	// ログイン状態チェック
	if (!isset($_SESSION["NAME"])) {
		header("Location: login.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>メイン</title>
		<link href="css/style.css" rel="stylesheet">
	</head>
	
	<body>
		<h1>メイン画面</h1>
		<!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
		<p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p> <!-- ユーザー名をechoで表示 -->

		<div id="tabmenu">

			<div id="tab">
				<a href="#filelist">File List</a>
				<a href="#upload">Upload</a>
			</div>

			<div id="tab_contents">
				<ul>
					<li id="filelist" name="filelist">
						<?php if ($_SESSION["id"] == $_SESSION["id"]): ?>
							<?php foreach ($result as $key): ?>
								<?php $filename = $key['file_name']; ?>
								<table>
									<tr>
										<td><?php echo $filename; ?></td>
										<td>
											<form method="post" action="download.php">
												<input name="dlfile" type="hidden" value="<?php echo htmlspecialchars($filename,ENT_COMPAT); ?>" />
   												<input name="token"  type="hidden" value="<?php echo htmlspecialchars(session_id()       ,ENT_COMPAT,'UTF-8'); ?>" />
												<input type="submit" value="Download">
											</form>
										</td>
									</tr>
								</table>
							<?php endforeach ?>
						<?php endif ?>
					</li>

					<li id="upload" name="upload">
						<h4>Upload</h4>
						<form action="upload.php" method="post" enctype="multipart/form-data">
							<input type="file" name="upfile" size="30" />
							<p><input type="submit" value="Upload"></p>
						</form>
					</li>	
				</ul>
			</div>
		</div>

		<ul>
			<li><a href="logout.php">ログアウト</a></li>
		</ul>
	</body>
</html>