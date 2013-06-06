<?php
	function curl($url) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
		$output = curl_exec($cx);
		curl_close($cx);
		return $output;
	}
	function curl_navercheck($url) {
		$cx = curl_init($url);
		curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
		curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cx, CURLOPT_HTTPHEADER, array (
        	"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    	));
		$output = curl_exec($cx);
		curl_close($cx);
		usleep(100000);
		return $output;
	}

	

	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));

	define('_INC_DIR', __DIR__.'/../inc');
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');

	$list_url = "http://www.mrtong.co.kr/mrtong.StoreAction.do?method=cateMain&searchVal=reg&searchSelect=reg";
	$detail_url = "http://www.mrtong.co.kr/mrtong.StoreAction.do?method=detail";
	$naver_check_url = "http://web.search.naver.com/search.naver?sm=tab_hty.top&where=site&ie=utf8&x=0&y=0";

	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');

	$idb = new idb();
	$category_list = $idb->select(query::getMrtongCategoryList);

	foreach ($category_list as $category) {
		// echo $category['id'] . ' ' . $category['title'];
		// foreach (range($category['startpage'], $category['endpage']) as $page) {

		foreach (range($category['endpage'], $category['startpage']) as $page) {
		// foreach (range(6, 6) as $page) {
			$page_option = "&noPage=$page";
			// $page_option = "&noPage=2";
			$category_option = "&category_id=" . $category['id'];
			// echo "page_option=$page_option category_option=$category_option ";

			$list_output = curl($list_url . $category_option . $page_option);
			$pattern = "/actDetail\('([0-9]+)','([A-Z0-9]+)'\)/";
			preg_match_all($pattern, $list_output, $list_match, PREG_PATTERN_ORDER);

			$id_array = $list_match[1];
			$id_array = array_reverse($id_array);
			$code_array = $list_match[2];
			$code_array = array_reverse($code_array);
			foreach ($id_array as $key => $corp_id) {
				$siteinfo_from_db = $idb->selectCount(query::getSiteinfoCountById, 's', array($corp_id));
				if ($siteinfo_from_db > 0) {
					// already exist, so skip it.
					continue;
				}

				$corp_id_option = "&corp_id=$corp_id";
				$site_code_option = "&site_cd=" . $code_array[$key];
				$detail_output = iconv('euc-kr', 'utf-8', curl($detail_url . $corp_id_option . $site_code_option));

				$startpos = strpos($detail_output, "txt_spec") + strlen("txt_spec");
				$endpos = strpos($detail_output, "target", strpos($detail_output, "txt_siul"));
				$detail_snippet = substr($detail_output, $startpos, $endpos - $startpos);
				// echo $detail_snippet;

				$pattern = '/class="txt_b">(.*)<\/strong>/';
				preg_match($pattern, $detail_snippet, $site_name);
				$site_name = $site_name[1];

				$pattern = '/href="http:\/\/(.*)"/';
				preg_match($pattern, $detail_snippet, $site_url);
				$site_url = $site_url[1];
				$site_url = str_replace("/", "", $site_url);
				$site_url = str_replace("www.", "", $site_url);

				$naver_check_output = curl_navercheck($naver_check_url . '&query=' . $site_url);
				$naver_registered  = 'N';

				if (strpos($naver_check_output, "http://sstatic.naver.net/search/img3/ico_pc_v1.gif")) {
					$startpos = strpos($naver_check_output, "http://sstatic.naver.net/search/img3/ico_pc_v1.gif") + strlen("http://sstatic.naver.net/search/img3/ico_pc_v1.gif");
					$endpos = strpos($naver_check_output, "</ul>", $startpos);
					$site_snippet = substr($naver_check_output, $startpos, $endpos - $startpos);	

					$pattern = '/"http:\/\/' . $site_url . '\/"/';
					preg_match($pattern, $site_snippet, $match);
					foreach ($match as $find) {
						$naver_registered = 'Y';
					}

					$pattern = '/"http:\/\/www.' . $site_url . '\/"/';
					preg_match($pattern, $site_snippet, $match);
					foreach ($match as $find) {
						$naver_registered = 'Y';
					}
				}
				
				$idb->insert(query::addSiteinfo, 'ssssss', array($corp_id, $code_array[$key], $site_name, $site_url, $naver_registered, $category['id']));
			}
		}
	}
	// foreach (range(1, 1) as $page) {
	// 	$page = "&noPage=" . $page;
	// 	$category = "&category_id=A";

	// 	$list = iconv('euc-kr','utf-8', curl($list_url . $category . $page));
	// 	$pattern = "/actDetail\('([0-9]+)','([A-Z0-9]+)'\)/";
	// 	preg_match_all($pattern, $list, $list_match, PREG_PATTERN_ORDER);

	// 	$id_array = array_unique($list_match[1]);
	// 	$code_array = array_unique($list_match[2]);
	// 	foreach ($id_array as $key => $corp_id) {
	// 		$output = iconv('euc-kr','utf-8', curl($detail_url . "&corp_id=$corp_id&site_cd=" . $code_array[$key]));	
	// 		$startpos = strpos($output, "txt_spec") + strlen("txt_spec");
	// 		$endpos = strpos($output, "target", strpos($output, "txt_siul"));
			
	// 		$snippet = substr($output, $startpos, $endpos - $startpos);

	// 		$pattern = '/class="txt_b">(.*)</';
	// 		preg_match($pattern, $snippet, $corp_name);

	// 		$pattern = '/href="http:\/\/(.*)"/';
	// 		preg_match($pattern, $snippet, $corp_url);
	// 		// echo $corp_id . ' ' . $code_array[$key] . ' ' . $corp_name[1] . ' ' . $corp_url[1] . ' ';

	// 		$output = curl($naver_check_url . '&query=' . $corp_url[1]);
			
	// 		$naver_registered  = false;
	// 		if (strpos($output, "http://sstatic.naver.net/search/img3/ico_pc_v1.gif")) {
	// 			$startpos = strpos($output, "http://sstatic.naver.net/search/img3/ico_pc_v1.gif") + strlen("http://sstatic.naver.net/search/img3/ico_pc_v1.gif");
	// 			$endpos = strpos($output, "</ul>", $startpos);
	// 			$site_snippet = substr($output, $startpos, $endpos - $startpos);	
	// 			// $pattern = '/"'. $corp_url[1] . '\/"/';
	// 			$pattern = '/"http:\/\/' . $corp_url[1] . '\/"/';
	// 			preg_match($pattern, $site_snippet, $match);
	// 			foreach ($match as $find) {
	// 				$naver_registered = true;
	// 			}
	// 			$pattern = '/"http:\/\/www.' . $corp_url[1] . '\/"/';
	// 			preg_match($pattern, $site_snippet, $match);
	// 			foreach ($match as $find) {
	// 				$naver_registered = true;
	// 			}
				
	// 		}
	// 		if ($naver_registered) {
	// 			echo " 등록 !!!!<br />";
	// 		} else {
	// 			echo " 아웃 !!!! <br />";
	// 		}
			
	// 		// file_put_contents('temp', substr($output, $startpos, $endpos - $startpos));
	// 		// $pattern = '/"' . $corp_url[1] . '"/';
	// 		// $pattern = '/www.luvbebe.com/';
	// 		// preg_match($pattern, $site_snippet, $match);
	// 		// echo $pattern;
			
	// 		// file_put_contents('temp2', $output);
			
	// 		// if (!strpos($output, "http://sstatic.naver.net/search/img3/ico_pc_v1.gif")) {
	// 		// 	echo "does not register";
	// 		// }

	// 		// break;
	// 		usleep(100000);

	// 	}
	// }
?>
