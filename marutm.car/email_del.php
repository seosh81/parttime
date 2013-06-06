<?php
	include "./inc/init.inc";
	
	$seq = $_POST['seq'];
	$idb = new idb();
	$result = $idb->insert(query::deleteEmail, 's', array($seq));
	echo $seq;
	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요.";
		echo $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>