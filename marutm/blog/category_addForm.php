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
						<label for="keyword">�˻���:</label>
						<textarea id="keowyrd" name="keyword"></textarea>
						<br />
						<label for="search_option">�˻��ɼ�:</label>
						<input type="radio" name="search_option" value="recent" checked="checked">�ֽ�
						<input type="radio" name="search_option" value="correct">��Ȯ��
						<br />
						<label for="target">����Ʈ:</label>
						<input type="radio" name="target" value="naver" checked="checked">naver
						<input type="radio" name="target" value="daum">daum
						<input type="radio" name="target" value="all">all
						<br />
						<label>ũ�Ѹ� ����:</label>
						<input type="radio" name="act_interval" value="1" checked="checked">�Žð�
						<input type="radio" name="act_interval" value="2">2�ð�
						<input type="radio" name="act_interval" value="6">6�ð�
						<input type="radio" name="act_interval" value="12">12�ð�
						<br />
						<label for="startpage">������ ����:</label>
						<input type="text" id="endpage" name="endpage" value="10">
						<br />
						<button type="submit">�׷� ���</submit>
				</form>

			</div>
		</div>
	</body>
</html>
