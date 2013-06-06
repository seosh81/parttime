<?
	include "./inc/init.inc";
	$startdate = @$_POST['startdate'];
	$enddate = @$_POST['enddate'];
	$category_id = $_POST['category_id'];
	$idb = new idb();
	
	if (empty($startdate)) {
		$userinfo_list = $idb->select(query::getUserinfoList, 's', array($category_id));
	} else {
		$userinfo_list = $idb->select(query::getUserinfoListByDate, 'sss', array($category_id, $startdate, $enddate));
	}
	header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=result.txt");

	// $userinfo_list = $_SESSION['userinfo_list'];
	// $_SESSION['userinfo_list'] = '';

	if ($_POST['type'] == 'id') {
		$save_field = 'id';
	} else {
		$save_field = 'email';
	}

	foreach ($userinfo_list as $userinfo) {
		echo "$userinfo[$save_field]\r\n";
	}
?>
