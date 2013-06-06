<?php
	echo "<p>네이버 이미지 검색 결과</p>";
	$naver_image_output = curl("http://image.search.naver.com/search.naver?sm=tab_hty.top&where=image&ie=utf8&x=-595&y=-51&query=$q");

	// 결과 영역으로 검색 부분을 줄인다.
	if (strpos($naver_image_output, '<ul class="image2"')) {
		$startpos = strpos($naver_image_output, '<ul class="image2"') + strlen('<ul class="image2"');
		$endpos = strpos($naver_image_output, "</ul>", $startpos);
		// echo $startpos . ' ' . $endpos;
		$naver_image_output = substr($naver_image_output, $startpos, $endpos - $startpos);
		// file_put_contents('naver_image', $naver_image_output);
		// // $naver_image_output = file_get_contents('temp');

		$naver_image_output = str_replace("http://sstatic.naver.net", "", $naver_image_output);
		$pattern = '/<img class=\"_thumbimg\" src=\"(http:\/\/[^\"]*)\"/';
		preg_match_all($pattern, $naver_image_output, $naver_image_match, PREG_PATTERN_ORDER);
		// print_r($naver_image_match[1]);

		$naver_image_display_count = 1;
		foreach ($naver_image_match[1] as $naver_image) {
			if ($naver_image_display_count > $DisplayType) {
				break;
			}
			echo '<img src="' . $naver_image . '" ><br />';
			$naver_image_display_count = $naver_image_display_count + 1;
		}
	} else {
		echo "일치하는 결과물이 없습니다.";
	}