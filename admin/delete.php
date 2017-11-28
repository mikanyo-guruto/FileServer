<?php
	session_start();
	ini_set('display_errors', 1);

	function delete() {
		require_once('./dbh.php');

		// return用のフラグを用意
		$flg = false;

		// DBにアクセス
		$dbh = get_dbh();
		// ファイル情報を読み込む
		$sql = "SELECT * FROM files WHERE user_id = ? AND id = ?";
		$pre = $dbh->prepare($sql);
		$pre->execute(array($_SESSION['user']['id'], $_POST['file_id']));
		$result = $pre->fetch(PDO::FETCH_ASSOC);

		// ファイルが存在しているパス
		$filepath = "{$up_dir}{$result['path']}";
		if(file_exists($filepath)) {
			$delsql = "DELETE FROM files WHERE user_id = ? AND id = ?";
	    	$pre = $dbh->prepare($delsql);
	    	// ファイルを削除する
	    	// ディレクトリを削除する
	    	// DBを削除する
	    	if (unlink("{$filepath}{$result['file_name']}") && 
	    		rmdir($filepath) && 
	    		$pre->execute(array($_SESSION['user']['id'], $_POST['file_id']))) {
				//echo "削除しました。";
				return true;
			} else {
				$flg = "削除できませんでした。";
			}
		} else {
			$flg = "ファイルが存在しません。";
		}
		return $flg;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>デリート結果</title>
	</head>

	<body>
		<?php if(is_bool($p = delete()) == true){ ?>
			<p>削除しました。</p>
		<?php }else{ ?>
			<p><?php echo $p; ?></p>
		<?php }?>
		<a href="../top.php"><br>戻る</a>
	</body>
</html>