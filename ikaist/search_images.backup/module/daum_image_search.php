<?php
	echo "<p>다음 이미지 검색 결과</p>";
	$daum_image_output = curl("http://search.daum.net/search?w=img&ResultType=tab&AdultType=0&plugin_module=Image_QP&SearchType=tab&SortType=tab&sidx=0&viewType=L&q=$q");

	// 결과 영역으로 검색 부분을 줄인다.
	if (strpos($daum_image_output, 'mg_cont clear')) {
		$startpos = strpos($daum_image_output, 'mg_cont clear') + strlen('mg_cont clear');
		$endpos = strpos($daum_image_output, "imgWrapExtend", $startpos);

		$daum_image_output = substr($daum_image_output, $startpos, $endpos - $startpos);

		$pattern = '/src=\"(http:\/\/[^\"]*)\"/';
		preg_match_all($pattern, $daum_image_output, $daum_image_match, PREG_PATTERN_ORDER);

		$daum_image_display_count = 1;
		foreach ($daum_image_match[1] as $daum_image) {
			if ($daum_image_display_count > $DisplayType) {
				break;
			}
			echo '<img src="' . $daum_image . '" ><br />';
			$daum_image_display_count = $daum_image_display_count + 1;
		}
	} else {
		echo "일치하는 결과물이 없습니다.";
	}