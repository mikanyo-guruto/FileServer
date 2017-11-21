<?php
	session_start();
	ini_set('display_errors', 1);
	require_once('./dbh.php');

	function delete() {
		$flg = false;

		$dbh = get_dbh();
		$sql = "SELECT * FROM files WHERE user_id = ? AND id = ?";
		$pre = $dbh->prepare($sql);
		$pre->execute(array($_SESSION['user']['id'], $_POST['file_id']));
		$result = $pre->fetchAll();

		$path = $result[0]['path'];

		if(file_exists($path)) {
			$delsql = "DELETE FROM files WHERE user_id = ? AND id = ?";
	    	$pre = $dbh->prepare($delsql);
			if(unlink($path) && $pre->execute(array($_SESSION['user']['id'], $_POST['file_id']))) {
				//echo "削除しました。";
				return true;
			}else{
				$flg = "削除できませんでした。";
			}
		}else{
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