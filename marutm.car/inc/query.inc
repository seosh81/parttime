<?php
class query {
	// car_category 정보를 가져온다
	const getCarCategoryList
		= "select seq, name, url, cre_time from car_category order by seq";

	const getCarCategory
		= "select seq, name, url, cre_time from car_category where seq = ?";		

	const addCarCategory
		= "insert into car_category(name, url, cre_time) values(?, ?, now())";

	const editCarCategory
		= "update car_category set name= ? , url = ? where seq = ?";

	const deleteCarCategory
		= "delete from car_category where seq = ?";

	const addCarComment
		= "insert into car_comment(model, comment_no, comment, email, cre_time) values(?, ?, ?, ?, ?)";

	const getCarCommentCount
		= "select count(1) from car_comment where comment_no = ?";

	const getTotalCarCommentCount
	 	= "select count(1) from car_comment";

	const getCarCommentList
		= "select seq, model, comment, email, cre_time from car_comment order by cre_time desc limit ?, ?";

	const getCarCommentMailTarget
		= "select seq, model, comment, email, cre_time from car_comment where cre_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)";

	const addEmail
		= "insert into car_receivemail(email, cre_time) values(?, now())";

	const getEmailList
		= "select seq, email, cre_time from car_receivemail";

	const getEmail
		= "select seq, email, cre_time from car_receivemail where seq = ?";

	const editEmail 
		= "update car_receivemail set email = ? where seq = ?";

	const deleteEmail
		= "delete from car_receivemail where seq = ?";
}