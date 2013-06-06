<?php

	$url = "http://auto.naver.com/comments/list_comment.nhn?ticket=auto1&object_id=28628&page_no=1&page_size=10&_ts=1365723758036&null";
	$referer = "http://auto.naver.com/ad/bmw/car/talk.nhn?yearsId=28628";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	$json = curl_exec($ch);
	$obj = json_decode($json);

	foreach ($obj->comment_list as $comment) {
		if (strpos($comment->contents, '견적') > -1) {
			$pattern = "/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,3}/";
			preg_match($pattern, $comment->contents, $match);
			print_r($match);
			echo count($match[0]);
			echo $comment->contents . '\r\n';
		}
	}