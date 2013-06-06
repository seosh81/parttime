<?php
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
	$xmlfile = "/home/hosting_users/jhoasys1/www/wea/Main_143.xml";
	$url = file_get_contents($file);

	

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec ($ch);

	file_put_contents($xmlfile, $output);
?>
