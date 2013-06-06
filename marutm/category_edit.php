<?php
	include "./inc/init.inc";
	
	$id = $_POST['category_id'];
	$title = $_POST['title'];
	$act_interval = $_POST['act_interval'];
	$startpage = $_POST['startpage'];
	$endpage = $_POST['endpage'];

	$fail_validation = false;
	if ($title == '' || $act_interval == '' || $startpage == '' || $endpage == '') {
		$fail_validation = true;
	} else if (!is_numeric($act_interval) || !is_numeric($startpage) || !is_numeric($endpage)) {
		$fail_validation = true;
	} else if ($startpage >= $endpage) {
		$fail_validation = true;
	} 

	$act_interval = intval($act_interval);
	$startpage = intval($startpage);
	$endpage = intval($endpage);

	if ($startpage < 1) $startpage = 1;	
	if ($endpage > 10) $endpage = 10;	

	if ($fail_validation) {
		echo "잘못된 입력값입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
		echo "크롤링 간격=$act_interval, 시작페이지=$startpage, 끝페이지=$endpage";
		exit();
	}

	// echo "id=$id, 크롤링 간격=$act_interval, 시작페이지=$startpage, 끝페이지=$endpage";

	$idb = new idb();
	$result = $idb->insert(query::editCategory, 'siiis', array($title, $act_interval, $startpage, $endpage, $id));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요.";
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
