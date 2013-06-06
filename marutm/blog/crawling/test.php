<?php
	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));

	define('_INC_DIR', __DIR__.'/../inc');
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');

	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');

	$idb = new idb();
	$category_list = $idb->select(query::getBlogCategoryList);

	foreach ($category_list as $category) {
		echo $category['act_interval'];
	}