<?
	include "./inc/init.inc";
	
	$seq = $_GET['seq'];
	
	$idb = new idb();
	$email = $idb->selectOne(query::getEmail, 's', array($seq));
?>
<html>
	<head>
		<title>메일 수신정보 수정</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
		<style>
a:link {
    text-decoration: none;
}
a:active {
    text-decoration: none;
}
a:visited {
    color:black;
    text-decoration: none;
}
a:hover {
    text-decoration: none;
}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="email_edit.php">
					<input type="hidden" name="seq" value="<?=$seq?>" />
					<fieldset>
						<legend>이메일 정보 수정 폼</legend>
						<br />
						<label for="email">email</label>
						<input type="text" id="email" name="email" value="<?=$email['email']?>" style="width:200px;" />
						<br />
						<button type="submit">이메일 수정</submit>
						<a href="./index.php"><button type="button">돌아가기</submit></a>
						<a href="javascript:confirm_delete('<?=$seq?>');"><button type="button">이메일 삭제</button></a>
				</form>
			</div>
		</div>
<script type="text/javascript">
	function confirm_delete(seq) {
		var response = confirm('delete?');
		if (response) {
			var form = document.createElement("form");
	        form.setAttribute("method", "post");
	        form.setAttribute("action", "email_del.php");
	        
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
