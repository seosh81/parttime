<?php
	function curl($url) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
		$output = curl_exec($cx);
		$info = curl_getinfo($cx);
		if ($info['http_code'] == '404' || $info['http_code'] == '0') {
			$output = "";
		}
		curl_close($cx);

		usleep(100000);
		return $output;
	}

	$img_url = substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], "img_url=") + strlen("img_url="));
	$output = curl($img_url);
	echo $output;

