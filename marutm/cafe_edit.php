<?php
	include "./inc/init.inc";
	
	$cafe_seq = $_POST['cafe_seq'];
	$cafe_id = $_POST['id'];
	$category_id = $_POST['category_id'];
	$display_order = $_POST['display_order'];
	$title = $_POST['title'];

	$fail_validation = false;
	if ($cafe_seq == '' || $cafe_id == '' || $title == '' || $category_id == '' || $display_order == '') {
		$fail_validation = true;
	}

	if ($fail_validation) {
		echo "잘못된 입력값입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
        echo "크롤링 간격=$act_interval, 시작페이지=$startpage, 끝페이지=$endpage";
		exit();
	}

	$url = "http://cafe.naver.com/".$cafe_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $pattern = "/search.clubid=[0-9]+/";
    preg_match($pattern, $output, $match, PREG_OFFSET_CAPTURE);

    $club_id = substr($match[0][0], 14);
    echo $cafe_id;
    if (strlen($club_id) != 8) {
        echo "잘못된 카페 id입니다. 입력 값 확인후 다시 등록 시도바랍니다.";
        echo "<br /><a href='javascript:history.back();return false;'>돌아가기</a>";
        exit();
    }

	$idb = new idb();
	$result = $idb->insert(query::editCafeBySeq, 'ssssii', array($cafe_id, $category_id, $title, $club_id, $display_order, $cafe_seq));

	if (!$result) {
		echo "에러가 발생했습니다. 관리자에게 문의하세요." . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
