<?php
    // セッション開始
    session_start();

    $db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "mikanyo";  // ユーザー名
    $db['pass'] = "mikanyo";  // ユーザー名のパスワード
    $db['dbname'] = "mikanyo";  // データベース名
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>hoge</title>
	</head>

	<body>
		<p>
			<?php
				if(is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
					if(move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/". $_FILES["upfile"]["name"])) {
						chmod("files/". $_FILES["upfile"]["name"], 0644);
						$path = "http://dev2.m-fr.net/keisuke07/FileServer/files/{$_FILES["upfile"]["name"]}";
						$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
						$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
						//$stmt = $pdo->prepare("INSERT INTO files(user_id, dir_id, file_name, path) VALUES ({$_SESSION["userid"]}, 0, {$_FILES["upfile"]["name"]}, {$path})");
						//$stmt->execute();
						$stmt = $pdo->prepare("INSERT INTO files(user_id, dir_id, file_name, path) VALUES (:user_id, :dir_id, :file_name, :path)");
						$stmt->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_STR);
						$stmt->bindValue(':dir_id', 0, PDO::PARAM_INT);
						$stmt->bindValue(':file_name', $_FILES["upfile"]["name"], PDO::PARAM_STR);
						$stmt->bindValue(':path', $path, PDO::PARAM_STR);
						$stmt->execute();
						echo $_FILES["upfile"]["name"]."をアップロードしました。";
					} else {
						echo "ファイルをアップロードできません。";
					}
				} else {
					echo "ファイルが選択されていません。";
				}
			?>
		</p>
		<a href="main.php">戻る</a>
	</body>
</html>