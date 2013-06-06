<?php
	header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=result.txt");
    $startpage = @$_POST['startpage'];
    $endpage = @$_POST['endpage'];
		/* STEP 2. visit the homepage to set the cookie properly */
		$Url = "http://www.livescore.co.kr/bbs/login_check.php";
		$ckfile = dirname(__FILE__) . '/hoit.jar';
		
		$fields = array(
			"mb_id" => "Subak433",
			"mb_password" => "qwer12"
		);

		$fields_string = "";
		foreach($fields as $key=>$value) { 
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');

		$ch = curl_init($Url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$output = curl_exec($ch);

		$result_id = array();
		$result_name = array();
		foreach (range($startpage, $endpage) as $page) {
			$list_url = "http://www.livescore.co.kr/bbs/board.php?bo_table=analysis&page=".$page;
			$ch = curl_init ($list_url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

			$output = curl_exec ($ch);
			$output = substr($output, strpos($output, 'board_tit "'));	
			// file_put_contents('list', $output);
			$pattern = "/wr_id=([0-9]+)&/";
			preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
			$wr_id_array = array_unique($match[1]);


			foreach ($wr_id_array as $wr_id) {
				$read_url = "http://www.livescore.co.kr/bbs/board.php?bo_table=analysis&wr_id=$wr_id";
				$ch = curl_init ($read_url);
				curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
				curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec ($ch);

				$output = substr($output, strpos($output, 'commentContents'));
				$startpos = strpos($output, "commentContents" + strlen("commentContents"));
				$endpos = strpos($output, "<!-- 코멘트 리스트 -->", $startpos);
				$output = substr($output, $startpos, $endpos - $startpos);

				$pattern = "/showSideView\(this, \'([0-9a-zA-Z]+)\', '([^\']*)'/";
				// preg_match($pattern, $output, $idmatch);
				preg_match_all($pattern, $output, $idmatch, PREG_PATTERN_ORDER);

				foreach ($idmatch[1] as $id) {
					$result_id[] = $id;
				}
				foreach ($idmatch[2] as $name) {
					$result_name[] = $name;
				}
				usleep(10000);
			}
		}
    foreach($result_id as $key=>$value) {
		echo $result_id[$key] . "," . $result_name[$key] . "\r\n";
	}
?>
