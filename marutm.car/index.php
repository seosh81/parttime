<?php
	include "./inc/init.inc";

	$page_rows = 100;
	$page = @$_GET['page'];
	if ($page < 1) {
		$page = 1;
	}

	// $const = get_defined_constants();
	$seq = @$_GET['seq'];
	
	$startdate = @$_GET['startdate'];
	$enddate = @$_GET['enddate'];

	$idb = new idb();
	
	$category_list = $idb->select(query::getCarCategoryList);

	$email_list = $idb->select(query::getEmailList);
	
	// $count_category_list = ($category_list);

	// if (!empty($category_list)) {
	// 	$category_id = isset($_GET['category_id']) && strlen($_GET['category_id']) > 0 ? $_GET['category_id'] : 'ALL';
	// }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Car 분석 사이트</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/jquery-ui-1.9.2.custom.min.css" />
		<style>
a:link {
    text-decoration: none;
}
 
a:active {
    text-decoration: none;
}
 
a:visited {
    color:black;
    text-decoration: none;
}
a:hover {
    
    text-decoration: none;
}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="left">
				<strong>사이트</strong>

<?php
	if (!empty($category_list)) {
		if (!isset($seq)) {

		}
		
		foreach ($category_list as $category) {
			echo '<a href="category_editForm.php?seq=' . $category['seq'] . '"><li>'.$category['name'].'</li></a>';
		}
		echo "</ul>";
		
	}
	echo "<a href='./category_addForm.php'><button type='button'>add site</button></a>";
	
	$count_carcomment_list = $idb->selectCount(query::getTotalCarCommentCount);
	$last = ceil($count_carcomment_list/$page_rows);
	$carcomment_list = $idb->select(query::getCarCommentList, 'ii', array(($page - 1) * $page_rows, $page_rows));
?>
			<hr />
				<strong>수신 이메일</strong>
<?
	if ($email_list) {
?>
				<ul>
<?
		foreach($email_list as $email) {
?>
					<li><a href="./email_editForm.php?seq=<?=$email['seq']?>"><?=$email['email']?></a></li>
<?
		}
?>
				</ul>
<?
	}
?>
				<a href='./email_addForm.php'><button type='button'>add email</button></a>
			</div>
			<div class="main">
				<em>정보</em>
				<br />
				<div class="show-user">
					<div class="pagination">
<?php 
	if ($page > 1) {
		echo "<a href='index.php?page=".($page-1)."'>prev</a>";
	}
		echo "<em>".$page." page </em>";
	if ($page < @$last) {
		echo "<a href='index.php?page=".($page+1)."'>next</a>";
	}
?>
					</div>
					<br />
					<table>
						<thead>
							<tr>
								<th>내용</th>
								<th>업데이트날짜</th>
							</tr>
						</thead>
						<tbody>
<?php
		if (!empty($carcomment_list)) {
			foreach ($carcomment_list as $carcommentinfo) {
echo <<<EOT
							<tr>
								<td style="width:100px;">{$carcommentinfo['model']}</td>
								<td style="width:400px;">{$carcommentinfo['comment']}</td>
								<td style="width:100px;">{$carcommentinfo['email']}</td>
								<td style="width:150px;">{$carcommentinfo['cre_time']}</td>
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
