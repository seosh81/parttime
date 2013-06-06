<?php
	include "./inc/init.inc";

	
	$category_id = $_GET['category_id'];

	$idb = new idb();
	$category = $idb->selectOne(query::getCategoryById, 's', array($category_id));
?>
<html>
	<head>
		<title>��α� ���� ��</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
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
					<input type="hidden" name="target" value="<?php echo $category['target'];?>" >
					<input type="hidden" name="search_option" value="<?php echo $category['search_option'];?>" >
					<fieldset>
						<legend>�׷� ���� ���� ��</legend>
						<label for="title">Ÿ��Ʋ:</label>
						<input type="text" id="title" name="title" value="<?php echo $category['title']?>"/>
						<br />
						<label for="keyword">�˻���:</label>
						<textarea id="keowyrd" name="keyword"><?php echo $category['keyword'];?></textarea>
						<br />
						<button type="submit">����</button><button type="button" onclick="history.back();return false;">���</button>
				</form>
			</div>
		</div>
	</body>
</html>
