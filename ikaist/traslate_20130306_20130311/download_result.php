<?php
	header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=result.txt");
	$langCode = array(
		"af"=>"Afrikaans",
		"sq"=>"Albanian",
		"ar"=>"Arabic",
		"az"=>"Azerbaijani",
		"eu"=>"Basque",
		"bn"=>"Bengali",
		"be"=>"Belarusian",
		"bg"=>"Bulgarian",
		"ca"=>"Catalan",
		"zh-CN"=>"Chinese Simplified",
		"zh-TW"=>"Chinese Traditional",
		"hr"=>"Croatian",
		"cs"=>"Czech",
		"da"=>"Danish",
		"nl"=>"Dutch",
		"en"=>"English",
		"eo"=>"Esperanto",
		"et"=>"Estonian",
		"tl"=>"Filipino",
		"fi"=>"Finnish",
		"fr"=>"French",
		"gl"=>"Galician",
		"ka"=>"Georgian",
		"de"=>"German",
		"el"=>"Greek",
		"gu"=>"Gujarati",
		"ht"=>"Haitian Creole",
		"iw"=>"Hebrew",
		"hi"=>"Hindi",
		"hu"=>"Hungarian",
		"is"=>"Icelandic",
		"id"=>"Indonesian",
		"ga"=>"Irish",
		"it"=>"Italian",
		"ja"=>"Japanese",
		"kn"=>"Kannada",
		"ko"=>"Korean",
		"la"=>"Latin",
		"lv"=>"Latvian",
		"lt"=>"Lithuanian",
		"mk"=>"Macedonian",
		"ms"=>"Malay",
		"mt"=>"Maltese",
		"no"=>"Norwegian",
		"fa"=>"Persian",
		"pl"=>"Polish",
		"pt"=>"Portuguese",
		"ro"=>"Romanian",
		"ru"=>"Russian",
		"sr"=>"Serbian",
		"sk"=>"Slovak",
		"sl"=>"Slovenian",
		"es"=>"Spanish",
		"sw"=>"Swahili",
		"sv"=>"Swedish",
		"ta"=>"Tamil",
		"te"=>"Telugu",
		"th"=>"Thai",
		"tr"=>"Turkish",
		"uk"=>"Ukrainian",
		"ur"=>"Urdu",
		"vi"=>"Vietnamese",
		"cy"=>"Welsh",
		"yi"=>"Yiddish"
	);
	$opt = $_POST['opt'];
	if ($opt == 'naver') {
		$result = json_decode(urldecode($_POST['naver']), true);
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
	} else if ($opt == 'google') {
		$result = json_decode(urldecode($_POST['google']), true);
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
	} else if ($opt == 'direct') {
		$result = json_decode(urldecode($_POST['direct']), true);
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
	} else if ($opt == 'all') {
		$result = json_decode(urldecode($_POST['naver']), true);
		echo "From naver\r\n";
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
		$result = json_decode(urldecode($_POST['google']), true);
		echo "From google\r\n";
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
		$result = json_decode(urldecode($_POST['direct']), true);
		echo "Without japanese translation\r\n";
		foreach ($result as $key => $value) {
			echo "$langCode[$key] $value\r\n";
		}
	}

?>