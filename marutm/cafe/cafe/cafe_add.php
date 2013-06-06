<?php
	include "./inc/init.inc";
	
	$category_id = $_POST['category_id'];
	$id = $_POST['id'];
	$title = $_POST['title'];
	$display_order = $_POST['display_order'];

	$fail_validation = false;
	if ($category_id == '' || $id == '' || $title == '' || $display_order == '') {
		$fail_validation = true;
	} else if (!is_numeric($display_order)) {
		$fail_validation = true;
	}

	$display_order = intval($display_order);

	if ($display_order < 0) $display_order = 0;
	if ($display_order > 100) $display_order = 100;

	if ($fail_validation) {
		echo "잘못된 입력값입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
		echo "카테고리=$category_id, 아이디=$id, 타이틀=$title, 노출순서=$display_order";
		echo "<br /><a href='" . _APP_ROOT_PATH . "/cafe_addForm.php'>돌아가기</a>";
		exit();
	}

	$url = "http://cafe.naver.com/".$id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $pattern = "/search.clubid=[0-9]+/";
    preg_match($pattern, $output, $match, PREG_OFFSET_CAPTURE);

    $club_id = substr($match[0][0], 14);

    if (strlen($club_id) != 8) {
    	echo "잘못된 카페 id입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
    	echo "<br /><a href='" . _APP_ROOT_PATH . "/cafe_addForm.php'>돌아가기</a>";
    	exit();
    }

	$idb = new idb();
	$result = $idb->insert(query::addCafe, 'ssssi', array($category_id, $id, $title, $club_id, $display_order));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요.";
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
