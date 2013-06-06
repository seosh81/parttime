<?php
	include "./inc/init.inc";
	
	$name = $_POST['name'];
	$url = $_POST['url'];
	

	$fail_validation = false;
	if ($name == '' || $url == '') {
		$fail_validation = true;
	}

	
	if ($fail_validation) {
		echo "잘못된 입력값입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
		echo "name=$name, url=$url";
		echo "<br /><a href='" . _APP_ROOT_PATH . "/cafe_addForm.php'>돌아가기</a>";
		exit();
	}

	$idb = new idb();
	$result = $idb->insert(query::addCarCategory, 'ss', array($name, $url));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요.";
		echo $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
