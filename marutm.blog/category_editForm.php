<?php
	include "./inc/init.inc";

	
	$category_id = $_GET['category_id'];

	$idb = new idb();
	$category = $idb->selectOne(query::getCategoryById, 's', array($category_id));
?>
<html>
	<head>
		<title>그룹 정보 수정 폼</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="category_edit.php" id="category_form">
					<input type="hidden" name="category_id" value="<?php echo $category['id'];?>" >
					<input type="hidden" name="act_interval" value="<?php echo $category['act_interval'];?>" >
					<input type="hidden" name="endpage" value="<?php echo $category['endpage'];?>" >
					<fieldset>
						<legend>그룹 정보 수정 폼</legend>
						<label for="title">타이틀:</label>
						<input type="text" id="title" name="title" value="<?php echo $category['title']?>"/>
						<br />
						<label for="keyword">검색어:</label>
						<textarea id="keowyrd" name="keyword"><?php echo $category['keyword'];?></textarea>
						<br />
						<button type="submit">수정</button><button type="button" onclick="history.back();return false;">취소</button>
				</form>
			</div>
		</div>
	</body>
</html>
