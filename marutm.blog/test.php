<?php
	// $s = file_get_contents('blog.daum.net.html');
	// $q = '&q='.urlencode('리그오브레전드');
	// // $s = file_get_contents('http://search.daum.net/search?w=blog&m=board&lpp=10&q=%EB%A6%AC%EA%B7%B8%EC%98%A4%EB%B8%8C%EB%A0%88%EC%A0%84%EB%93%9C&page=1');
	// $url = "http://search.daum.net/search?w=blog&m=board&lpp=10&q=%EB%A6%AC%EA%B7%B8%EC%98%A4%EB%B8%8C%EB%A0%88%EC%A0%84%EB%93%9C&page=1";
	// $ch = curl_init($url);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $output = curl_exec($ch);

	// file_put_contents("search.daum.net", $output);
	// $s = '<span id="blogSQC_t7_7" style="display:none;">10401^1441348535^http://blog.daum.net/joohichadongbaek/2792^1^0</span>';
	// $ptn = '/<a href="http:\/\/blog.daum.net\/([0-9a-zA-Z]+)/';
	$ptn = '/<a href="http:\/\/blog.naver.com\/PostView.nhn\?blogId=([0-9a-zA-Z]+)/';

	// preg_match_all($ptn, $s, $match, PREG_PATTERN_ORDER);
	// print_r($match);
	// foreach (array_unique($match[1]) as $daum_id) {
	// 	echo $daum_id.'<br />';
	// }

	$cookie = '/tmp/football.jar';

	$Url = 'http://www.naver.com';

		/* STEP 1. let’s create a cookie file */

		/* STEP 2. visit the homepage to set the cookie properly */
		$ch = curl_init ($Url);
		curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
	    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec ($ch);	


	$ch = curl_init ($Url);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec ($ch);
	curl_close($ch);
	// file_put_contents("temp", $output);



	// exec('wget http://search.daum.net/search?w=blog&m=board&lpp=10&q=%EB%A6%AC%EA%B7%B8%EC%98%A4%EB%B8%8C%EB%A0%88%EC%A0%84%EB%93%9C&page=1', $array);
	// echo implode('<br />', $array);	


?>