<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF=8">
		<title>メインメニュー</title>
    	<!-- CSS読み込み -->
    	<link href="css/style.css" rel="stylesheet">
	</head>

	<body>

		<div id="tabmenu">

			<div id="tab">
				<a href="#filelist">File List</a>
				<a href="#upload">Upload</a>
			</div>

			<div id="tab_contents">
				<ul>
					<li id="filelist" name="filelist">
						<table>
							<tr>
								<th>file name</th>
							</tr>
							<tr>
								<td><a href="#">hoge</a></td>
								<td><input type="submit" value="Download"></td>
								<td><input type="submit" value="Delete"></td>
							</tr>
							<tr>
								<td><a href="#">hoge</a></td>
								<td><input type="submit" value="Download"></td>
								<td><input type="submit" value="Delete"></td>
							</tr>
							<tr>
								<td><a href="#">hoge</a></td>
								<td><input type="submit" value="Download"></td>
								<td><input type="submit" value="Delete"></td>
							</tr>
							<tr>
								<td><a href="#">hoge</a></td>
								<td><input type="submit" value="Download"></td>
								<td><input type="submit" value="Delete"></td>
							</tr>
						</table>
					</li>

					<li id="upload" name="upload">
						<h4>Upload</h4>
						<form>
							<p><input type="file" name="filepath" size="32"></p>
							<p><input type="submit" value="Upload"></p>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>