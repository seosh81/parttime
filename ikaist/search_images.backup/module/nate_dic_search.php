<?php
	echo "<p>네이트 백과사전 검색 결과</p>";
	$url = "http://alldic.nate.com/search/encdic.html?thr=vndb&nq=1&cm=c&q=".urlencode(iconv('utf-8', 'euc-kr', $q));
	$nate_dic_output = iconv('euc-kr', 'utf-8', curl($url));
	// echo $nate_dic_output;
	// file_put_contents('nate', $nate_dic_output);



	// 결과 영역으로 검색 부분을 줄인다.
	$startpos = strpos($nate_dic_output, "class='search-list'") + strlen("class='search-list'");
	$endpos = strpos($nate_dic_output, "</ul>", $startpos);
	// echo 'position: ' . $startpos . ' ' . $endpos;
	$nate_dic_output = substr($nate_dic_output, $startpos, $endpos - $startpos);
	// file_put_contents('nate', $nate_dic_output);

	$pattern = '/\"(http:\/\/100.nate.com\/dicsearch\/pimagelist.html?[^\"]*)\"/';
	preg_match($pattern, $nate_dic_output, $nate_dic_match);

	if (!$nate_dic_match) {
		echo "일치하는 결과물이 없습니다.";
	} else {
		$nate_dic_output = iconv('euc-kr', 'utf-8', curl($nate_dic_match[1]));
	}

	// 결과 영역으로 검색 부분을 줄인다.
	$startpos = strpos($nate_dic_output, "<tbody>") + strlen("<tbody>");
	$endpos = strpos($nate_dic_output, "</table>", $startpos);
	$nate_dic_output = substr($nate_dic_output, $startpos, $endpos - $startpos);

	$pattern = '/<img src=\'(http:\/\/[^\"]*)\'/';
	preg_match_all($pattern, $nate_dic_output, $nate_dic_match, PREG_PATTERN_ORDER);

	// print_r($nate_dic_match);

	$nate_dic_img_display_count = 1;
	foreach ($nate_dic_match[1] as $nate_dic_img) {
		if ($nate_dic_img_display_count > $DisplayType) {
			break;
		}
		echo '<img src="' . $nate_dic_img . '" ><br />';
		$nate_dic_img_display_count = $nate_dic_img_display_count + 1;
	}