<?php
	include "./inc/init.inc";
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$keyword = $_POST['keyword'];
	$act_interval = $_POST['act_interval'];
	$search_option = $_POST['search_option'];
	$target = $_POST['target'];
	$endpage = $_POST['endpage'];

	$fail_validation = false;
	if ($id == '' || $title == '' || $act_interval == '' || $keyword == '' || $endpage == '') {
		$fail_validation = true;
	} else if (!is_numeric($act_interval) || !is_numeric($endpage)) {
		$fail_validation = true;
	}

	$act_interval = intval($act_interval);
	$endpage = intval($endpage);

	if ($endpage > 100) $endpage = 100;	

	if ($fail_validation) {
		echo "�߸��� �Է°��Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
		echo "���̵�=$id, Ÿ��Ʋ=$title, ũ�Ѹ� ����=$act_interval, ��������=$endpage";
		exit();
	}
	// echo "���̵�=$id, Ÿ��Ʋ=$title, keyword=$keyword, keyword.length=".strlen($keyword)."ũ�Ѹ� ����=$act_interval, ��������=$endpage";
	// echo $keyword;
	// echo preg_replace('!\s+!', ' ', $keyword);
	$keyword = preg_replace('!\s+!', ' ', $keyword);


	$idb = new idb();
	$result = $idb->insert(query::addCategory, 'sssiiss', array($id, $title, $keyword, $act_interval, $endpage, $search_option, $target));

	if (!$result) {
		echo "������ �߻��߽��ϴ�. �����ڿ��� �����ϼ���."  . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
