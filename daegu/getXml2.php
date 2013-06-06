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

	function createXml($source) {
		global $xml;
		global $root;
		$Info = $xml->createElement("Info");
		$InfoAreaAttribute = $xml->createAttribute("area");
		$InfoAreaAttribute->value = $source->Info->Area;
		$Info->appendChild($InfoAreaAttribute);
		$InfoTimeAttribute = $xml->createAttribute("time");
		$InfoTimeAttribute->value = $source->Info['time'];
		$Info->appendChild($InfoTimeAttribute);

		$Area = $xml->createElement("Area");
		$AreaText = $xml->createTextNode($source->Info->Area);
		$Area->appendChild($AreaText);

		$Daily = $xml->createElement("Daily");

		$date = $xml->createElement("date");
		$dateText = $xml->createTextNode($source->Info->Daily_1->date);
		$date->appendChild($dateText);
		$Daily->appendChild($date);

		$wea = $xml->createElement("wea");
		$weaText = $xml->createTextNode($source->Info->Daily_1->wea);
		$wea->appendChild($weaText);
		$Daily->appendChild($wea);

		$code = $xml->createElement("code");
		$codeText = $xml->createTextNode($source->Info->Daily_1->code);
		$code->appendChild($codeText);
		$Daily->appendChild($code);

		$n_t = $xml->createElement("n_t");
		$n_tText = $xml->createTextNode($source->Info->Now->n_t);
		$n_t->appendChild($n_tText);
		$Daily->appendChild($n_t);

		$t_min = $xml->createElement("t_min");
		$t_minText = $xml->createTextNode($source->Info->Daily_1->t_low);
		$t_min->appendChild($t_minText);
		$Daily->appendChild($t_min);

		$t_max = $xml->createElement("t_max");
		$t_maxText = $xml->createTextNode($source->Info->Daily_1->t_high);
		$t_max->appendChild($t_maxText);
		$Daily->appendChild($t_max);

		$p_rain = $xml->createElement("p_rain");
		$p_rainText = $xml->createTextNode($source->Info->Daily_1->p_rain);
		$p_rain->appendChild($p_rainText);
		$Daily->appendChild($p_rain);

		$Info->appendChild($Area);
		$Info->appendChild($Daily);

		$root->appendChild($Info);
	}
	$code_file = $ckfile = dirname(__FILE__) . '/code_file.sav';
	$code_list = file_get_contents($code_file);
	
	// echo $code_list;
	$code_list = explode("\n", $code_list);
	
	// echo 'area ' . $xmlFromFile->Info->Area . "\r\n";
	// echo 'time ' . $xmlFromFile->Info['time'] . "\r\n";
	// echo 'date ' . $xmlFromFile->Info->Daily_1->date . "\r\n";
	// echo 'wea ' . $xmlFromFile->Info->Daily_1->wea . "\r\n";
	// echo 'code ' . $xmlFromFile->Info->Daily_1->code . "\r\n";
	// echo 't_low ' . $xmlFromFile->Info->Daily_1->t_low . "\r\n";
	// echo 't_high ' . $xmlFromFile->Info->Daily_1->t_high . "\r\n";
	// echo 'p_rain ' . $xmlFromFile->Info->Daily_1->p_rain . "\r\n";
	// echo 'n_t ' . $xmlFromFile->Info->Now->n_t . "\r\n";


	$xml = new DOMDocument("1.0", "utf-8");
	$root = $xml->createElement("PopupWeather");
	$xml->appendChild($root);
	
	foreach($code_list as $code) {
		$file = "http://jhweather1.cafe24.com/Main_" . trim($code) . ".xml";

		// $xmlFromFile = simplexml_load_file($file);

		$ch = curl_init($file);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
		// echo $output;
		$xmlFromFile = simplexml_load_string($output);
		createXml($xmlFromFile);
	}
	

	$xml->formatOutput = true;
	// file_put_contents(filename, data)
	$xml->save("Map_Now_Fct2.xml") or die("Error");

	// include "./createXmlElements.php";
	