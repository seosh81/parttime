<?php
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
	$opt = @$_GET['opt'];
	$download = @$_GET['download'];
	$word = @$_GET['word'];
	$tls = filterCodes(@$_GET['tls']);

	if (!empty($word)) {
		if ($opt == 'direct') {
			$translatedWordByDirect = TranslateFromJapaneseToTargetLanguage($word, 'ko', $tls);
			$encodedResultByDirect = json_encode($translatedWordByDirect);
		} else {
			if ($opt == 'naver') {
				$japanesedWordByNaver = TranslateFromKoreanToJapaneseInNaver($word);
				$koreanFromJapanesedWordByNaver = TranslateFromJapaneseToKorean($japanesedWordByNaver);
				$translatedWordByNaver = TranslateFromJapaneseToTargetLanguage($japanesedWordByNaver, 'ja', $tls);
				$encodedResultByNaver = json_encode($translatedWordByNaver);
			} else if ($opt == 'google') {
				$japanesedWordByGoogle = TranslateFromKoreanToJapaneseInGoogle($word);
				$koreanFromJapanesedWordByGoogle = TranslateFromJapaneseToKorean($japanesedWordByGoogle);
				$translatedWordByGoogle = TranslateFromJapaneseToTargetLanguage($japanesedWordByGoogle, 'ja', $tls);
				$encodedResultByGoogle = json_encode($translatedWordByGoogle);
			} else if ($opt == 'all') {
				$translatedWordByDirect = TranslateFromJapaneseToTargetLanguage($word, 'ko', $tls);
				$encodedResultByDirect = json_encode($translatedWordByDirect);

				$japanesedWordByNaver = TranslateFromKoreanToJapaneseInNaver($word);
				$koreanFromJapanesedWordByNaver = TranslateFromJapaneseToKorean($japanesedWordByNaver);
				$translatedWordByNaver = TranslateFromJapaneseToTargetLanguage($japanesedWordByNaver, 'ja', $tls);
				$encodedResultByNaver = json_encode($translatedWordByNaver);

				$japanesedWordByGoogle = TranslateFromKoreanToJapaneseInGoogle($word);
				$koreanFromJapanesedWordByGoogle = TranslateFromJapaneseToKorean($japanesedWordByGoogle);
				$translatedWordByGoogle = TranslateFromJapaneseToTargetLanguage($japanesedWordByGoogle, 'ja', $tls);
				$encodedResultByGoogle = json_encode($translatedWordByGoogle);
			}
		}

				
	}

function getLangFromCode($code) {
	global $langCode;
	return isset($langCode[$code]) ? $langCode[$code] : '';
}

# 언어 코드가 올바르지 않을 경우에는 해당 코드를 번역 대상에서 제외한다
function filterCodes($codes) {
	global $langCode;
	$validatedCodes = array();
	$codeArray = explode(',', $codes);
	foreach ($codeArray as $code) {
		if (getLangFromCode($code) != '') {
			array_push($validatedCodes, $code);
		}
	}
	return implode(',', $validatedCodes);
}


# 구글 tralslate.google.com에 접속을 위해서 쿠키 처리를 하고 curl로 데이터를 response를 받아온다
function curl($url,$params = array(),$is_coockie_set = false) {
	if(!$is_coockie_set){
		/* STEP 1. let’s create a cookie file */
		$ckfile = tempnam ("/tmp", "CURLCOOKIE");

		/* STEP 2. visit the homepage to set the cookie properly */
		$ch = curl_init ($url);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec ($ch);	
	}

	$str = ''; 
	global $result_arr;
	foreach($params as $key => $value) {
		$result_arr[] = urlencode($key)."=".urlencode($value);
	}

	if(!empty($result_arr))
	$str = '?'.implode('&',$result_arr);

	/* STEP 3. visit cookiepage.php */

	$Url = $url.$str;

	$ch = curl_init ($Url);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec ($ch);
	curl_close($ch);
	return $output;
}

# 일본어에서 번역할 언어로 번역후 결과를 저장
function TranslateFromJapaneseToTargetLanguage($word, $sl, $tls) {
	$word = urlencode($word);

	$tlArray = explode(',', $tls);
	$result_translate = array();
	foreach ($tlArray as $tl) {
		$url = "http://translate.google.com/translate_a/t?client=t&text=$word&hl=".$tl."&sl=".$sl."&tl=".$tl."&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";
		$name_en = curl($url);
		$name_en = explode('"',$name_en);
		$result_translate[$tl] = $name_en[1];
	}
	return $result_translate;
}

# 구글 번역을 통해 한글을 일본어로 변환
function TranslateFromKoreanToJapaneseInGoogle($word) {
	$temp = TranslateFromJapaneseToTargetLanguage($word, 'ko', 'ja');
	return $temp['ja'];
}

# 네이버 번역을 통해 한글을 일본어로 변환
function TranslateFromKoreanToJapaneseInNaver($word) {
	$url = "http://jptrans.naver.net/short_trans/translate_300_japan_service_trans.php?referto=jpdic";

	$ch = curl_init ($url);
	$data = array('mode' => 'k2j', 'body' => $word);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec($ch);
	return my_json_decode($output)->result;
}

# 구글 번역을 통해 한국어->일본어로 나온 결과를 다시 한국어로 변환
function TranslateFromJapaneseToKorean($word) {
	$temp = TranslateFromJapaneseToTargetLanguage($word, 'ja', 'ko');
	return $temp['ko'];
}

# naver에서 검색 결과를 올바른 json형태로 뿌려주지 않아서 변환해주는 작업
function my_json_decode($s) {
    $s = preg_replace('/(\w+):/i', '"\1":', $s);
    return json_decode($s);
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
	line-height: 1.67;
}
table {
	border-spacing: 0;
	border-collapse: collapse;
	width: 600px;
}
th {
	color: #FFF;
	border: 1px solid #4d90fe; 
	background-color:#6199df;
}
td {
	font-size:20px;
	border: 1px solid #bbb;
}
ul {
	list-style: none;
	padding-left: 0px;
}
ul span {
	width: 100px;
	float: left;
	text-align: center;
	background-color: grey;
	color: white;
	font-weight: bold;
	margin-right: 5px;
}
</style>
</head>
<body>
	<form action="translate.php" method="get">
		<div>
			<label for="opt">옵션</label>
			<select id="opt" name="opt">
				<option value="naver" <?php if($opt == 'naver') echo 'selected';?>>네이버 일본어웹 -> 구글 다국어 번역</option>
				<option value="google" <?php if($opt == 'google') echo 'selected';?>>구글 일본어 -> 구글 다국어 번역</option>
				<option value="direct" <?php if($opt == 'direct') echo 'selected';?>>구글 다국어 번역</option>
				<option value="all" <?php if($opt == 'all') echo 'selected';?>>모두 이용</option>
			</select>
			<input type="hidden" name="download" value="N" />
			<label for="download">결과 다운로드</label><input type="checkbox" id="download" name="download" value="Y" <?php if ($download=='Y') echo 'checked';?>/>
			<br />
			<label for="tls">번역될 언어(예: en)</label><input type="text" id="tls" name="tls" value="<?php echo $tls?>" /><br />
			<label for="word">번역할 문장: </label><input type="text" id="word" name="word" maxlength="100" size="100" value="<?php echo $word?>" /><br />
			<button type="submit">번역</button>
		</div>
	</form>
	
	
<?php								
	if (@$translatedWord) {
echo <<<EOT
	<span>원문</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$word
	</div>
EOT;
	}
?>

<?php								
	if (@$translatedWordByNaver && ($opt == 'naver')) {
echo <<<EOT
	<span>네이버 일본어 웹 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$japanesedWordByNaver
	</div>
	<span>일본어 한글 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$koreanFromJapanesedWordByNaver;
	</div>
EOT;
echo <<<EOT
	<span>결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByNaver as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div>";

	} else if (@$translatedWordByGoogle && ($opt == 'google')) {
echo <<<EOT
	<span>구글 일본어 웹 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$japanesedWordByGoogle
	</div>
	<span>일본어 한글 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$koreanFromJapanesedWordByGoogle
	</div>
EOT;
echo <<<EOT
	<span>결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByGoogle as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div>";
	} else if (@$translatedWordByDirect && ($opt == 'direct')) { 
echo <<<EOT
	<span>구글 다국어 번역 결과(일본어 번역 X)</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByDirect as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div>";
	} else if (@$translatedWordByGoogle && ($opt == 'all')) {
echo <<<EOT
	<span>네이버 일본어 웹 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$japanesedWordByNaver
	</div>
	<span>일본어 한글 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$koreanFromJapanesedWordByNaver;
	</div>
EOT;
echo <<<EOT
	<span>결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByNaver as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div><hr />";
echo <<<EOT
	<span>구글 일본어 웹 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$japanesedWordByGoogle
	</div>
	<span>일본어 한글 번역결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		$koreanFromJapanesedWordByGoogle
	</div>
EOT;
echo <<<EOT
	<span>결과</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByGoogle as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div><hr />";
echo <<<EOT
	<span>구글 다국어 번역 결과(일본어 번역 X)</span>
	<div style="width:620px;border:2px solid #000;overflow:hidden;">
		<ul>
EOT;
		foreach($translatedWordByDirect as $key => $value) {
			echo "<li><span>" . getLangFromCode($key) . "</span>$value</li>";
		}
echo "</ul></div>";
	}
?>
	<br />
	<br />
	<iframe id="frame1" name="frame1" style="display:none;"></iframe>
	<span id="toggle" style="cursor:pointer;">언어 코드표 숨기기</span>
	<div id="code">
		<table>
			<thead>
				<tr>
					<th width="50%">Language</th>
					<th width="50%">Code</th>
				</tr>
			</thead>
			<tbody>
			    <tr>
			      <td>Afrikaans</td>
			      <td><code>af</code></td>
			    </tr>
			     <tr>
			      <td>Albanian</td>
			      <td><code>sq</code></td>
			    </tr>
			    <tr>
			      <td>Arabic</td>
			      <td><code>ar</code></td>
			    </tr>
			    <tr>
			      <td>Azerbaijani</td>
			      <td><code>az</code></td>
			    </tr>
			    <tr>
			      <td>Basque</td>
			      <td><code>eu</code></td>
			    </tr>
			    <tr>
			      <td>Bengali</td>
			      <td><code>bn</code></td>
			    </tr>
			    <tr>
			      <td>Belarusian</td>
			      <td><code>be</code></td>
			    </tr>
			    <tr>
			      <td>Bulgarian</td>
			      <td><code>bg</code></td>
			    </tr>
			    <tr>
			      <td>Catalan</td>
			      <td><code>ca</code></td>
			    </tr>
			    <tr>
			      <td>Chinese Simplified</td>
			      <td><code>zh-CN</code></td>
			    </tr>
			    <tr>
			      <td>Chinese Traditional</td>
			      <td><code>zh-TW</code></td>
			    </tr>
			    <tr>
			      <td>Croatian</td>
			      <td><code>hr</code></td>
			    </tr>
			    <tr>
			      <td>Czech</td>
			      <td><code>cs</code></td>
			    </tr>
			    <tr>
			      <td>Danish</td>
			      <td><code>da</code></td>
			    </tr>
			    <tr>
			      <td>Dutch</td>
			      <td><code>nl</code></td>
			    </tr>
			    <tr>
			      <td>English</td>
			      <td><code>en</code></td>
			    </tr>
			    <tr>
			      <td>Esperanto</td>
			      <td><code>eo</code></td>
			    </tr>
			    <tr>
			      <td>Estonian</td>
			      <td><code>et</code></td>
			    </tr>
			    <tr>
			      <td>Filipino</td>
			      <td><code>tl</code></td>
			    </tr>
			    <tr>
			      <td>Finnish</td>
			      <td><code>fi</code></td>
			    </tr>
			    <tr>
			      <td>French</td>
			      <td><code>fr</code></td>
			    </tr>
			    <tr>
			      <td>Galician</td>
			      <td><code>gl</code></td>
			    </tr>
			    <tr>
			      <td>Georgian</td>
			      <td><code>ka</code></td>
			    </tr>
			    <tr>
			      <td>German</td>
			      <td><code>de</code></td>
			    </tr>
			    <tr>
			      <td>Greek</td>
			      <td><code>el</code></td>
			    </tr>
			    <tr>
			      <td>Gujarati</td>
			      <td><code>gu</code></td>
			    </tr>
			    <tr>
			      <td>Haitian Creole</td>
			      <td><code>ht</code></td>
			    </tr>
			    <tr>
			      <td>Hebrew</td>
			      <td><code>iw</code></td>
			    </tr>
			    <tr>
			      <td>Hindi</td>
			      <td><code>hi</code></td>
			    </tr>
			    <tr>
			      <td>Hungarian</td>
			      <td><code>hu</code></td>
			    </tr>
			    <tr>
			      <td>Icelandic</td>
			      <td><code>is</code></td>
			    </tr>
			    <tr>
			      <td>Indonesian</td>
			      <td><code>id</code></td>
			    </tr>
			    <tr>
			      <td>Irish</td>
			      <td><code>ga</code></td>
			    </tr>
			    <tr>
			      <td>Italian</td>
			      <td><code>it</code></td>
			    </tr>
			    <tr>
			      <td>Japanese</td>
			      <td><code>ja</code></td>
			    </tr>
			    <tr>
			      <td>Kannada</td>
			      <td><code>kn</code></td>
			    </tr>
			    <tr>
			      <td>Korean</td>
			      <td><code>ko</code></td>
			    </tr>
			    <tr>
			      <td>Latin</td>
			      <td><code>la</code></td>
			    </tr>
			    <tr>
			      <td>Latvian</td>
			      <td><code>lv</code></td>
			    </tr>
			    <tr>
			      <td>Lithuanian</td>
			      <td><code>lt</code></td>
			    </tr>
			    <tr>
			      <td>Macedonian</td>
			      <td><code>mk</code></td>
			    </tr>
			    <tr>
			      <td>Malay</td>
			      <td><code>ms</code></td>
			    </tr>
			    <tr>
			      <td>Maltese</td>
			      <td><code>mt</code></td>
			    </tr>
			    <tr>
			      <td>Norwegian</td>
			      <td><code>no</code></td>
			    </tr>
			    <tr>
			      <td>Persian</td>
			      <td><code>fa</code></td>
			    </tr>
			    <tr>
			      <td>Polish</td>
			      <td><code>pl</code></td>
			    </tr>
			    <tr>
			      <td>Portuguese</td>
			      <td><code>pt</code></td>
			    </tr>
			    <tr>
			      <td>Romanian</td>
			      <td><code>ro</code></td>
			    </tr>
			    <tr>
			      <td>Russian</td>
			      <td><code>ru</code></td>
			    </tr>
			    <tr>
			      <td>Serbian</td>
			      <td><code>sr</code></td>
			    </tr>
			    <tr>
			      <td>Slovak</td>
			      <td><code>sk</code></td>
			    </tr>
			    <tr>
			      <td>Slovenian</td>
			      <td><code>sl</code></td>
			    </tr>
			    <tr>
			      <td>Spanish</td>
			      <td><code>es</code></td>
			    </tr>
			    <tr>
			      <td>Swahili</td>
			      <td><code>sw</code></td>
			    </tr>
			    <tr>
			      <td>Swedish</td>
			      <td><code>sv</code></td>
			    </tr>
			    <tr>
			      <td>Tamil</td>
			      <td><code>ta</code></td>
			    </tr>
			    <tr>
			      <td>Telugu</td>
			      <td><code>te</code></td>
			    </tr>
			    <tr>
			      <td>Thai</td>
			      <td><code>th</code></td>
			    </tr>
			    <tr>
			      <td>Turkish</td>
			      <td><code>tr</code></td>
			    </tr>
			    <tr>
			      <td>Ukrainian</td>
			      <td><code>uk</code></td>
			    </tr>
			    <tr>
			      <td>Urdu</td>
			      <td><code>ur</code></td>
			    </tr>
			    <tr>
			      <td>Vietnamese</td>
			      <td><code>vi</code></td>
			    </tr>
			    <tr>
			      <td>Welsh</td>
			      <td><code>cy</code></td>
			    </tr>
			    <tr>
			      <td>Yiddish</td>
			      <td><code>yi</code></td>
			    </tr>
	  		</tbody>
		</table>
	</div>
	
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">

var download = "<?php echo $download ?>";
	$(function() {
		$("#toggle").on('click', function() {
			if ($("#code").is(":visible")) {
				$("#toggle").html("언어 코드표 보기");
				$("#code").hide();
			} else {
				$("#toggle").html("언어 코드표 숨기기");
				$("#code").show();
			}
		});
		if (download === 'Y') {
			sendDownloadRequest();
		}

	});

// 파일을 다운로드를 위한 함수
function sendDownloadRequest() {
	var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "download_result.php");
        form.setAttribute("target", "frame1");
        var optionHiddenField = document.createElement("input");
        optionHiddenField.setAttribute("name", "opt");
        optionHiddenField.setAttribute("value","<?php echo $opt?>" );
        optionHiddenField.setAttribute("type", "hidden");
        var naverHiddenField = document.createElement("input");
        naverHiddenField.setAttribute("name", "naver");
        naverHiddenField.setAttribute("value","<?php echo urlencode(@$encodedResultByNaver)?>" );
        naverHiddenField.setAttribute("type", "hidden");
        var googleHiddenField = document.createElement("input");
        googleHiddenField.setAttribute("name", "google");
        googleHiddenField.setAttribute("value","<?php echo urlencode(@$encodedResultByGoogle)?>" );
        googleHiddenField.setAttribute("type", "hidden");
        var directHiddenField = document.createElement("input");
        directHiddenField.setAttribute("name", "direct");
        directHiddenField.setAttribute("value","<?php echo urlencode(@$encodedResultByDirect)?>" );
        directHiddenField.setAttribute("type", "hidden");
        form.appendChild(optionHiddenField);
        form.appendChild(naverHiddenField);
        form.appendChild(googleHiddenField);
        form.appendChild(directHiddenField);
        document.body.appendChild(form);
        form.submit();
}
</script>
</body>
</html>

