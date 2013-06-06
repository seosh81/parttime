<?php
	include "./inc/init.inc";
	$idb = new idb();
	$category_list = $idb->select(query::getCategoryList);

	if (empty($category_list)) {
		echo "그룹을 먼저 만들어주세요.";
		echo "<a href='" . _APP_ROOT_PATH . "/index.php'>돌아가기</a>";
		exit();
	}
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
				<form method="post" action="cafe_add.php">
					<fieldset>
						<legend>카페 정보 입력 폼</legend>
						<label for="category_id">그룹:</label>
							<select id="category_id" name="category_id">
<?php
		foreach ($category_list as $category) {
			echo "<option value='$category[id]'>$category[title]</option>";
		}
								
?>								
								
							</select>
						<br />
						<label for="id">카페 ID:</label>
						<input type="text" id="id" name="id" />
						<br />
						<label for="title">타이틀:</label>
						<input type="text" id="title" name="title" />
						<br />
						<label for="display_order">출력 순서:</label>
						<input type="text" id="display_order" name="display_order" value="0" />
						<span>(0~100, 높을수록 우선순위 높음)</span>
						<br />
						<button type="submit">카페 등록</submit>
				</form>

			</div>
		</div>
	</body>
</html>
