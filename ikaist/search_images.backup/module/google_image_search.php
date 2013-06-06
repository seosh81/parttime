<?php
	echo "<p>구글 이미지 검색 결과</p>";
	$google_image_output = curl("https://www.google.co.kr/search?hl=en&newwindow=1&bav=on.2,or.r_cp.r_qf.&bvm=bv.43828540,d.aGc&biw=1920&bih=927&wrapid=tlif136349663698410&um=1&ie=UTF-8&tbm=isch&source=og&sa=N&tab=wi&ei=vk5FUaWCDOmciAe53YHAAg&q=$q");
	// file_put_contents('google_image', $google_image_output);

	// 결과 영역으로 검색 부분을 줄인다.
	if (strpos($google_image_output, 'e.src')) {
		$startpos = strpos($google_image_output, 'e.src') + strlen('e.src');
		$endpos = strpos($google_image_output, "function()", $startpos);
		// echo $startpos . ' ' . $endpos;
		$google_image_output = substr($google_image_output, $startpos, $endpos - $startpos);
		// file_put_contents('google_image', $google_image_output);
		// // // $google_image_output = file_get_contents('temp');

		$pattern = "/\'(data:image\/jpeg;base64,[^\']*)\'/";
		preg_match_all($pattern, $google_image_output, $google_image_match, PREG_PATTERN_ORDER);
		// print_r($google_image_match[1]);

		$google_image_display_count = 1;
		foreach ($google_image_match[1] as $google_image) {
			if ($google_image_display_count > $DisplayType) {
				break;
			}
			echo '<img src="' . str_replace("\\x3d", "", $google_image) . '" ><br />';
			$google_image_display_count = $google_image_display_count + 1;
		}
	} else {
		echo "일치하는 결과물이 없습니다.";
	}