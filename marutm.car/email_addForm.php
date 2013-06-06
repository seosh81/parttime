<html>
	<head>
		<title>메일 수신정보 추가</title>
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
				<form method="post" action="email_add.php">
					<fieldset>
						<legend>이메일 정보 입력 폼</legend>
						<br />
						<label for="email">email</label>
						<input type="text" id="email" name="email"  style="width:200px;" />
						<br />
						<button type="submit">이메일 등록</submit>
						<a href="./index.php"><button type="button">돌아가기</submit></a>
				</form>
			</div>
			
		</div>
	</body>
</html>
