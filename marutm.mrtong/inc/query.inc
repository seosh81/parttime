<?php
class query 
{
	// Mrtong 카테고리 정보를 가져온다.
	const getMrtongCategoryList
		= "select seq, id, title, startpage, endpage, cre_time from mrtong_category order by seq";

	// Mrtong에 등록된 사이트 정보를 등록한다.
	const addSiteinfo
		= "insert into mrtong_siteinfo(id, code, name, url, naver_registry, category_id, cre_time)
			 values(?, ?, ?, ?, ?, ?, now())";

	// Mrtong 사이트 중에 id와 매핑되는 정보를 가져온다.
	const getSiteinfoCountById
		= "select count(1) from mrtong_siteinfo where id = ?";

	// Mrtong 저장된 사이트를 모두 가져온다.
	const getSiteinfoList
		= "select seq, id, name, url, CASE naver_registry WHEN 'Y' THEN '등록' ELSE '미등록' END as naver_registry, cre_time, (select title from mrtong_category where id = category_id) as category_name from mrtong_siteinfo order by seq desc";

	// Mrtong 저장된 사이트를 모두 가져온다.
	const getSiteinfoListByCategoryId
		= "SELECT seq, id, name, url, CASE naver_registry WHEN 'Y' THEN '등록' ELSE '미등록' END as naver_registry, cre_time, (SELECT title FROM mrtong_category WHERE id = category_id) AS category_name FROM mrtong_siteinfo  WHERE category_id = ? ORDER BY seq DESC";

	// ID에 대응되는 그룹을 가져온다.
	const getCategoryById
		= "select seq, id, title, keyword, act_interval, endpage, search_option, target from blog_category where id=? order by seq desc";

	// 아이디 모두를 가져온다.
	const getAllUserinfoList
		= "select id, email, category_id, flag, cre_time from blog_userinfo where category_id=? order by seq desc";

}