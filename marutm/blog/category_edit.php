<?php
	include "./inc/init.inc";
	
	$id = $_POST['category_id'];
	$title = $_POST['title'];
	$keyword = $_POST['keyword'];
	$act_interval = $_POST['act_interval'];
	$search_option = $_POST['search_option'];
	$target = $_POST['target'];
	$endpage = $_POST['endpage'];

	$fail_validation = false;
	if ($title == '' || $keyword == '' || $act_interval == '' || $endpage == '') {
		$fail_validation = true;
	} else if (!is_numeric($act_interval) || !is_numeric($endpage)) {
		$fail_validation = true;
	} 

	$act_interval = intval($act_interval);
	$endpage = intval($endpage);

	if ($endpage > 100) $endpage = 100;	

	if ($fail_validation) {
		echo "잘못된 입력값입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
		echo "아이디=$id, 타이틀=$title, 키워드=$keyword, 크롤링 간격=$act_interval, 끝페이지=$endpage";
		exit();
	}
	$keyword = preg_replace('!\s+!', ' ', $keyword);
	
	$idb = new idb();
	$result = $idb->insert(query::editCategory, 'ssiisss', array($title, $keyword, $act_interval, $endpage, $search_option, $target, $id));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요." . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
