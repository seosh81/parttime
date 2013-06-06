<?php
	$startpage = @$_GET['startpage'];
	$endpage = @$_GET['endpage'];
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h2>http://livescore.co.kr</h2>
		<form action="2.php" method="get">
			<label for="startpage">시작</label><input type="text" name="startpage" value="<?php echo $startpage?>" />
			<label for="endpage">끝</label><input type="text" name="endpage" value="<?php echo $endpage?>" /><button type="submit">아이디검색하기</button>
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
        form.setAttribute("action", "download_livescore.php");
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