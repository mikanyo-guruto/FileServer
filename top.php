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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	</head>
	
	<body>
		<h1>メイン画面</h1>
		<!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
		<p>ようこそ<u><?php echo htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES); ?></u>さん</p> <!-- ユーザー名をechoで表示 -->

        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="message_area">
                <p><?php echo $_SESSION['msg']; ?></p>
            </div>
        <?php unset($_SESSION['msg']); } ?>

		<div id="tabmenu">

			<div id="tab">
				<a href="#filelist">File List</a>
				<a href="#upload">Upload</a>
			</div>

			<div id="tab_contents">
				<ul>
					<li id="filelist" name="filelist">
						<?php if ($_SESSION['user']['id'] == $_SESSION['user']['id']): ?>
							<table border="1" cellspacing="0" cellpadding="5" >
								<tr>
										<th>ファイル名</th>
										<th></th>
										<th></th>
										<th>アップロード日付</th>
									</tr>
								<?php foreach ($result as $key): ?>
									<?php $id = $key['id']; ?>
										<tr>
											<td class="hoge1"><a data-target="<?php echo $key['id']; ?>" class="modal-open"><?php echo $key['file_name']; ?></a>
												<div id="<?php echo $key['id']; ?>" class="modal-content">
													<object type="text/html" data="<?php echo "./files/" . $key['path'] . $key['file_name']; ?>" width="100%" height="500px"></object>
													<p><a class="modal-close">閉じる</a></p>
												</div>
											</td>
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

											<td><?php echo $key['create_time']; ?></td>
										</tr>
								<?php endforeach; ?>
							</table>
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

	<script>
		$(function(){
		    // 「.modal-open」をクリック
		    $('.modal-open').click(function(){
		        // オーバーレイ用の要素を追加
		        $('.hoge1').append('<div class="modal-overlay"></div>');
		        // オーバーレイをフェードイン
		        $('.modal-overlay').fadeIn('slow');

		        // モーダルコンテンツのIDを取得
		        var modal = '#' + $(this).attr('data-target');
		        // モーダルコンテンツの表示位置を設定
		        modalResize();
		         // モーダルコンテンツフェードイン
		        $(modal).fadeIn('slow');

		        // 「.modal-overlay」あるいは「.modal-close」をクリック
		        $('.modal-overlay, .modal-close').off().click(function(){
		            // モーダルコンテンツとオーバーレイをフェードアウト
		            $(modal).fadeOut('slow');
		            $('.modal-overlay').fadeOut('slow',function(){
		                // オーバーレイを削除
		                $('.modal-overlay').remove();
		            });
		        });

		        // リサイズしたら表示位置を再取得
		        $(window).on('resize', function(){
		            modalResize();
		        });

		        // モーダルコンテンツの表示位置を設定する関数
		        function modalResize(){
		            // ウィンドウの横幅、高さを取得
		            var w = $(window).width();
		            var h = $(window).height();

		            // モーダルコンテンツの表示位置を取得
		            var x = (w - $(modal).outerWidth(true)) / 2;
		            var y = (h - $(modal).outerHeight(true)) / 2;

		            // モーダルコンテンツの表示位置を設定
		            $(modal).css({'left': x + 'px','top': y + 'px'});
		        }

		    });
		});
	</script>
</html>