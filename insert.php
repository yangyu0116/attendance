<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
/*
	+——————————————————+
	|	新增记录	   |
    +——————————————————+
*/
define('CURSCRIPT', 'insert');
require_once("include/common.php");

//取得cache目录下的csv文件
$fp = opendir('./cache/');    
while( $file = readdir($fp) ){  
    if( strpos($file,'csv') !== false )	$arr_csv[] = $file;     
}

$last_ver = rtrim(array_pop($arr_csv),'.csv');

if ( $last_ver == VER ){
	exit('没有需要更新的记录！');
}

$file_name = ROOT.'/cache/'.$last_ver.'.csv';

$cls_excel = new cls_excel;
$fp = fopen ($file_name,"r"); 
while( ($insert = fgetcsv($fp, 0, ",")) !== FALSE ){

	//$insert = array_map('input_text', $insert);
	$get_timestamp = $insert[2].' '.$insert[3];
	$leave_timestamp = $insert[2].' '.$insert[4];
	$insert[3] = strtotime($get_timestamp);
	$insert[4] = strtotime($leave_timestamp);
	$insert[5] = getWeekDay($insert[2]);
	$insert[6] = $last_ver;

	$cls_excel->insert($insert);
}

$last_ver_workday = get_weekend_days(VER,$last_ver, true);
$cls_excel->insert_ver($last_ver, $last_ver_workday);		

$last_month = substr($last_ver, -4, 2);
$new_dict_ver = array_reverse($dict_ver, TRUE);
$new_dict_ver[$last_ver] = date('m',mktime(0,0,0,$last_month - 1)).'16 - '.$last_month.'15';
$writecache = "define('VER', $last_ver);\r\n\r\n";
$writecache.= "\$dict_ver = ".N_var_export(array_reverse($new_dict_ver,TRUE)).";";
writeover(ROOT.'/include/ver_config.php',"<?php\r\n$writecache\r\n?>");	

echo '数据导入完毕';
?>
