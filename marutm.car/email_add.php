<?php
	include "./inc/init.inc";
	
	$email = $_POST['email'];
	
	$idb = new idb();
	$result = $idb->insert(query::addEmail, 's', array($email));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요.";
		echo $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
