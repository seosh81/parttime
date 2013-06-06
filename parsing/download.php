<?php
	header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=result.txt");
    $startpage = @$_POST['startpage'];
    $endpage = @$_POST['endpage'];
    $count = file_get_contents("count");
    $count = intval($count);
    file_put_contents("count", $count + 1);
	if (!empty($endpage)) {
		/* STEP 2. visit the homepage to set the cookie properly */
		$Url = "http://named.com/bbs/login_check.php";
		$ckfile = '/home/hosting_users/seosh81/www/hoit.jar';
		
		$fields = array(
			"mb_id" => "nembi333",
			"mb_password" => "qwer12"
		);

		$fields_string = "";
		foreach($fields as $key=>$value) { 
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');

		$ch = curl_init($Url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$output = curl_exec ($ch);	
		file_put_contents('output', $output);
		// $url = "http://named.com/bbs/board.php?bo_table=medal&wr_id=724178";
		// $ch = curl_init ($url);
		// curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
		// curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		
		// $output = curl_exec ($ch);	
		// // echo $output;

		// $output = substr($output, 0, strpos($output, "sty-list"));

		// $pattern = "/showSideView\(this, '([0-9a-zA-Z]+)', '(.+)'/";
		// preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
		// print_r($match[1]);

		// curl_close($ch);
		// $url = "http://named.com/bbs/board.php?bo_table=medal&wr_id=25253";

		// $ch = curl_init ($url);
		// 		curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
		// 		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		// 		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		// 		$output = curl_exec ($ch);
		// echo $output;
		/* STEP 3. visit list page */
		$result_id = array();
		$result_name = array();
		foreach (range(1, $endpage) as $page) {
			$list_url = "http://named.com/bbs/board.php?bo_table=medal&page=".$page;
			$ch = curl_init ($list_url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

			$output = curl_exec ($ch);
			$output = substr($output, strpos($output, '<tr class=""'));	
			// file_put_contents($page, $output);
			$pattern = "/wr_id=([0-9]+)&/";
			preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
			// echo $output;
			foreach ($match[1] as $wr_id) {
				$url = "http://named.com/bbs/board.php?bo_table=medal&wr_id=".$wr_id;
				$ch = curl_init ($url);
				curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
				curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec ($ch);

				$output = substr($output, 0, strpos($output, "sty-list"));
				$pattern = "/showSideView\(this, '([0-9a-zA-Z]+)', '(.+)'/";
				preg_match_all($pattern, $output, $idmatch, PREG_PATTERN_ORDER);
				// $result_id = array_push($result_id, $idmatch[1]);
				foreach ($idmatch[1] as $id) {
					$result_id[] = $id;
				}
				foreach ($idmatch[2] as $name) {
					$result_name[] = $name;
				}
				// $result_name = array_push($result_name, $idmatch[2]);
				// usleep(10000);
			}
		}

		// foreach($result_id as $key=>$value) {
		// 	echo $result_id[$key] . ", " . $result_name[$key];
		// }
		// print_r($result_name);
	}



    foreach($result_id as $key=>$value) {
		echo $result_id[$key] . "," . $result_name[$key] . "\r\n";
	}
?>
