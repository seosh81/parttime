<?php
	function curl($url) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
		$output = curl_exec($cx);
		curl_close($cx);
		usleep(100000);
		return $output;
	}

	// dbscthumb.phinf.naver.net 에서 서비스 하는 이미지는 proxy를 거쳐야 제대로 보인다.
	function replace_naver_dic_img_url($url) {
		if (strpos($url, "dbscthumb.phinf.naver.net") > -1) {
			$url = str_replace("type=r80", "type=ori_2", $url);
			return "./getImgFromDbscthumb.php?img_url=" . $url;
		} else if (strpos($url, "dicimg.naver.com") > -1) {
			$url = "http://dicimg.naver.com/100/800/" . substr($url, strpos($url, "related/") + strlen("related/"));
		}
		return $url;
	}

	$q = @$_GET['q'];
	$SearchType = @$_GET['SearchType'];
	// $SearchType = 5;

	// DisplayType 옵션 설정
	$DisplayType = intval(@$_GET['DisplayType']);
	if ($DisplayType == '') {
		$DisplayType = 1;
	}
	if ($DisplayType > 20) {
		$DisplayType = 20;
	}

	// RandomPickup 설정
	$RandomPickup = @$_GET['RandomPickup'];
	if ($RandomPickup == '') {
		$RandomPickup = '0';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>이미지 검색 툴</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
		<body>
	<form action="search_images.php" method="get">
		<label for="q">이미지검색어</label><input type="text" length="30" name="q" id="q" value="<?php echo $q?>" />
		<label for="SearchType">검색방법</label>
		<select id="SearchType" name="SearchType">
			<option value="1" <?php if ($SearchType == "1") echo 'selected="selected"';?>>1. 네이버 지식백과</option>
			<option value="2" <?php if ($SearchType == "2") echo 'selected="selected"';?>>2. 네이트 백과사전</option>
			<option value="3" <?php if ($SearchType == "3") echo 'selected="selected"';?>>3. 네이버</option>
			<option value="4" <?php if ($SearchType == "4") echo 'selected="selected"';?>>4. 구글</option>
			<option value="5" <?php if ($SearchType == "5") echo 'selected="selected"';?>>5. 다음</option>
			<option value="6" <?php if ($SearchType == "6") echo 'selected="selected"';?>>6. 모든 검색엔진(1+2+3+4+5)</option>
			<option value="7" <?php if ($SearchType == "7") echo 'selected="selected"';?>>7. 모든 검색엔진 중 첫번째 결과물</option>
		</select>
		<label for="DisplayType">이미지 표현개수(최대 20개)</label>
		<select id="DisplayType" name="DisplayType">
			<option value="1" <?php if ($DisplayType == "1") echo 'selected="selected"';?>>1</option>
			<option value="2" <?php if ($DisplayType == "2") echo 'selected="selected"';?>>2</option>
			<option value="3" <?php if ($DisplayType == "3") echo 'selected="selected"';?>>3</option>
			<option value="4" <?php if ($DisplayType == "4") echo 'selected="selected"';?>>4</option>
			<option value="5" <?php if ($DisplayType == "5") echo 'selected="selected"';?>>5</option>
			<option value="6" <?php if ($DisplayType == "6") echo 'selected="selected"';?>>6</option>
			<option value="7" <?php if ($DisplayType == "7") echo 'selected="selected"';?>>7</option>
			<option value="8" <?php if ($DisplayType == "8") echo 'selected="selected"';?>>8</option>
			<option value="9" <?php if ($DisplayType == "9") echo 'selected="selected"';?>>9</option>
			<option value="10" <?php if ($DisplayType == "10") echo 'selected="selected"';?>>10</option>
			<option value="11" <?php if ($DisplayType == "11") echo 'selected="selected"';?>>11</option>
			<option value="12" <?php if ($DisplayType == "12") echo 'selected="selected"';?>>12</option>
			<option value="13" <?php if ($DisplayType == "13") echo 'selected="selected"';?>>13</option>
			<option value="14" <?php if ($DisplayType == "14") echo 'selected="selected"';?>>14</option>
			<option value="15" <?php if ($DisplayType == "15") echo 'selected="selected"';?>>15</option>
			<option value="16" <?php if ($DisplayType == "16") echo 'selected="selected"';?>>16</option>
			<option value="17" <?php if ($DisplayType == "17") echo 'selected="selected"';?>>17</option>
			<option value="18" <?php if ($DisplayType == "18") echo 'selected="selected"';?>>18</option>
			<option value="19" <?php if ($DisplayType == "19") echo 'selected="selected"';?>>19</option>
			<option value="20" <?php if ($DisplayType == "20") echo 'selected="selected"';?>>20</option>
		</select>
		<label for="RandomPickup">이미지 특정픽업옵션</label>
		<select id="RandomPickup" name="RandomPickup">
			<option value="0" <?php if ($RandomPickup == "0") echo 'selected="selected"';?>>사용안함</option>
			<option value="1" <?php if ($RandomPickup == "1") echo 'selected="selected"';?>>랜덤</option>
			<option value="2" <?php if ($RandomPickup == "2") echo 'selected="selected"';?>>2</option>
			<option value="3" <?php if ($RandomPickup == "3") echo 'selected="selected"';?>>3</option>
			<option value="4" <?php if ($RandomPickup == "4") echo 'selected="selected"';?>>4</option>
			<option value="5" <?php if ($RandomPickup == "5") echo 'selected="selected"';?>>5</option>
			<option value="6" <?php if ($RandomPickup == "6") echo 'selected="selected"';?>>6</option>
			<option value="7" <?php if ($RandomPickup == "7") echo 'selected="selected"';?>>7</option>
			<option value="8" <?php if ($RandomPickup == "8") echo 'selected="selected"';?>>8</option>
			<option value="9" <?php if ($RandomPickup == "9") echo 'selected="selected"';?>>9</option>
			<option value="10" <?php if ($RandomPickup == "10") echo 'selected="selected"';?>>10</option>
			<option value="11" <?php if ($RandomPickup == "11") echo 'selected="selected"';?>>11</option>
			<option value="12" <?php if ($RandomPickup == "12") echo 'selected="selected"';?>>12</option>
			<option value="13" <?php if ($RandomPickup == "13") echo 'selected="selected"';?>>13</option>
			<option value="14" <?php if ($RandomPickup == "14") echo 'selected="selected"';?>>14</option>
			<option value="15" <?php if ($RandomPickup == "15") echo 'selected="selected"';?>>15</option>
			<option value="16" <?php if ($RandomPickup == "16") echo 'selected="selected"';?>>16</option>
			<option value="17" <?php if ($RandomPickup == "17") echo 'selected="selected"';?>>17</option>
			<option value="18" <?php if ($RandomPickup == "18") echo 'selected="selected"';?>>18</option>
			<option value="19" <?php if ($RandomPickup == "19") echo 'selected="selected"';?>>19</option>
			<option value="20" <?php if ($RandomPickup == "20") echo 'selected="selected"';?>>20</option>
		</select>
		<button type="submit">이미지 검색</button>
	</form>

<?php
	

	if (!empty($q)) {
		if ($SearchType == 1) {
			include "./module/naver_dic_search.php";
		} else if ($SearchType == 2) {
			include "./module/nate_dic_search.php";
		} else if ($SearchType == 3) {
			include "./module/naver_image_search.php";
		} else if ($SearchType == 4) {
			include "./module/google_image_search.php";
		} else if ($SearchType == 5) {
			include "./module/daum_image_search.php";
		} else if ($SearchType == 6) {
			include "./module/naver_dic_search.php";
			include "./module/nate_dic_search.php";
			include "./module/naver_image_search.php";
			include "./module/google_image_search.php";
			include "./module/daum_image_search.php";
		} else if ($SearchType == 7) {
			include "./module/naver_dic_search.php";
			if ($naver_dic_img_display_count > 1) {
				exit();
			}
			include "./module/nate_dic_search.php";
			if ($nate_dic_img_display_count > 1) {
				exit();
			}
			include "./module/naver_image_search.php";
			if ($naver_image_display_count > 1) {
				exit();
			}
			include "./module/google_image_search.php";
			if ($google_image_display_count > 1) {
				exit();
			}
			include "./module/daum_image_search.php";
			if ($daum_image_display_count > 1) {
				exit();
			}
		}

	}
?>
</body>
</html>