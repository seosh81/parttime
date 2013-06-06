<?php
	include "./inc/init.inc";
?>
<html>
	<head>
		<title>ī�� ���� ũ�Ѹ� ����</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/category.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<form method="post" action="category_add.php">
					<fieldset>
						<legend>�׷� ���� �Է� ��</legend>
						<label for="id">�׷� ID:</label>
						<input type="text" id="id" name="id" />
						<br />
						<label for="title">Ÿ��Ʋ:</label>
						<input type="text" id="title" name="title" />
						<br />
						<label for="display_order">��� ����:</label>
						<input type="text" id="display_order" name="display_order" value="0" />
						<span>(0~100, �������� �켱���� ����)</span>
						<br />
						<label>ũ�Ѹ� ����:</label>
						<input type="radio" name="act_interval" value="1" checked="checked">�Žð�
						<input type="radio" name="act_interval" value="2">2�ð�
						<input type="radio" name="act_interval" value="6">6�ð�
						<input type="radio" name="act_interval" value="12">12�ð�
						<br />
						<label for="startpage">������ ����:</label>
						<input type="text" id="startpage" name="startpage" value="1">~
						<input type="text" id="endpage" name="endpage" value="10">
						<br />
						<button type="submit">�׷� ���</submit>
				</form>

			</div>
		</div>
	</body>
</html>
