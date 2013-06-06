<?php
	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));

	define('_INC_DIR', __DIR__.'/../inc');
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');

	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');

function filter_naver_id($naver_id_list, $cafe_id, $category_id) {
	// 페이지에서 크롤링 한 데이터를 유니크하게 저장
	$unique_naver_id_list = array();
	foreach ($naver_id_list as $match_naver_id) {
		preg_match('/(?<=_).+?(?=_)/', $match_naver_id, $naver_id, PREG_OFFSET_CAPTURE);
		if (strlen($naver_id[0][0]) < 5) {
			continue;
		}
		// echo $naver_id[0][0] . "     $match_naver_id   <br />";
		// if (is_numeric($naver_id[0][0])) {
			$unique_naver_id_list[(string)$naver_id[0][0]] = array(
				"cafe_id" => $cafe_id,
				"category_id" => $category_id
			);
		// }
	}
	// print_r($unique_naver_id_list);
	return $unique_naver_id_list;
}

	$result = array();
	$idb = new idb();
	$category_list = $idb->select(query::getCategoryList);

	$current_hour = date('h');

	foreach ($category_list as $category) {
		if ($current_hour % $category['act_interval'] != 0) {
			continue;
		}

		$cafe_list = $idb->select(query::getCafeList, 's', array($category['id']));
		$startpage = intval($category['startpage']);
		$endpage = intval($category['endpage']);

		if (!empty($cafe_list)) {
			foreach ($cafe_list as $cafe) {
				foreach (range($startpage, $endpage) as $searchpage) {
					$url = "http://cafe.naver.com/ArticleList.nhn?search.boardtype=L&userDisplay=50&search.questionTab=A&noticeHidden=true&search.totalCount=151&search.page=$searchpage&search.clubid=$cafe[club_id]";
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$output = curl_exec($ch);

					usleep(100000);
					preg_match_all('/_[A-Za-z0-9]+_[0-9]{1,2}/', $output, $matches, PREG_PATTERN_ORDER);
					$result = $result + filter_naver_id($matches[0], $cafe['id'], $category['id']);
					print_r($result);
				}
			}
		}
	}
	foreach ($result as  $key => $value) {
		$result = $idb->insert(query::addUserinfo, 'ssss', array($key, $key.'@naver.com', $value['cafe_id'], $value['category_id']));
	}



	// $url = "http://cafe.naver.com/ArticleList.nhn?search.boardtype=L&search.questionTab=A&search.clubid=10298136&search.totalCount=151&search.clubid=10298136&search.page=1";
    
 //    $ch = curl_init($url);

 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

 //    $output = curl_exec($ch);

	// preg_match_all('/_[A-Za-z0-9]+_[0-9]{1,2}/', $output, $matches, PREG_PATTERN_ORDER);
	// print_r($matches);
