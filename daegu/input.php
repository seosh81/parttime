<?
	if (!function_exists('file_put_contents')) {
	    function file_put_contents($filename, $data) {
	        $f = @fopen($filename, 'w');
	        if (!$f) {
	            return false;
	        } else {
	            $bytes = fwrite($f, $data);
	            fclose($f);
	            return $bytes;
	        }
	    }
	}

	$file = "/home/hosting_users/jhoasys1/www/serial.txt";

	$new_url = @$_POST['url'];
	if (!empty($new_url)) {
		file_put_contents($file, $new_url);
	}

	
	$url = file_get_contents($file);
	echo $url;
?>
<form action="te.php" method="post">
	<label id="url">xml url:</label><input type="text" name="url">
	<button type="submit">submit</button>
</form>
