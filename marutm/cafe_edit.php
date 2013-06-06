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
		echo "�߸��� �Է°��Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
        echo "ũ�Ѹ� ����=$act_interval, ����������=$startpage, ��������=$endpage";
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
        echo "�߸��� ī�� id�Դϴ�. �Է� �� Ȯ���� �ٽ� ��� �õ��ٶ��ϴ�.";
        echo "<br /><a href='javascript:history.back();return false;'>���ư���</a>";
        exit();
    }

	$idb = new idb();
	$result = $idb->insert(query::editCafeBySeq, 'ssssii', array($cafe_id, $category_id, $title, $club_id, $display_order, $cafe_seq));

	if (!$result) {
		echo "������ �߻��߽��ϴ�. �����ڿ��� �����ϼ���." . $idb->error_msg;
	} else {
		header( 'Location: '._APP_ROOT_PATH.'/index.php?category_id='.$id ) ;
	}
?>
