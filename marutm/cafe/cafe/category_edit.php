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
		echo "�߸��� �Է°��Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
		echo "ũ�Ѹ� ����=$act_interval, ����������=$startpage, ��������=$endpage";
		exit();
	}

	// echo "id=$id, ũ�Ѹ� ����=$act_interval, ����������=$startpage, ��������=$endpage";

	$idb = new idb();
	$result = $idb->insert(query::editCategory, 'siiis', array($title, $act_interval, $startpage, $endpage, $id));

	if (!$result) {
		echo "������ �߻��߽��ϴ�. �����ڿ��� �����ϼ���.";
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
