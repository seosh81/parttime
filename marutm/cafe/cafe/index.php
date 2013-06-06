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
	$category_list = $idb->select(query::getCategoryList);
	$count_category_list = ($category_list);
	$search_cafe_string ='';

	if (!empty($category_list)) {
		$category_id = isset($_GET['category_id']) && strlen($_GET['category_id']) > 0 ? $_GET['category_id'] : $category_list[0]['id'];
		$cafe_list = $idb->select(query::getCafeList, 's', array($category_id));
		if (!empty($cafe_list)) {
			$search_cafe_string_array = array();
			foreach($cafe_list as $cafe) {
				$search_cafe_string_array[] = $cafe['id'];
			}
			$search_cafe_string = "'". implode("', '", $search_cafe_string_array) . "'";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>카페 관련 크롤링 정보</title>
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
				if (!empty($cafe_list)) {
					if (empty($startdate)) {
						$count_userinfo_list = $idb->selectCount(query::getUserinfoListCount, 's', array($category_id));
						$last = ceil($count_userinfo_list/$page_rows);
						$userinfo_list = $idb->select(query::getUserinfoList, 'sii', array($category_id, ($page - 1) * $page_rows, $page_rows));
					} else {
						$count_userinfo_list = $idb->selectCount(query::getUserinfoListByDateCount, 'sss', array($category_id, $startdate, $enddate));
						$last = ceil($count_userinfo_list/$page_rows);
						$userinfo_list = $idb->select(query::getUserinfoListByDate, 'sssii', array($category_id, $startdate, $enddate, ($page - 1) * $page_rows, $page_rows));
					}
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
				<em>카페 리스트</em>
				<br />
				<br />
<?php
	if (!empty($cafe_list)) {

		echo "<ul>";
		foreach ($cafe_list as $cafe) {
echo <<<EOT
			<a href="{$const['_APP_ROOT_PATH']}/cafe_editForm.php?cafe_seq={$cafe['seq']}"><li>{$cafe['title']}</li></a>
EOT;
		}
		echo "</ul>";
	}
?>
				<br /><br />
				<div class="setting">
					<form method="post" action="category_edit.php">
						<input type="hidden" name="category_id" value="<?php echo $category_id?>">
						<input type="hidden" name="title" value="<?php echo $display_category['title']?>">
						<label>크롤링 간격:</label>
						<input type="radio" name="act_interval" value="1" <?php if ($display_category['act_interval'] == '1') echo 'checked="checked"';?>>매시간
						<input type="radio" name="act_interval" value="2" <?php if ($display_category['act_interval'] == '2') echo 'checked="checked"';?>>2시간
						<input type="radio" name="act_interval" value="6" <?php if ($display_category['act_interval'] == '6') echo 'checked="checked"';?>>6시간
						<input type="radio" name="act_interval" value="12" <?php if ($display_category['act_interval'] == '12') echo 'checked="checked"';?>>12시간
						<br />
						<label for="startpage">페이지 설정:</label>
						<input type="text" id="startpage" name="startpage" value="<?php echo $display_category['startpage']; ?>">~
						<input type="text" id="endpage" name="endpage" value="<?php echo $display_category['endpage']; ?>">
						<br />
						<button type="submit">그룹 설정 저장용</button>
					</form>
					<form action="cafe_addForm.php">
						<button type="submit">카페 추가하기</button>
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
								<th>추출 카페</th>
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
								<td>{$userinfo['cafe_id']}</td>
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
