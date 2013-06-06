<?php
	echo "<p>네이버 백과사전 검색 결과</p>";
	$naver_dic_output = curl("http://terms.naver.com/search.nhn?query=$q");
	file_put_contents('naver_dic', $naver_dic_output);
	// 결과 영역으로 검색 부분을 줄인다.
	if (strpos($naver_dic_output, "result_lst")) {
		$startpos = strpos($naver_dic_output, "result_lst") + strlen("result_lst");
		$endpos = strpos($naver_dic_output, "</ul>", $startpos);
		echo $startpos . ' ' . $endpos;
		$naver_dic_output = substr($naver_dic_output, $startpos, $endpos - $startpos);
		// file_put_contents('naver_dic', $naver_dic_output);

		// $naver_dic_output = file_get_contents('temp');
		$naver_dic_output = str_replace("http://sstatic.naver.net", "", $naver_dic_output);
		// file_put_contents('naver_dic', $naver_dic_output);
		$pattern = '/<img src=\"(http:\/\/[^\"]*)\"/';
		preg_match_all($pattern, $naver_dic_output, $naver_dic_match, PREG_PATTERN_ORDER);


		print_r($naver_dic_match);
	} else {
		echo "일치하는 결과물이 없습니다.";
	}

	// $naver_dic_img_display_count = 1;
	// foreach ($naver_dic_match[1] as $naver_dic_img) {
	// 	if ($naver_dic_img_display_count > $DisplayType) {
	// 		break;
	// 	}
	// 	echo '<img src="' . replace_naver_dic_img_url($naver_dic_img) . '" style="max-width:800px;"><br />';
	// 	$naver_dic_img_display_count = $naver_dic_img_display_count + 1;
	// }