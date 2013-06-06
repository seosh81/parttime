<?php
	function curl($url) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
    	return curl_exec($cx);
	}

	echo curl("http://web.search.naver.com/search.naver?sm=tab_hty.top&where=site&ie=utf8&x=0&y=0&query=daum2.net");
	echo "end";
?>