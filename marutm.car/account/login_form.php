<?
	$requestUri = $_GET["requestUri"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" class="ie7"><![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>로그인</title>
	<link rel="stylesheet" href="../assets/css/reset.css" />
<style type="text/css">
body * {
	font-family: NanumGothic,"나눔고딕", '돋움';
	font-size: 12px;
}
.main_wrapper {
	width: 360px;
	height: 270px;
	margin: 200px auto;
	border-top: 4px solid #f32991;
	border-bottom: 4px solid #f32991;
}
.main_wrapper div {
	margin: 39px 0;
}
.title {
	width: 300px;
	text-align: center;
	font-weight: bold;
	color: #f32991;
}
.login-form {
	width: 360px;
}
.login-form h4{
	text-align: center;
	font-size: 20px;
	margin-bottom: 10px;
}
.login-form h6{
	text-align: center;
	font-size: 10px;
	margin-bottom: 20px;
}
.login-form legend {
	display: none;
}
.login-form .txt {
	width: 250px;
	margin: 0 0 10px 50px;
	border: 1px solid #CCC;
	height: 30px;
	padding-left: 20px;
}
.login {
	display:block;
	background-color:#f32991;
	width:272px;
	height:30px;
	border:none;
	cursor:pointer;
	font-size:17px;
	text-decoration:none;
	color:white;
	line-height:30px;
	vertical-align:middle;
	text-align:center;
	margin-left: 50px;
}
</style>
<script type="text/javascript">
function checkInput() {
	if (document.login.id.value === "") {
		alert("아이디를 입력해주세요.");
		document.login.id.focus();
		return false;
	}
	if (document.login.password.value === "") {
		alert("비밀번호를 입력해주세요.");
		document.login.password.focus();
		return false;
	}
	document.login.submit();
}
</script>
</head>
	<body>
		<div class="main_wrapper">
			<div class="login-form">
				<h4>로그인 정보 입력</h4>
				<form id="login" name="login" action="process_login.php" method="post" onsubmit="return checkInput();">
					<fieldset>
						<legend>로그인 정보</legend>
					</fieldset>
					<input class="txt" type="text" id="id" name="id" placeholder="아이디" />
					<input class="txt" type="password" id="password" name="password" placeholder="비밀번호" />
					<input type="hidden" name="requestUri" value="<?=$requestUri?>" />
					<input type="submit" value="로그인" class="login" />
				</form>
			</div>
			<!-- <div style="width:150px;margin:0 auto;">
				<a href="javascript:submit();" class="btn">로그인</a>
			</div> -->
		</div>
	</body>
</html>