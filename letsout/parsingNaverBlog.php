<?php
	error_reporting(E_ERROR | E_PARSE);
	// $blog_url = 'http://blog.naver.com/iaan17?Redirect=Log&logNo=140170481366&from=section';
	// if (strpos($blog_url, "Redirect") > -1) {
	// 	echo "Redirect found!";
	// 	preg_match("blog.naver.com", $blog_url, $result);
	// 	var_dump($result);
	// }
	function DOMinnerHTML($element) 
	{ 
	    $innerHTML = ""; 
	    $children = $element->childNodes; 
	    foreach ($children as $child) 
	    { 
	        $tmp_dom = new DOMDocument(); 
	        $tmp_dom->appendChild($tmp_dom->importNode($child, true)); 
	        $innerHTML.=trim($tmp_dom->saveHTML()); 
	    }
	    return $innerHTML;
	}

	$img_dir = '/Users/seosh81/project/parttime/letsout/temp_images/';

	$naver_id_pattern = "/http\:\/\/blog.naver.com\/(.+)\?/";
	$post_id_pattern = "/logNo\=(\d+)/";
	$str = "http://blog.naver.com/iaan17?Redirect=Log&logNo=140170481366&from=section";
	$str = "http://blog.naver.com/kohaku3533?Redirect=Log&logNo=140190608270&from=section";

	preg_match($naver_id_pattern, $str, $naver_id, PREG_OFFSET_CAPTURE);
	preg_match($post_id_pattern, $str, $post_id, PREG_OFFSET_CAPTURE);
	$naver_id = $naver_id[1][0];
	$post_id = $post_id[1][0];

	// echo $naver_id . $post_id;

	$blog_view_url = 'http://blog.naver.com/PostView.nhn?blogId=' . $naver_id . '&logNo=' . $post_id . '&beginTime=0&jumpingVid=&from=section&redirect=Log&widgetTypeCall=true&topReferer=http%3A%2F%2Fsection.blog.naver.com%2F';
    file_put_contents('tempfile', file_get_contents($blog_view_url));
	$post_origin = iconv('euc-kr', 'utf-8', file_get_contents($blog_view_url));

	$domd = new DOMDocument();
	$domd->loadHTML($post_origin);
	$div = $domd->getElementById("post-view" . $post_id);
	$div_source = html_entity_decode(DOMinnerHTML($div), ENT_NOQUOTES, 'UTF-8');

	// img tag 에서 image정보 뽑기
	$imgs = $div->getElementsByTagName("img");

	foreach ($imgs as $key => $img) {
		$img_src = $img->getAttribute('src');
		// echo $img_src;
		$new_img_src = $img_dir.$post_id.'_'.$key;
		$div_source = str_replace($img_src, $new_img_src, $div_source);
	//	file_put_contents($img_dir.$post_id.'_'.$key, file_get_contents($img_src));
	}

	// file_put_contents('innerhtml', $div_source);

	$start_post_pos = strpos($post_origin, '<div id="post-view');
	$post_part = substr($post_origin, $start_post_pos);
?>
