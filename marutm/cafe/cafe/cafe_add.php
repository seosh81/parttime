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
		echo "�߸��� �Է°��Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
		echo "ī�װ�=$category_id, ���̵�=$id, Ÿ��Ʋ=$title, �������=$display_order";
		echo "<br /><a href='" . _APP_ROOT_PATH . "/cafe_addForm.php'>���ư���</a>";
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
    	echo "�߸��� ī�� id�Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
    	echo "<br /><a href='" . _APP_ROOT_PATH . "/cafe_addForm.php'>���ư���</a>";
    	exit();
    }

	$idb = new idb();
	$result = $idb->insert(query::addCafe, 'ssssi', array($category_id, $id, $title, $club_id, $display_order));

	if (!$result) {
		echo "������ �߻��߽��ϴ�. �����ڿ��� �����ϼ���.";
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php' ) ;
	}
?>
