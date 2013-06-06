<?php
	if ( !defined('__DIR__')) define('__DIR__', dirname(__FILE__));
	define('E_USER_DEBUG', 99999);
	define('_DEBUG_MODE', 'debug');

	define('_DOMAIN_INFO', 'http://' . $_SERVER['SERVER_NAME']);
	define('_CONTEXT_PATH', '/parttime/marutm.blog');
	define('_APP_ROOT_PATH', _DOMAIN_INFO._CONTEXT_PATH);
	define('_JS_PATH', _DOMAIN_INFO._CONTEXT_PATH.'/assets/js');
	define('_CSS_PATH', _DOMAIN_INFO._CONTEXT_PATH.'/assets/css');

	define('_ASSETS_DIR', __DIR__.'/../assets');
	define('_INC_DIR', __DIR__);
	define('_CONF_DIR', __DIR__.'/../conf');
	
	define('_DB_CONF_FILE', _CONF_DIR.'/db.ini');
	// define('_LOG_FILE', '/Users/seosh81/project/marutm/log/marutm.log');

	// require_once(_INC_DIR.'/logger.inc');
	require_once(_INC_DIR.'/query.inc');
	require_once(_INC_DIR.'/idb.inc');
?>
