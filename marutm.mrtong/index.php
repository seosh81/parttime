<?php
	include "./inc/init.inc";

	$page_rows = 100;
	$page = @$_GET['page'];
	if ($page < 1) {
		$page = 1;
	}

	$const = get_defined_constants();
	$startdate = @$_GET['startdate'];
	$enddate = @$_GET['enddate'];

	$idb = new idb();
	$category_list = $idb->select(query::getMrtongCategoryList);
	$count_category_list = ($category_list);

	if (!empty($category_list)) {
		$category_id = isset($_GET['category_id']) && strlen($_GET['category_id']) > 0 ? $_GET['category_id'] : 'ALL';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Mrtong 분석 사이트</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/jquery-ui-1.9.2.custom.min.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="left">
				<strong>카테고리</strong>

<?php
	if (!empty($category_list)) {
		echo "<ul><a href='index.php'><li>모두보기</li></a>";
		if ($category_id == 'ALL') {
			$siteinfo_list = $idb->select(query::getSiteinfoList);	
			$category_name = '전체보기';
		} else {
			$siteinfo_list = $idb->select(query::getSiteinfoListByCategoryId, 's', array($category_id));	

		}
		
		foreach ($category_list as $category) {
			if ($category['id'] == $category_id) {
				$display_category = $category;
				$category_name = $display_category['title'];
					// if (empty($startdate)) {
					// 	$count_userinfo_list = $idb->selectCount(query::getBlogUserinfoListCount, 's', array($category_id));
					// 	$last = ceil($count_userinfo_list/$page_rows);
					// 	$userinfo_list = $idb->select(query::getBlogUserinfoList, 'sii', array($category_id, ($page - 1) * $page_rows, $page_rows));
					// } else {
					// 	$count_userinfo_list = $idb->selectCount(query::getBlogUserinfoListByDateCount, 'sss', array($category_id, $startdate, $enddate));
					// 	$last = ceil($count_userinfo_list/$page_rows);
					// 	$userinfo_list = $idb->select(query::getBlogUserinfoListByDate, 'sssii', array($category_id, $startdate, $enddate, ($page - 1) * $page_rows, $page_rows));
					// }
			}
			echo '<a href="'._APP_ROOT_PATH.'/index.php?category_id='.$category['id'].'"><li>'.$category['title'].'</li></a>';
		}
		echo "</ul>";
	}
?>

			</div>
			<div class="main">
				<em><?php echo $category_name;?> 정보</em>
				<br />
				<div class="show-user">
					<br />
					<table>
						<thead>
							<tr>
								<th>카테고리</th>
								<th>업체명</th>
								<th>도메인</th>
								<th>네이버</th>
								<th>업데이트날짜</th>
							</tr>
						</thead>
						<tbody>
<?php
		if (!empty($siteinfo_list)) {
			foreach ($siteinfo_list as $userinfo) {
echo <<<EOT
							<tr>
								<td style="width:180px;">{$userinfo['category_name']}</td>
								<td style="width:150px;">{$userinfo['name']}</td>
								<td style="width:150px;">{$userinfo['url']}</td>
								<td style="width:230px;">{$userinfo['naver_registry']}</td>
								<td style="width:300px;">{$userinfo['cre_time']}</td>
							</tr>
EOT;
			}
		}
?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</body>
</html>
