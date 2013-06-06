<?php
	$code_file = $ckfile = dirname(__FILE__) . '/code_file.sav';
	// echo $code_file;
	$code_list = @$_POST['code_list'];
	if (isset($code_list)) {
		file_put_contents($code_file, $code_list);
	}
	
	$code_list = file_get_contents($code_file);
?>

<form action="input2.php" method="post">
	<textarea name="code_list" style="width:100px;height:250px;"><?php echo $code_list?></textarea>
	<button type="submit">save</button>
</form>
