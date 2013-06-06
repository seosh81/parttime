<?php
	$result_html .= "<p>다음 이미지 검색 결과</p>";
	$big_img_url = "http://imgv.search.daum.net/viewer/search?w=xml&m=image&q=".iconv('utf-8', 'euc-kr', $q);
	$big_img_output = curl($big_img_url);

	$big_img_output = new SimpleXMLElement($big_img_output);
	$image_count = $big_img_output->resultCount;

	if ($image_count > 0) {
		$daum_image_display_count = 1;
		foreach (range(0, $image_count -1) as $number) {
			if ($daum_image_display_count > $DisplayType || $daum_image_display_count > $image_count) {
				break;
			}
			$output = curl_image($big_img_output->result[$number]->org_img);

			// echo strlen($output);
			if (strlen($output) == 0) {
				$image_array[] = '<p>Orijinal image not found.</p>'; 
				$result_html .= '<p>Orijinal image not found.</p>';
			} else {
				$image_array[] = '<img src="./get_image_from_remote.php?img_url=' . $big_img_output->result[$number]->org_img . '" alt="Orijinal image not found."><br />'; 
				$result_html .= '<img src="./get_image_from_remote.php?img_url=' . $big_img_output->result[$number]->org_img . '" alt="Orijinal image not found."><br />';	
			}
			
			$daum_image_display_count = $daum_image_display_count + 1;
		}
	} else {
		$result_html .= "일치하는 결과물이 없습니다.";
	}