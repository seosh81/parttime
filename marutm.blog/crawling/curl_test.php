<?php
	// function curl($url,$params = array(),$is_coockie_set = false) {
	// if(!$is_coockie_set){
	// 	/* STEP 1. let’s create a cookie file */
	// 	$ckfile = tempnam ("/tmp", "CURLCOOKIE");
	// 	// $ckfile = "/tmp/cookiefordaum.jar";
	// 	 // STEP 2. visit the homepage to set the cookie properly 
	// 	$ch = curl_init ($url);
	// 	curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
	// 	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	// 	$output = curl_exec ($ch);	
	// }

	// $ch = curl_init ($url);
	// curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	// $output = curl_exec ($ch);
	// curl_close($ch);
	// return $output;
	// }



	// $result = curl('search.daum.net');
	// $url = 'http://search.daum.net/search?w=blog&m=board&lpp=10&q=car';
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, 'http://search.daum.net/search?w=blog&m=board&q=seoul');
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	// $output = curl_exec ($ch);
	// echo "result: " . $output;

	// $data = array('foo'=>'bar',
 //              'baz'=>'boom',
 //              'cow'=>'milk',
 //              'php'=>'hypertext processor');

	// echo http_build_query($data, '');

	$cx = curl_init();
	curl_setopt($cx, CURLOPT_USERAGENT, "GNU Wget 1.14 built on darwin12.2.0.");
	curl_setopt($cx, CURLOPT_URL, "http://search.daum.net/search?w=blog&m=board&lpp=10&q=%EB%A6%AC%EA%B7%B8%EC%98%A4%EB%B8%8C%EB%A0%88%EC%A0%84%EB%93%9C&page=1");
	curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($cx);
	// echo $result;

	$pattern = '/<a href="http:\/\/blog.daum.net\/([0-9a-zA-Z]+)/';
	preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
	print_r($match);

	$pattern = '/<a href="http:\/\/blog.naver.com\/PostView.nhn\?blogId=([0-9a-zA-Z]+)/';
	preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);

	print_r($match);
?>