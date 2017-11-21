<?php
    // セッション開始
    session_start();
    ini_set('display_errors', 1);
	require_once('./dbh.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>アップロード結果</title>
	</head>

	<body>
		<p>
			<?php
				// 一時ファイルができているか（アップロードされているか）チェック
				if(is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
					// 一時ファイルを保存ファイルにコピーできたか
					if(move_uploaded_file($_FILES["upfile"]["tmp_name"], "../files/". $_FILES["upfile"]["name"])){
						chmod("../files/". $_FILES["upfile"]["name"], 0644);
						$path = $up_dir . "{$_FILES["upfile"]["name"]}";
						$dbh = get_dbh();
						$sql = "INSERT INTO files(user_id, dir_id, file_name, path) VALUES (:user_id, :dir_id, :file_name, :path)";
						$pre = $dbh->prepare($sql);
						$pre->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_STR);
						$pre->bindValue(':dir_id', 0, PDO::PARAM_INT);
						$pre->bindValue(':file_name', $_FILES["upfile"]["name"], PDO::PARAM_STR);
						$pre->bindValue(':path', $path, PDO::PARAM_STR);
						$pre->execute();
						echo $_FILES["upfile"]["name"]."をアップロードしました。";
					} else {
						echo "ファイルをアップロードできませんでした。";
					}
				} else {
					echo "ファイルが選択されていません。";
				}
			?>
		</p>
		<a href="../top.php">戻る</a>
	</body>
</html>