<?php
	include "./inc/init.inc";
	
	$cafe_seq = $_POST['cafe_seq'];
	$category_id = $_POST['category_id'];

	$idb = new idb();
	$result = $idb->insert(query::deleteCafeBySeq, 'i', array($cafe_seq));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요." . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
