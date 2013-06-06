<?php
	$startpage = @$_GET['startpage'];	
	$endpage = @$_GET['endpage'];
	/* STEP 1. let’s create a cookie file */
	
	



	// $ch = curl_init ("http://named.com/bbs/board.php?bo_table=medal&page=4");
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
	// 	curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
	// $output = curl_exec ($ch);	

	// file_put_contents('temp', $output);

	/* STEP 3. visit list page */
	// foreach (range(1, 1) as $page) {
	// 	$list_url = "http://named.com/bbs/board.php?bo_table=medal&page=".$page;
	// 	$ch = curl_init ($list_url);
	// 	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	// 	$output = curl_exec ($ch);
	// 	$output = substr($output, strpos($output, '<tr class=""'));	
	// 	// file_put_contents($page, $output);
	// 	$pattern = "/wr_id=([0-9]+)&/";
	// 	preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);

	// 	foreach ($match[1] as $wr_id) {
	// 		echo $wr_id;
	// 		$url = "http://named.com/bbs/board.php?bo_table=medal&wr_id=".$wr_id;
	// 		$ch = curl_init ($url);
	// 		curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
	// 		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
	// 		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	// 		$output = curl_exec ($ch);
	// 		$output = substr($output, 0, strpos($output, "sty-list"));
	// 		file_put_contents($wr_id, $output);
	// 		$pattern = "/showSideView\(this, '([0-9a-zA-Z]+)', '(.+)'/";
	// 		preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
	// 		print_r($match[1]);
	// 		break;
	// 	}
	// }

	// curl_close($ch);
	// $url = "http://named.com/bbs/board.php?bo_table=medal&wr_id=724178";
	// $ch = curl_init ($url);
	// curl_setopt($ch, CURLOPT_COOKIEFILE,$ckfile);
	// curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
	// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	
	// $output = curl_exec ($ch);	
	// $removedFile = substr($output, 0, strpos($output, "sty-list"));
	// // echo $output;
	// // file_put_contents("temp", $output);

	// $pattern = "/showSideView\(this, '([0-9a-zA-Z]+)', '(.+)'/";
	// preg_match_all($pattern, $removedFile, $match, PREG_PATTERN_ORDER);
	// print_r($match);


	/* STEP 4. visit page list http://named.com/bbs/board.php?bo_table=medal&page=1 */
	// print_r($fields_string);

	// $file = file_get_contents("./temp");
	// $pattern = "/showSideView\(this, '([0-9a-zA-Z]+)', '(.+)'/";
	// preg_match_all($pattern, $file, $match, PREG_PATTERN_ORDER);
	// print_r($match);
	// $removedFile = substr($file, 0, strpos($file, "sty-list"));


	// echo $removedFile;
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h2>http://named.com</h2>
		<form action="1.php" method="get">
			<label for="startpage">시작</label><input type="text" name="startpage" />
			<label for="endpage">끝</label><input type="text" name="endpage" /><button type="submit">아이디검색하기</button>
		</form>
		<iframe id="frame1" name="frame1" style="display:none;"></iframe>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
var download = "<?php if(!empty($endpage)) echo 'Y'; ?>";
$(function() {
	if (download === 'Y') {
		sendDownloadRequest();
	}
});

function sendDownloadRequest() {
	var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "download.php");
        form.setAttribute("target", "frame1");
        var startpageField = document.createElement("input");
        startpageField.setAttribute("name", "startpage");
        startpageField.setAttribute("value","<?php echo $startpage?>" );
        startpageField.setAttribute("type", "hidden");
        var endpageField = document.createElement("input");
        endpageField.setAttribute("name", "endpage");
        endpageField.setAttribute("value","<?php echo $endpage?>" );
        endpageField.setAttribute("type", "hidden");
        form.appendChild(startpageField);
        form.appendChild(endpageField);
        document.body.appendChild(form);
        form.submit();
}
</script>
	</body>
</html>
