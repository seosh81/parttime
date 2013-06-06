<?php
	include "./inc/init.inc";
?>
<html>
	<head>
		<title>카페 관련 크롤링 정보</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="category_add.php">
					<fieldset>
						<legend>그룹 정보 입력 폼</legend>
						<label for="id">그룹 ID:</label>
						<input type="text" id="id" name="id" />
						<br />
						<label for="title">타이틀:</label>
						<input type="text" id="title" name="title" />
						<br />
						<label for="keyword">검색어:</label>
						<textarea id="keowyrd" name="keyword"></textarea>
						<br />
						<label>크롤링 간격:</label>
						<input type="radio" name="act_interval" value="1" checked="checked">매시간
						<input type="radio" name="act_interval" value="2">2시간
						<input type="radio" name="act_interval" value="6">6시간
						<input type="radio" name="act_interval" value="12">12시간
						<br />
						<label for="startpage">페이지 설정:</label>
						<input type="text" id="endpage" name="endpage" value="10">
						<br />
						<button type="submit">그룹 등록</submit>
				</form>

			</div>
		</div>
	</body>
</html>
