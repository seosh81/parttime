<?php
	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));

	define('_INC_DIR', __DIR__.'/../inc');
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');

	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');

	$naver_blog_url = "http://section.blog.naver.com/sub/SearchBlog.nhn?type=blog&term=&option.startDate=&option.endDate=";
					   // http://section.blog.naver.com/sub/SearchBlog.nhn?type=post&option.page.currentPage=1
	$daum_blog_url = "http://search.daum.net/search?w=blog&m=board&lpp=10&f=section&SA=daumsec";

	$result = array();
	$idb = new idb();
	$category_list = $idb->select(query::getBlogCategoryList);

	// $current_hour = date('h');

	foreach ($category_list as $category) {
		// echo $category['target'] . " " . $category['search_option'] . " ";
		// if (intval($current_hour) % intval($category['act_interval']) != 0) {
		// 	continue;
		// }

		$endpage = intval($category['endpage']);
		$keyword_array = explode(' ', $category['keyword']);

		// $cafe_list = $idb->select(query::getCafeList, 's', array($category['id']));
		$endpage = intval($category['endpage']);
		$endpage = 10;

		// echo "hiru";
		// naver 블로그 검색 영역
		foreach ($keyword_array as $key) {
			if ($category['target'] == 'naver' || $category['target'] == 'all') {
				if ($category['search_option'] == 'recent') {
					$naver_search_option = "&option.orderBy=recentdate";
				} else if ($category['search_option'] == 'correct') {
					$naver_search_option = "&option.orderBy=sim";
				}

				// $naver_option_keyword = "&option.keyword=".iconv('euc-kr', 'utf-8', $key);
				$naver_option_keyword = "&option.keyword=".$key;

				foreach (range(1, $endpage) as $searchPage) {
					$option_page = "&option.page.currentPage=".$searchPage;
					$naverurl = $naver_blog_url.$naver_option_keyword.$option_page.$naver_search_option;
					// echo $naverurl;
					
					$cx = curl_init();
					curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
					curl_setopt($cx, CURLOPT_URL, $naverurl);
					curl_setopt($cx, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($cx, CURLOPT_FOLLOWLOCATION, TRUE);
					$output = curl_exec($cx);

					// echo $output;
					// $output = file_get_contents($naver_blog_url.$naver_option_keyword.$option_page.$naver_search_option);
					// $output = file_get_contents('http://section.blog.naver.com/sub/SearchBlog.nhn?type=blog&term=&option.startDate=&option.endDate=&option.keyword=리그�&option.page.currentPage=10&option.orderBy=sim');
					// file_put_contents('temp', $output);
					$pattern = "/<h5><a href=\"http:\/\/blog.naver.com\/([0-9a-zA-Z]+)\"/";
					preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
					$result_from_naver = array_unique($match[1]);
					// print_r($match[1]);

					foreach ($result_from_naver as  $naver_id) {
						$result = $idb->insert(query::addBlogUserinfo, 'ssss', array($naver_id, $naver_id.'@naver.com', $category['id'], 'N'));
					}
					usleep(500000);
					// break;
					// echo $naver_blog_url.$naver_option_keyword.$option_page.$naver_search_option.'<br/>';
				}
			}
			// break;

			// print_r($result_from_naver);
			if ($category['target'] == 'daum' || $category['target'] == 'all') {
				if ($category['search_option'] == 'recent') {
					$daum_search_option = "&sort=step1";
				} else if ($category['search_option'] == 'correct') {
					$daum_search_option = "&sort=step3";
				}
				$daum_option_keyword = "&q=".$key;

				foreach (range(1, $endpage) as $searchPage) {
					$option_page = "&page=".$searchPage;
					$daumurl = $daum_blog_url.$daum_option_keyword.$option_page.$daum_search_option;
					// $daumurl = "http://search.daum.net/search?w=blog&m=board&lpp=10&page=1&sort=step3&q=car";
					$cx = curl_init($daumurl);
					curl_setopt($cx, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17");
					curl_setopt($cx, CURLOPT_RETURNTRANSFER, true);
					$output = curl_exec($cx);
					$pattern = '/<a href="http:\/\/blog.daum.net\/([0-9a-zA-Z]+)/';
					preg_match_all($pattern, $output, $match, PREG_PATTERN_ORDER);
					// $result_from_daum = array_merge($result_from_daum, $match[1]);
					$result_from_daum = array_unique($match[1]);
					foreach ($result_from_daum as  $daum_id) {
						$result = $idb->insert(query::addBlogUserinfo, 'ssss', array($daum_id, $daum_id.'@daum.net', $category['id'], 'D'));
					}
					usleep(500000);
				}
			}	
			// break;		
		}
		
		// foreach ($result_from_daum as  $daum_id) {
		// 	$result = $idb->insert(query::addBlogUserinfo, 'ssss', array($daum_id, $daum_id.'@daum.net', $category['id'], 'D'));
		// }
		// break;
	}