<?php
	$result_html .=  "<p>네이버 백과사전 검색 결과</p>";
	$naver_dic_output = curl("http://terms.naver.com/search.nhn?query=$q");
	
	// 결과 영역으로 검색 부분을 줄인다.
	if (strpos($naver_dic_output, "result_lst")) {
		$startpos = strpos($naver_dic_output, "result_lst\">") + strlen("result_lst\">");
		$endpos = strpos($naver_dic_output, "</ul>", $startpos);

		$naver_dic_output = substr($naver_dic_output, $startpos, $endpos - $startpos);



		$naver_dic_output = str_replace("http://sstatic.naver.net", "", $naver_dic_output);

		$naver_dic_image_array = explode("<li>", $naver_dic_output);
		unset($naver_dic_image_array[0]);
		

		foreach($naver_dic_image_array as $key=>$naver_dic_image) {
			$naver_dic_image = substr($naver_dic_image, 0, strpos($naver_dic_image, "<dd"));
			if (!strpos($naver_dic_image, $q)) {
				unset($naver_dic_image_array[$key]);
			}
		}

		$naver_dic_output = implode("<li>", $naver_dic_image_array);

		$pattern = '/<img src=\"(http:\/\/[^\"]*)\"/';

		preg_match_all($pattern, $naver_dic_output, $naver_dic_match, PREG_PATTERN_ORDER);

		$pattern = '/entry.nhn\?docId=[0-9]*\">(.*)<\/a>/';
		preg_match_all($pattern, $naver_dic_output, $naver_dic_title_match, PREG_PATTERN_ORDER);

		$naver_dic_img_display_count = 1;
		foreach ($naver_dic_match[1] as $key=>$naver_dic_img) {
			if ($naver_dic_img_display_count > $DisplayType) {
				break;
			}

				$image_array[] = '<img src="' . replace_naver_dic_img_url($naver_dic_img) . '" style="max-width:800px;"><br />';
				$result_html .= '<img src="' . replace_naver_dic_img_url($naver_dic_img) . '" style="max-width:800px;"><br />';
				$naver_dic_img_display_count = $naver_dic_img_display_count + 1;
		}

	} else {
		$result_html .=  "일치하는 결과물이 없습니다.";
	}
	if ($naver_dic_img_display_count == 1) {
		$result_html .=  "일치하는 결과물이 없습니다.";	
	}
