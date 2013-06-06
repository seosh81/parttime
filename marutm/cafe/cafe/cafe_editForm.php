<?php
	include "./inc/init.inc";

	$idb = new idb();
	$category_list = $idb->select(query::getCategoryList);

	if (empty($category_list)) {
		echo "Ŭ���� ���� ����� �ּ���.";
		echo "<a href='" . _APP_ROOT_PATH . "/index.php'>�ڷΰ���</a>";
		exit();
	}

	$cafe_seq = $_GET['cafe_seq'];
	$cafe = $idb->selectOne(query::getCafeBySeq, 's', array($cafe_seq));
?>
<html>
	<head>
		<title>ī�� ���� �Է� ��</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
	</head>
	<body>	
		<div class="wrapper">
			<div class="main">
				<form method="post" action="cafe_edit.php" id="cafe_form">
					<input type="hidden" name="cafe_seq" id="cafe_seq" value="<?php echo $cafe_seq?>">
					<input type="hidden" id="category_id" name="category_id" value="<?php echo $cafe['category_id'];?>">
					<fieldset>
						<legend>ī�� ���� �Է� ��</legend>
						
						<label for="id">ī�� ID</label>
						<input type="text" id="id" name="id" value="<?php echo $cafe['id']?>" />
						<br />
						<label for="title">Ÿ��:</label>
						<input type="text" id="title" name="title" value="<?php echo $cafe['title']?>"/>
						<br />
						<label for="display_order">��¼���:</label>
						<input type="text" id="display_order" name="display_order" value="<?php echo $cafe['display_order']?>" />
						<span>(0~100)</span>
						<br />
						<button type="submit">����</button><button type="button" onclick="history.back();return false;">���</button><button type="button" onclick="deleteCafe();">����</button>
				</form>
			</div>
		</div>
<script type="text/javascript">
var form = document.getElementById('cafe_form');
function deleteCafe() {
	form.action='cafe_delete.php';
	form.submit();
}
</script>
	</body>
</html>
