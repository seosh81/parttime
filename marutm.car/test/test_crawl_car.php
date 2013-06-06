<?php
	function curl($url, $referer) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
    	curl_setopt($cx, CURLOPT_REFERER, $referer);
		$output = curl_exec($cx);
		curl_close($cx);
		usleep(100000);
		return $output;
	}

	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));

	define('_INC_DIR', __DIR__.'/../inc');
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');
	define('_MAIL_DIR', __DIR__.'/../mail');
	
	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');

	$idb = new idb();
	$total_count = $idb->selectCount(query::getTotalCarCommentCount);
	if ($total_count == 0) {
		$endpage = 100;
	} else {
		$endpage = 1;
	}

	

	$referer = "http://auto.naver.com/ad/bmw/car/talk.nhn?yearsId=1111";

	$yearsId = $argv[1];		
	$endpage = $argv[2];
	
	$model = '[test]';

	foreach (range(1, $endpage) as $page) {
		$url ="http://auto.naver.com/comments/list_comment.nhn?ticket=auto1&object_id=" . $yearsId . "&page_no=" . $page;
		$json = curl($url, $referer);
        echo $json;
		$json = str_replace("\'", "", $json);
		$json = str_replace("\>", "", $json);

		$obj = json_decode($json);
		var_dump($obj);
		file_put_contents($yearsId . '-' . $page, $json);
		foreach ($obj->comment_list as $comment) {
			// if ($comment->comment_no != '376146') {
			// 	continue;
			// }
			// $pattern = "/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,3}/";
			// preg_match($pattern, $comment->contents, $match);
			echo $comment->contents;
			if (strpos($comment->contents, '견적') > -1) {
				$pattern = "/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,3}/";
				preg_match($pattern, $comment->contents, $match);
				
				echo "found word";
				if ($match) {
					$count = $idb->selectCount(query::getCarCommentCount, 's', array($comment->comment_no));
					if ($count > 0) {
						continue;
					}

					$comments = str_replace(array("\r\n", "\r"), "\n", $comment->contents);
					$comments = preg_replace('/^\s+|\n|\r|\s+$/m', ' ', $comments);
				
					$idb->insert(query::addCarComment, 'sssss', array($model, $comment->comment_no, $comments, $match[0], $comment->registered_ymdt));
				}
			} 
		}
	}



	$mail_comment_list = $idb->select(query::getCarCommentMailTarget);

	if ($mail_comment_list) {
		$mail_list = $idb->select(query::getEmailList);
		$mail_body = '<table stlye="width:860px;">';
		$mail_body .= '<thead><tr><th>차량 모델</th><th>코멘트</th><th>이메일</th><th>업데이트날짜</th></tr>
					</thead>';
		foreach ($mail_comment_list as $mail_comment) {
			$mail_body .= '<tr>';
			$mail_body .= '<td style="width:100px;">' . $mail_comment['model'] .'</td>';
			$mail_body .= '<td style="width:400px;">' . $mail_comment['comment'] . '</td>';
			$mail_body .= '<td style="width:100px;">' . $mail_comment['email'] . '</td>';
			$mail_body .= '<td style="width:150px;">' . $mail_comment['cre_time'] . '</td>';
			$mail_body .= '</tr>';
		}
		$mail_body .= '</tbale>';
	}


	// if (isset($mail_body)) {
	// 	require_once(_INC_DIR.'/class.phpmailer.php');
	// 	require_once(_INC_DIR."/class.smtp.php");
	// 	include _MAIL_DIR."/sendMail.php";	
	// }
	
?>
