<?php
/*
	+！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！+
	|	Add  by yangyu  2008定04埖23晩  yangyu1@staff.sina.com.cn  |
	+！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！+
*/
/*
	+！！！！！！！！！！！！！！！！！！+
	|	巷喘猟周	   |
    +！！！！！！！！！！！！！！！！！！+
*/
if(!defined('CURSCRIPT')) {
	exit('<h1>Access Denied</h1>');
}
define('ROOT', str_replace('\\', '/', realpath(dirname(__FILE__).'/..')));

require_once(ROOT.'/include/dict.php');
require_once(ROOT.'/include/class.inc.php');
require_once(ROOT.'/include/global.func.php');

@ini_set('zend.ze1_compatibility_mode',false);
@ini_set('magic_quotes_runtime',false);
@ini_set('max_execution_time', 60);


/*
	+！！！！！！！！！！！！！！！！！！+
	|	契廣秘		   |
    +！！！！！！！！！！！！！！！！！！+
*/
$search_arr = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
$replace_arr = array(' union ',' select ',' update ',' outfile ',' or ');
$_POST = strip_sql($_POST);
$_GET = strip_sql($_GET);
unset($search_arr, $replace_arr);


/*
	+！！！！！！！！！！！！！！！！！！+
	|勿茅庇噫方怏延楚  |
	+！！！！！！！！！！！！！！！！！！+
*/
foreach(array('_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_value = input_text($_value);
		$_key[0] != '_' && $$_key = addslashes($_value);
	}
}
unset($_REQUEST, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);

//$start_time = getmicrotime();
/*
	+！！！！！！！！！！！！！！！！！！+
	|	柳廬欺萩箔匈中 |
	+！！！！！！！！！！！！！！！！！！+
 */
if ( isset($request_url) ){
	header("Location: ".rawurldecode($request_url));
}


/*
	+！！！！！！！！！！！！！！！！！！+
	|	扮寂漢         |
	+！！！！！！！！！！！！！！！！！！+
*/
$timestamp = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();


/*
	+！！！！！！！！！！！！！！！！！！+
	| 塘崔&糞箭晒db窃  |
	+！！！！！！！！！！！！！！！！！！+
*/
$masterConf['host'] = $slaveConf['host'] = 'localhost:3306';
$masterConf['user'] = $slaveConf['user'] = 'root';
$masterConf['pwd']  = $slaveConf['pwd']  = 'root';
$masterConf['db']   = $slaveConf['db']   = 'attendence';		
$db = new cls_mysql($masterConf,$slaveConf);


/*
	+！！！！！！！！！！！！！！！！！！+
	|  糞箭晒smarty窃  |
	+！！！！！！！！！！！！！！！！！！+
*/
$smarty = new smarty_excel();
?>