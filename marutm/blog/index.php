<?php
	include "./inc/init.inc";
	// page 관련
	$page_rows = 100;
	$page = @$_GET['page'];
	if ($page < 1) {
		$page = 1;
	}

	$const = get_defined_constants();
	$startdate = @$_GET['startdate'];
	$enddate = @$_GET['enddate'];

	$idb = new idb();
	$category_list = $idb->select(query::getBlogCategoryList);
	$count_category_list = ($category_list);

	if (!empty($category_list)) {
		$category_id = isset($_GET['category_id']) && strlen($_GET['category_id']) > 0 ? $_GET['category_id'] : $category_list[0]['id'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>블로그 관련 크롤링 정보</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo _CSS_PATH;?>/jquery-ui-1.9.2.custom.min.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="left">
				그룹
<?php
	if (!empty($category_list)) {
		echo "<ul>";
		foreach ($category_list as $category) {
			if ($category['id'] == $category_id) {
				$display_category = $category;
					if (empty($startdate)) {
						$count_userinfo_list = $idb->selectCount(query::getBlogUserinfoListCount, 's', array($category_id));
						$last = ceil($count_userinfo_list/$page_rows);
						$userinfo_list = $idb->select(query::getBlogUserinfoList, 'sii', array($category_id, ($page - 1) * $page_rows, $page_rows));
					} else {
						$count_userinfo_list = $idb->selectCount(query::getBlogUserinfoListByDateCount, 'sss', array($category_id, $startdate, $enddate));
						$last = ceil($count_userinfo_list/$page_rows);
						$userinfo_list = $idb->select(query::getBlogUserinfoListByDate, 'sssii', array($category_id, $startdate, $enddate, ($page - 1) * $page_rows, $page_rows));
					}
			}
			echo '<a href="'._APP_ROOT_PATH.'/index.php?category_id='.$category['id'].'"><li>'.$category['title'].'</li></a>';
		}
		echo "</ul>";
	}
?>
				<form action="category_addForm.php">
					<button type="submit">그룹 만들기</button>
					<button type="button" onclick="goEditCategory();">그룹 수정하기</button>
				</form>

			</div>
			<div class="main">
				<em><?php echo $display_category['title'];?> 그룹 관련 설정 정보</em>
				<br />
				<br />
				<br />
				<p>
					검색어: 
					<?php echo $display_category['keyword']?>
				</p>
				<br /><br />
				<div class="setting">
					<form method="post" action="category_edit.php">
						<input type="hidden" name="category_id" value="<?php echo $category_id?>">
						<input type="hidden" name="title" value="<?php echo $display_category['title']?>">
						<input type="hidden" name="keyword" value="<?php echo $display_category['keyword']?>">
						<input type="hidden" name="act_interval" value="<?php echo $display_category['act_interval']?>">
						<input type="hidden" name="endpage" value="<?php echo $display_category['endpage']?>">
						<label for="search_option">검색옵션:</label>
						<input type="radio" name="search_option" value="recent" <?php if ($display_category['search_option'] == 'recent') echo 'checked="checked"';?>>최신
						<input type="radio" name="search_option" value="correct" <?php if ($display_category['search_option'] == 'correct') echo 'checked="checked"';?>>정확도
						<br />
						<label for="target">사이트:</label>
						<input type="radio" name="target" value="naver" <?php if ($display_category['target'] == 'naver') echo 'checked="checked"';?>>naver
						<input type="radio" name="target" value="daum" <?php if ($display_category['target'] == 'daum') echo 'checked="checked"';?>>daum
						<input type="radio" name="target" value="all" <?php if ($display_category['target'] == 'all') echo 'checked="checked"';?>>all
						<br />
						<button type="submit">그룹 설정 저장</button>
					</form>
				</div>

				<div class="show-user">

					<form action="<?php echo _APP_ROOT_PATH?>/index.php">
						<input type="hidden" name="category_id" value="<?php echo $category_id?>">
						<input type="hidden" name="startdate" id="startdate">
						<input type="hidden" name="enddate" id="enddate">
						<a href="<?php echo _APP_ROOT_PATH?>/index.php?category_id=<?php echo $category_id?>">전체보기</a> 
						/ 날짜별 보기: <input type="text" id="cal_startdate" >~<input type="text" id="cal_enddate" >
						<button type="submit">검색</button>
					</form>
					<div class="pagination">
<?php 
	if ($page > 1) {
		echo "<a href='".$_SERVER['PHP_SELF']."?category_id=".$category_id."&startdate=".$startdate."&enddate=".$enddate."&page=".($page-1)."'>prev</a>";
	}
		echo "<em>".$page." page </em>";
	if ($page < @$last) {
		echo "<a href='".$_SERVER['PHP_SELF']."?category_id=".$category_id."&startdate=".$startdate."&enddate=".$enddate."&page=".($page+1)."'>next</a>";
	}
?>
					</div>
					<button id="save_id" type="button">아이디 저장</button>
					<button id="save_email" type="button">이메일 저장</button>
					
					<br />
					<table>
						<thead>
							<tr>
								<th>추출 시간</th>
								<th>아이디</th>
								<th>이메일</th>
							</tr>
						</thead>
						<tbody>
<?php
		if (!empty($userinfo_list)) {
			foreach ($userinfo_list as $userinfo) {
echo <<<EOT
							<tr>
								<td>{$userinfo['cre_time']}</td>
								<td>{$userinfo['id']}</td>
								<td>{$userinfo['email']}</td>
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

	<iframe id="frame1" name="frame1" style="display:none;"></iframe>
	<script src="<?php echo _JS_PATH?>/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script src="<?php echo _JS_PATH?>/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function goEditCategory() {
		document.location.href = './category_editForm.php?category_id=<?php echo $category_id?>';
	}
	$(function() {
			$("#cal_startdate").datepicker({
				dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
        		dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
				dateFormat: "yy년 mm월 dd일(D)",
				altField: "#startdate",
        		altFormat: "yymmdd"
			});	
			$("#cal_enddate").datepicker({
				dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
        		dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
				dateFormat: "yy년 mm월 dd일(D)",
				altField: "#enddate",
        		altFormat: "yymmdd"
			});	

			$("#save_id").on('click', function() {
				var form = document.createElement("form");
		        form.setAttribute("method", "post");
		        form.setAttribute("action", "download.php");
		        form.setAttribute("target", "frame1");
		        var categoryIdField = document.createElement("input");
		        categoryIdField.setAttribute("name", "category_id");
		        categoryIdField.setAttribute("value","<?php echo $category_id?>");
		        categoryIdField.setAttribute("type", "hidden");
		        var startdateField = document.createElement("input");
		        startdateField.setAttribute("name", "startdate");
		        startdateField.setAttribute("value","<?php echo $startdate?>");
		        startdateField.setAttribute("type", "hidden");
		        var enddateField = document.createElement("input");
		        enddateField.setAttribute("name", "enddate");
		        enddateField.setAttribute("value","<?php echo $enddate?>");
		        enddateField.setAttribute("type", "hidden");
		        var typeField = document.createElement("input");
		        typeField.setAttribute("name", "type");
		        typeField.setAttribute("value","id" );
		        typeField.setAttribute("type", "hidden");
		        form.appendChild(typeField);
		        form.appendChild(categoryIdField);
		        form.appendChild(startdateField);
		        form.appendChild(enddateField);
		        document.body.appendChild(form);
        		form.submit();
			});

			$("#save_email").on('click', function() {
				var form = document.createElement("form");
		        form.setAttribute("method", "post");
		        form.setAttribute("action", "download.php");
		        form.setAttribute("target", "frame1");
		        var categoryIdField = document.createElement("input");
		        categoryIdField.setAttribute("name", "category_id");
		        categoryIdField.setAttribute("value","<?php echo $category_id?>");
		        categoryIdField.setAttribute("type", "hidden");
		        var startdateField = document.createElement("input");
		        startdateField.setAttribute("name", "startdate");
		        startdateField.setAttribute("value","<?php echo $startdate?>");
		        startdateField.setAttribute("type", "hidden");
		        var enddateField = document.createElement("input");
		        enddateField.setAttribute("name", "enddate");
		        enddateField.setAttribute("value","<?php echo $enddate?>");
		        enddateField.setAttribute("type", "hidden");
		        var typeField = document.createElement("input");
		        typeField.setAttribute("name", "type");
		        typeField.setAttribute("value","email" );
		        typeField.setAttribute("type", "hidden");
		        form.appendChild(typeField);
		        form.appendChild(categoryIdField);
		        form.appendChild(startdateField);
		        form.appendChild(enddateField);
		        document.body.appendChild(form);
        		form.submit();
			});
	});
</script>
	</body>
</html>
