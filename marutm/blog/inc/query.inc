<?php
class query 
{
	// 그룹 정보를 diplay_order, cre_time 순서로 가져온다.
	const getBlogCategoryList
		= "select seq, id, title, keyword, act_interval, endpage, search_option, target, cre_time from blog_category order by seq desc";

	// ID에 대응되는 그룹을 가져온다.
	const getCategoryById
		= "select seq, id, title, keyword, act_interval, endpage, search_option, target from blog_category where id=? order by seq desc";

	// 그룹 정보를 추가한다.
	const addCategory
		= "insert into blog_category(id, title, keyword, act_interval, endpage, search_option, target, cre_time) values(?, ?, ?, ?, ?, ?, ?, now())";

	// 그룹 정보를 수정한다.
	const editCategory
		= "update blog_category set title=?, keyword=?, act_interval=?, endpage=?, search_option=?, target=? where id=?";

	// 저장된 사용자 아이디 수를 구해온다.
	const getBlogUserinfoListCount
		= "select count(1) from blog_userinfo where category_id=?";

	// 추출일자 별 아이디 수를 구해온다.
	const getBlogUserinfoListByDateCount
		= "select count(1) from blog_userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ?";

	// 추출 아이디를 추가한다.
	const addBlogUserinfo
		= "insert into blog_userinfo(id, email, category_id, flag, cre_time) values(?, ?, ?, ?, now())";

	// 아이디를 가져온다.
	const getBlogUserinfoList
		= "select id, email, category_id, flag, cre_time from blog_userinfo where category_id=? order by seq desc limit ?, ?";

	// 아이디 모두를 가져온다.
	const getAllUserinfoList
		= "select id, email, category_id, flag, cre_time from blog_userinfo where category_id=? order by seq desc";

	// 추출일자 별 아이디를 가져온다.
	const getBlogUserinfoListByDate
		= "select id, email, category_id, flag, cre_time from blog_userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ? order by seq desc limit ?, ?";

	// 추출일자 별 모든 아이디를 가져온다.
	const getAllUserinfoListByDate
		= "select id, email, cafe_id, flag, cre_time from blog_userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ? order by seq desc";
}