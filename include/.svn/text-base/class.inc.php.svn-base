<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
/*
	+！！！！！！！！！！！！！！！！！！+
	|	紗墮窃猟周	   |
    +！！！！！！！！！！！！！！！！！！+
*/

function __autoload($class_name) {

	$class_file = ROOT.'/include/'.$class_name.".class.php";
	if ( is_file($class_file) )
        require_once($class_file);
}


/*
//smarty
function &smarty_excel(){
	require_once "smarty.php";
	$obj = new smarty_excel;
	return $obj;
}



//mysql
function &cls_mysql(){
	require_once "mysql.class.php";
	$masterConf['host'] = '127.0.0.1'.':'.'3306';
	$masterConf['user'] = 'root';
	$masterConf['pwd']  = 'root';
	$masterConf['db']   = 'attendence';
	$slaveConf['host']  = '127.0.0.1'.':'.'3306';
	$slaveConf['user']  = 'root';
	$slaveConf['pwd']   = 'root';
	$slaveConf['db']    = 'attendence';
	$obj = new DBCommon($masterConf, $slaveConf);
	return $obj;
}

//cls_excel
function &cls_excel(){
	require_once "excel.class.php";
	$obj = new cls_excel();
	return $obj;
}
*/
?>