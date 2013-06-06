<html>
	<head>
		<title>자동차 카테고리 추가</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="category_add.php">
					<fieldset>
						<legend>카테고리 정보 입력 폼</legend>
						<br />
						<label for="name">이름:</label>
						<input type="text" id="name" name="name" />
						<br />
						<label for="url">url:</label>
						<input type="text" id="url" name="url" />
						<br />
						<button type="submit">카테고리 등록</submit>
				</form>

			</div>
		</div>
	</body>
</html>
