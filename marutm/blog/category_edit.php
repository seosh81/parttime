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
		echo "�߸��� �Է°��Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
		echo "���̵�=$id, Ÿ��Ʋ=$title, Ű����=$keyword, ũ�Ѹ� ����=$act_interval, ��������=$endpage";
		exit();
	}
	$keyword = preg_replace('!\s+!', ' ', $keyword);
	
	$idb = new idb();
	$result = $idb->insert(query::editCategory, 'ssiisss', array($title, $keyword, $act_interval, $endpage, $search_option, $target, $id));

	if (!$result) {
		echo "������ �߻��߽��ϴ�. �����ڿ��� �����ϼ���." . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
