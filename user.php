<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
/*
	+！！！！！！！！！！！！！！！！！！+
	|	埀垢砿尖	   |
    +！！！！！！！！！！！！！！！！！！+
*/
define('CURSCRIPT', 'user');
require_once("include/common.php");

if ( session_id() == '' ) session_start();

$allow_visit = array('yangyu');
if(!in_array($_SESSION["username"],$allow_visit)) {
	exit('<h1>Access Denied</h1>');
}

$action = isset($action) && in_array($action,array('list','add_form','add','edit','del')) ? $action : 'list';

$cls_excel = new cls_excel();
if ($action == 'list'){

	$user_list = $cls_excel->get_all_users();

	$smarty->assign('user_list', $user_list);
	$smarty->display('user_list.html');

}elseif ($action == 'add_form'){

	$smarty->display('user_add.html');

}elseif ($action == 'add'){

	$cls_excel->insert_user($_POST['code'],$_POST['name'],$_POST['email'],$_POST['duty']);
	echo '<script>alert("耶紗撹孔");window.location.href="javascript:history.back()";</script>';

}elseif ($action == 'edit'){
	
	echo 'not ready yet';
}
elseif ($action == 'del'){

	echo 'not ready yet';
}
?>
