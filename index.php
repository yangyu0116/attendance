<?php
/*
   +----------------------------------------------------------------------+
   | Author: 杨宇 <yangyu1@staff.sina.com.cn>    create@2009-5-18         |
   +----------------------------------------------------------------------+
*/
define('CURSCRIPT', 'index');
require_once('./include/common.php');

/*
	+——————————————————+
	|	session开启    |
	+——————————————————+
*/
if ( session_id() == '' ) session_start();

/*
	+——————————————————+
	|	表格版本       |
	+——————————————————+
*/
$ver = $ver ? intval($ver) : VER;

/*
	+——————————————————+
	|	实例化excel类  |
	+——————————————————+
*/
$cls_excel = new cls_excel();


/*是否是快捷访问*/
if (isset($uname)){

	//未登录则跳转到首页并附带请求url
	if ( !$_SESSION["username"] ){

		header("Location: http://".$_SERVER['SERVER_NAME'].'/index.php?request_url='.rawurlencode($_SERVER['REQUEST_URI']));exit;

	}
	//判断是否为生成审批单的动作
	if ( strpos($_SERVER['REQUEST_URI'],'?action=toword') !== false ){

		$uname_arr = parse_url($_SERVER['REQUEST_URI']);
		parse_str($uname_arr['query']);
		//eval('$'.$a['query'].';');	//list($action,$action_v) = explode('=',$uname_arr['query']);

	}

	$keywords = $uname;

}else{
	/*
	+——————————————————+
	|  CAS用户单点登录 |
	+——————————————————+
	*/
	//$userinfo = login_info();
	$_SESSION['username'] = 'yangyu';

}

if ( !$cls_excel->get_name_by_email($_SESSION['username']) ){

	$contents = 'Illegal Access：'.date("Y年m月d日 H:i:s",$timestamp).' - '.$_SESSION["username"]." —— not tec.dept staff \r\n";
	writeover('log/'.$ver.'_log.txt',$contents,'a+');
	$smarty->display('error.html');exit;
}

//if (in_array($userinfo['username'], $dict_admin)){
//	$keywords = $cls_excel -> get_name_by_email($userinfo['username']);
//	$smarty->assign('not_admin',1);
//}

//员工姓名或编号
if (empty($keywords)){

	if (isset($staffname))  $keywords = rawurldecode($staffname);
	if (isset($staffcode))  $keywords = $staffcode;

}

$keywords = (!is_string($keywords) or $keywords == '请输入员工编号或姓名') ? '' : $keywords;

if ($keywords){	

	$res = $cls_excel->get($keywords, $ver);		//单个员工

}else{

	$filename = ROOT."/cache/cache_all_$ver.php";		 //所有员工
	$cache_clear = isset($cache_clear) ? $cache_clear : false;

	if ( file_exists($filename) and !$cache_clear ){

		include_once($filename);		//读取缓存文件

		define(IS_CACHE, true);

	}else{

		$res = $cls_excel->get_all($ver);

		$type = 'all';

	}

}

/*
	+——————————————————+
	|没有缓存文件则执行|
	+——————————————————+
*/
if ( !IS_CACHE or !defined(IS_CACHE) ){

	$res === false  and  $res = array();

	//$sec = $hour = $min = '';
	$sec += 0;

	for ($i = 0, $count = count($res); $i < $count; $i++){

		if( $dict_holiday[$res[$i]['datetime']] ){		//节假日

			//打卡记录不为同一时间点时执行，下同
			if ($res[$i]['get_time'] != $res[$i]['leave_time']){

				$res[$i]['desc'] =  '节假日加班';
				$res[$i]['weekend'] = $dict_holiday[$res[$i]['datetime']];

				//第二天有同一个员工的打卡记录
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//离开时间在24点以前并且第二天到达时间在6点以后
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						//到达时间在6点以前
					   if (date("G",$res[$i]['get_time']) < 6){

						   	$res[$i]['overtime'] =  '00:00 - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - strtotime('midnight', $res[$i]['get_time']);
					   
					   }else{
						   				
							$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					   
					   }

					//第二天到达时间在6点以前
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['overtime'] = date("H:i",$res[$i]['get_time']).' - 00:00(翌日)';
						$sec = strtotime('midnight', $res[$i+1]['leave_time']) - $res[$i]['get_time'];

				   }		  

				}else{

					$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
					$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					
				}

				$res[$i]['hours'] = sec2time($sec);

			}

		}else if ( (in_array($res[$i]['weekday'],array(6,7)) or $dict_week_ext[$res[$i]['datetime']]) and !$dict_expt[$res[$i]['datetime']] ){

		//周末或扩展周末，并且不是例外工作日
			if ($res[$i]['get_time'] != $res[$i]['leave_time']){

				$res[$i]['desc'] =  '双休日加班';	
				$res[$i]['weekend'] = isset($dict_week_ext[$res[$i]['datetime']]) ? $dict_week_ext[$res[$i]['datetime']] : $dict_week[$res[$i]['weekday']];

				//第二天有同一个员工的打卡记录
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//离开时间在24点以前并且第二天到达时间在6点以后
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						//到达时间在6点以前
					   if (date("G",$res[$i]['get_time']) < 6){

						   	$res[$i]['overtime'] =  '00:00 - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - strtotime('midnight', $res[$i]['get_time']);
					   
					   }else{
						   				
							$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					   
					   }

					//第二天到达时间在6点以前
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['overtime'] = date("H:i",$res[$i]['get_time']).' - 00:00(翌日)';
						$sec = strtotime('midnight', $res[$i+1]['leave_time']) - $res[$i]['get_time'];

				   }		  

				}else{

					$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
					$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					
				}

				$res[$i]['hours'] = sec2time($sec);

			}

		}else {		//工作日
			//到达时间在9点以后
			//if (date("G",$res[$i]['get_time']) >= 9 || date("G:i",$res[$i]['get_time']) > '9:00'){
			if (date("G",$res[$i]['get_time']) >= 9){

				if ( in_array($res[$i]['datetime'],$dict_expt_late) and strtotime(date("G:i",$res[$i]['get_time'])) <= strtotime('9:30')){

					$res[$i]['is_late'] = '<span style="text-decoration:line-through;">&nbsp;迟到&nbsp;</span>';

				}else{

					$res[$i]['is_late'] = '迟到';
					//unset($res[$i]['is_late']);
				}
				//倒休条件
				if ($res[$i-1]['staffcode'] === $res[$i]['staffcode'] and date("G",$res[$i-1]['leave_time']) >= 22 and date("G",$res[$i]['get_time']) < 11 and !in_array($res[$i-1]['weekday'],array(6,7))){

					$res[$i]['is_late'] .= '(*)';

				}else if (date("G",$res[$i]['get_time']) >= 10){

					if (in_array($res[$i]['datetime'],$dict_expt_absence)){

						$res[$i]['is_late'] = '<span style="text-decoration:line-through;">&nbsp;补假&nbsp;</span>';
					
					}else{

						$res[$i]['is_late'] = '补假';
					
					}
				}
			}

			//离开时间在18点以前并且第二天的到达时间在6点以后
			//if ((date("G",$res[$i]['leave_time']) < 18 || date("G:i",$res[$i]['leave_time']) < '18:00') && !(date("G",$res[$i+1]['get_time'])  < 6)){
			if ((date("G",$res[$i]['leave_time']) < 18) and !(date("G",$res[$i+1]['get_time'])  < 6)){

				if (in_array($res[$i]['datetime'], $dict_expt_early)){

					$res[$i]['is_early'] = '<span style="text-decoration:line-through;">&nbsp;早退&nbsp;</span>';

				}else{

					$res[$i]['is_early'] = '早退';

				}		
			}

			//离开时间在20点以后或者第二天到达时间在6点以前
			//if (date("G",$res[$i]['leave_time']) >= 20 || date("G:i",$res[$i]['leave_time']) > '20:00' || date("G",$res[$i+1]['get_time'])  < 6){
			if (date("G",$res[$i]['leave_time']) >= 20 or date("G",$res[$i+1]['get_time'])  < 6){

				//第二天有同一个员工的打卡记录
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//离开时间在24点以前并且第二天到达时间在6点以后
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						$res[$i]['desc'] =  '晚上加班';
						$res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i]['leave_time']);


					//第二天到达时间在6点以前
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['desc'] =  '晚上加班到翌日';
						$res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i+1]['get_time']);

				   }

				//离开时间在0点以前并且在20点以后
				}else if(date("G",$res[$i]['leave_time']) <= 23 and date("G",$res[$i]['leave_time']) >= 20){	
					
				   $res[$i]['desc'] =  '晚上加班';
				   $res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i]['leave_time']);

				}

			}

		}

	}

	//如果是所有员工
	if ($type == 'all'){

		$writecache = "\$res = array (\r\n";
		foreach ($res as $value) {
			$writecache .= N_var_export($value).",\r\n";		//生成需要缓存的数组
		}
		$writecache .= ");\r\n";
		writeover($filename,"<?php\r\n$writecache?>");		//覆写进文件

	}
}


/*
	+——————————————————+
	|	生成加班申请单 |
	+——————————————————+
*/
if($action == 'toword'){
	
	if (empty($keywords)  ||  $type == 'all'){

		alert_msg('请先搜索单个员工！');

	}

	if (getOS() == 'Macintosh'){

		alert_msg('不支持苹果(Mac OS)操作系统！');

	}

	include_once('toword.php');
	exit;
}


if ($keywords){

	//迟到天数 工作日打卡天数
	$is_late_num = $attend_num = $no_attend_num = 0;
	foreach ($res as $value){

		if ($value['is_late'] == '迟到')  $is_late_num++;
		if ($value['is_late'] == '补假')  $no_attend_num++;

		//if ($value['desc'] != '双休日加班' && $value['desc'] != '节假日加班' && $value['get_time'] != $value['leave_time'])  $attend_num++;
		if (!(in_array($value['weekday'],array(6,7)) or $dict_holiday[$value['datetime']] or $dict_week_ext[$value['datetime']]) or $dict_expt[$value['datetime']])  $attend_num++;

		unset($value);

	}

	$all_day = $cls_excel->get_workday($ver, 'workday');

	if ($attend_num >= $all_day){

		$attend_num = '全勤 - '.$all_day.' 天';

	}else{

		$absence = $all_day - $attend_num;
		$attend_num = $attend_num.' 天  &nbsp;&nbsp;缺席：'.$absence.' 天';
		$no_attend_num += $absence;
		//$attend_num = $attend_num.' 天  &nbsp;&nbsp;';

	}
	$smarty->assign('attend_num',$attend_num);
	$smarty->assign('is_late_num',$is_late_num);
	$smarty->assign('no_attend_num',$no_attend_num);
}


//$end_time = getmicrotime();
//$execute_time = $end_time - $start_time;

$smarty->assign(array(
	'ver' => $ver,
	'ver_info' => $dict_ver,
	'res' => $res,
	'keywords' => $keywords,
	'dict_week' => $dict_week,
	'dict_css' => $dict_css,
));

$smarty->display('index.html');
?>