<?php

	session_start();
	require_once('admin/dbh.php');

	// ログイン状態チェック
	if (!isset($_SESSION['user']['id'])) {
		header("Location: admin/login.php");
		exit;
	}

	$dbh = get_dbh();
	$sql = "SELECT * FROM files WHERE user_id = {$_SESSION['user']['id']}";
	$pre = $dbh->prepare($sql);
	$pre->execute();
	$result = $pre->fetchAll();

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
		<p>ようこそ<u><?php echo htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES); ?></u>さん</p> <!-- ユーザー名をechoで表示 -->

		<div id="tabmenu">

			<div id="tab">
				<a href="#filelist">File List</a>
				<a href="#upload">Upload</a>
			</div>

			<div id="tab_contents">
				<ul>
					<li id="filelist" name="filelist">
						<?php if ($_SESSION['user']['id'] == $_SESSION['user']['id']): ?>
							<?php foreach ($result as $key): ?>
								<?php $filename = $key['file_name']; ?>
								<?php $id = $key['id']; ?>
								<table>
									<tr>
										<td><?php echo $filename; ?></td>
										<td>
											<form method="post" action="admin/download.php">
												<input name="file_id" type="hidden" value="<?php echo htmlspecialchars($id,ENT_COMPAT); ?>" />
   												<input name="token"  type="hidden" value="<?php echo htmlspecialchars(session_id(),ENT_COMPAT,'UTF-8'); ?>" />
												<input type="submit" value="Download">
											</form>
										</td>
										<td>
											<form method="post" action="admin/delete.php">
												<input name="file_id" type="hidden" value="<?php echo htmlspecialchars($id,ENT_COMPAT); ?>" />
   												<input name="token"  type="hidden" value="<?php echo htmlspecialchars(session_id(),ENT_COMPAT,'UTF-8'); ?>" />
												<input type="submit" value="Delete">
											</form>
										</td>
									</tr>
								</table>
							<?php endforeach ?>
						<?php endif ?>
					</li>

					<li id="upload" name="upload">
						<h4>Upload</h4>
						<form action="admin/upload.php" method="post" enctype="multipart/form-data">
							<input type="file" name="upfile" size="30" />
							<p><input type="submit" value="Upload"></p>
						</form>
					</li>	
				</ul>
			</div>
		</div>

		<ul>
			<li><a href="admin/logout.php">ログアウト</a></li>
		</ul>
	</body>
</html>