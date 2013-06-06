<?php
	include "./inc/init.inc";
	$seq = $_GET['seq'];

	$idb = new idb();
	$category = $idb->selectOne(query::getCarCategory, 's', array($seq));

?>
<html>
	<head>
		<title>자동차 카테고리 수정</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="category_edit.php">
					<input type="hidden" name="seq" value="<?=$seq?>" />
					<fieldset>
						<legend>카테고리 정보 입력 폼</legend>
						<br />
						<label for="name">이름:</label>
						<input type="text" id="name" name="name" value="<?= $category['name']?>" style="width:300px;"/>
						<br />
						<label for="url">url:</label>
						<input type="text" id="url" name="url" value="<?= $category['url']?>" style="width:400px;"/>
						<br />
						<button type="submit">카테고리 수정</button>
						<a href="javascript:confirm_delete('<?=$seq?>');"><button type="button">카테고리 삭제</button></a>
				</form>
			</div>
		</div>
<script type="text/javascript">
	function confirm_delete(seq) {
		var response = confirm('delete?');
		if (response) {
			var form = document.createElement("form");
	        form.setAttribute("method", "post");
	        form.setAttribute("action", "category_del.php");
	        
	        var seqField = document.createElement("input");
	        seqField.setAttribute("name", "seq");
	        seqField.setAttribute("value",seq);
	        seqField.setAttribute("type", "hidden");
	        
	        form.appendChild(seqField);
	        document.body.appendChild(form);
	        form.submit();
		}
	}
</script>
	</body>
</html>
