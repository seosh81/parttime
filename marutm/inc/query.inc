<?php
class query 
{
	// 그룹 정보를 diplay_order, cre_time 순서로 가져온다.
	const getCategoryList
		= "select seq, id, title, display_order, act_interval, startpage, endpage, cre_time from category order by display_order desc, seq desc";

	// ID에 대응되는 그룹을 가져온다.
	const getCategoryById
		= "select seq, id, title, act_interval, display_order, startpage, endpage from category where id=? order by display_order desc, seq desc";

	// 그룹 정보를 추가한다.
	const addCategory
		= "insert into category(id, title, act_interval, display_order, startpage, endpage, cre_time) values(?, ?, ?, ?, ?, ?, now())";

	// 그룹 정보를 수정한다.
	const editCategory
		= "update category set title=?, act_interval=?, startpage=?, endpage=? where id=?";

	// 카페 정보를 가져온다.
	const getCafeList
		= "select seq, id, title, display_order, category_id, club_id, cre_time from cafe where category_id = ? order by display_order desc, seq desc";

	// seq에 대응되는 카페를 가져온다.
	const getCafeBySeq
		= "select seq, id, title, display_order, category_id, club_id, cre_time from cafe where seq = ?";

	// 카페 정보를 추가한다.
	const addCafe
		= "insert into cafe(category_id, id, title, club_id, display_order, cre_time) values(?, ?, ?, ?, ?, now())";

	// 카페를 삭제한다.
	const deleteCafeBySeq
		= "delete from cafe where seq = ?";

	// 카페 정보를 추가한다. ssssii
	const editCafeBySeq
		= "update cafe set id=?, category_id=?, title=?, club_id=?, display_order=? where seq=?";

	// 저장된 사용자 아이디 수를 구해온다.
	const getUserinfoListCount
		= "select count(1) from userinfo where category_id=?";

	// 추출일자 별 아이디 수를 구해온다.
	const getUserinfoListByDateCount
		= "select count(1) from userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ?";

	// 추출 아이디를 추가한다.
	const addUserinfo
		= "insert into userinfo(id, email, cafe_id, category_id, cre_time) values(?, ?, ?, ?, now())";

	// 아이디를 가져온다.
	const getUserinfoList
		= "select id, email, cafe_id, category_id, cre_time from userinfo where category_id=? order by seq desc limit ?, ?";

	// 아이디 모두를 가져온다.
	const getAllUserinfoList
		= "select id, email, cafe_id, category_id, cre_time from userinfo where category_id=? order by seq desc";

	// 다운로드를 위해 아이디를 가져온다.
	const getAllUserinfoListForDownload
		= "select id, email, cafe_id, category_id, cre_time from userinfo where category_id=? order by seq desc limit 10000";

	// 추출일자 별 모든 아이디를 가져온다.
	const getAllUserinfoListByDate
		= "select id, email, cafe_id, category_id, cre_time from userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ? order by seq desc";

	// 추출일자 별 아이디를 가져온다.
	const getUserinfoListByDate
		= "select id, email, cafe_id, category_id, cre_time from userinfo where category_id=? and DATE_FORMAT(cre_time, '%Y%m%d') BETWEEN ? AND ? order by seq desc limit ?, ?";
}
