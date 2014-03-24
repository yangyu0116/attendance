<?php
/*
   +----------------------------------------------------------------------+
   | Author: ���� <yangyu1@staff.sina.com.cn>    create@2009-5-18         |
   +----------------------------------------------------------------------+
*/
define('CURSCRIPT', 'index');
require_once('./include/common.php');

/*
	+������������������������������������+
	|	session����    |
	+������������������������������������+
*/
if ( session_id() == '' ) session_start();

/*
	+������������������������������������+
	|	���汾       |
	+������������������������������������+
*/
$ver = $ver ? intval($ver) : VER;

/*
	+������������������������������������+
	|	ʵ����excel��  |
	+������������������������������������+
*/
$cls_excel = new cls_excel();


/*�Ƿ��ǿ�ݷ���*/
if (isset($uname)){

	//δ��¼����ת����ҳ����������url
	if ( !$_SESSION["username"] ){

		header("Location: http://".$_SERVER['SERVER_NAME'].'/index.php?request_url='.rawurlencode($_SERVER['REQUEST_URI']));exit;

	}
	//�ж��Ƿ�Ϊ�����������Ķ���
	if ( strpos($_SERVER['REQUEST_URI'],'?action=toword') !== false ){

		$uname_arr = parse_url($_SERVER['REQUEST_URI']);
		parse_str($uname_arr['query']);
		//eval('$'.$a['query'].';');	//list($action,$action_v) = explode('=',$uname_arr['query']);

	}

	$keywords = $uname;

}else{
	/*
	+������������������������������������+
	|  CAS�û������¼ |
	+������������������������������������+
	*/
	//$userinfo = login_info();
	$_SESSION['username'] = 'yangyu';

}

if ( !$cls_excel->get_name_by_email($_SESSION['username']) ){

	$contents = 'Illegal Access��'.date("Y��m��d�� H:i:s",$timestamp).' - '.$_SESSION["username"]." ���� not tec.dept staff \r\n";
	writeover('log/'.$ver.'_log.txt',$contents,'a+');
	$smarty->display('error.html');exit;
}

//if (in_array($userinfo['username'], $dict_admin)){
//	$keywords = $cls_excel -> get_name_by_email($userinfo['username']);
//	$smarty->assign('not_admin',1);
//}

//Ա����������
if (empty($keywords)){

	if (isset($staffname))  $keywords = rawurldecode($staffname);
	if (isset($staffcode))  $keywords = $staffcode;

}

$keywords = (!is_string($keywords) or $keywords == '������Ա����Ż�����') ? '' : $keywords;

if ($keywords){	

	$res = $cls_excel->get($keywords, $ver);		//����Ա��

}else{

	$filename = ROOT."/cache/cache_all_$ver.php";		 //����Ա��
	$cache_clear = isset($cache_clear) ? $cache_clear : false;

	if ( file_exists($filename) and !$cache_clear ){

		include_once($filename);		//��ȡ�����ļ�

		define(IS_CACHE, true);

	}else{

		$res = $cls_excel->get_all($ver);

		$type = 'all';

	}

}

/*
	+������������������������������������+
	|û�л����ļ���ִ��|
	+������������������������������������+
*/
if ( !IS_CACHE or !defined(IS_CACHE) ){

	$res === false  and  $res = array();

	//$sec = $hour = $min = '';
	$sec += 0;

	for ($i = 0, $count = count($res); $i < $count; $i++){

		if( $dict_holiday[$res[$i]['datetime']] ){		//�ڼ���

			//�򿨼�¼��Ϊͬһʱ���ʱִ�У���ͬ
			if ($res[$i]['get_time'] != $res[$i]['leave_time']){

				$res[$i]['desc'] =  '�ڼ��ռӰ�';
				$res[$i]['weekend'] = $dict_holiday[$res[$i]['datetime']];

				//�ڶ�����ͬһ��Ա���Ĵ򿨼�¼
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//�뿪ʱ����24����ǰ���ҵڶ��쵽��ʱ����6���Ժ�
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						//����ʱ����6����ǰ
					   if (date("G",$res[$i]['get_time']) < 6){

						   	$res[$i]['overtime'] =  '00:00 - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - strtotime('midnight', $res[$i]['get_time']);
					   
					   }else{
						   				
							$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					   
					   }

					//�ڶ��쵽��ʱ����6����ǰ
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['overtime'] = date("H:i",$res[$i]['get_time']).' - 00:00(����)';
						$sec = strtotime('midnight', $res[$i+1]['leave_time']) - $res[$i]['get_time'];

				   }		  

				}else{

					$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
					$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					
				}

				$res[$i]['hours'] = sec2time($sec);

			}

		}else if ( (in_array($res[$i]['weekday'],array(6,7)) or $dict_week_ext[$res[$i]['datetime']]) and !$dict_expt[$res[$i]['datetime']] ){

		//��ĩ����չ��ĩ�����Ҳ������⹤����
			if ($res[$i]['get_time'] != $res[$i]['leave_time']){

				$res[$i]['desc'] =  '˫���ռӰ�';	
				$res[$i]['weekend'] = isset($dict_week_ext[$res[$i]['datetime']]) ? $dict_week_ext[$res[$i]['datetime']] : $dict_week[$res[$i]['weekday']];

				//�ڶ�����ͬһ��Ա���Ĵ򿨼�¼
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//�뿪ʱ����24����ǰ���ҵڶ��쵽��ʱ����6���Ժ�
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						//����ʱ����6����ǰ
					   if (date("G",$res[$i]['get_time']) < 6){

						   	$res[$i]['overtime'] =  '00:00 - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - strtotime('midnight', $res[$i]['get_time']);
					   
					   }else{
						   				
							$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
							$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					   
					   }

					//�ڶ��쵽��ʱ����6����ǰ
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['overtime'] = date("H:i",$res[$i]['get_time']).' - 00:00(����)';
						$sec = strtotime('midnight', $res[$i+1]['leave_time']) - $res[$i]['get_time'];

				   }		  

				}else{

					$res[$i]['overtime'] =  date("H:i",$res[$i]['get_time']).' - '.date("H:i",$res[$i]['leave_time']);
					$sec = $res[$i]['leave_time'] - $res[$i]['get_time'];
					
				}

				$res[$i]['hours'] = sec2time($sec);

			}

		}else {		//������
			//����ʱ����9���Ժ�
			//if (date("G",$res[$i]['get_time']) >= 9 || date("G:i",$res[$i]['get_time']) > '9:00'){
			if (date("G",$res[$i]['get_time']) >= 9){

				if ( in_array($res[$i]['datetime'],$dict_expt_late) and strtotime(date("G:i",$res[$i]['get_time'])) <= strtotime('9:30')){

					$res[$i]['is_late'] = '<span style="text-decoration:line-through;">&nbsp;�ٵ�&nbsp;</span>';

				}else{

					$res[$i]['is_late'] = '�ٵ�';
					//unset($res[$i]['is_late']);
				}
				//��������
				if ($res[$i-1]['staffcode'] === $res[$i]['staffcode'] and date("G",$res[$i-1]['leave_time']) >= 22 and date("G",$res[$i]['get_time']) < 11 and !in_array($res[$i-1]['weekday'],array(6,7))){

					$res[$i]['is_late'] .= '(*)';

				}else if (date("G",$res[$i]['get_time']) >= 10){

					if (in_array($res[$i]['datetime'],$dict_expt_absence)){

						$res[$i]['is_late'] = '<span style="text-decoration:line-through;">&nbsp;����&nbsp;</span>';
					
					}else{

						$res[$i]['is_late'] = '����';
					
					}
				}
			}

			//�뿪ʱ����18����ǰ���ҵڶ���ĵ���ʱ����6���Ժ�
			//if ((date("G",$res[$i]['leave_time']) < 18 || date("G:i",$res[$i]['leave_time']) < '18:00') && !(date("G",$res[$i+1]['get_time'])  < 6)){
			if ((date("G",$res[$i]['leave_time']) < 18) and !(date("G",$res[$i+1]['get_time'])  < 6)){

				if (in_array($res[$i]['datetime'], $dict_expt_early)){

					$res[$i]['is_early'] = '<span style="text-decoration:line-through;">&nbsp;����&nbsp;</span>';

				}else{

					$res[$i]['is_early'] = '����';

				}		
			}

			//�뿪ʱ����20���Ժ���ߵڶ��쵽��ʱ����6����ǰ
			//if (date("G",$res[$i]['leave_time']) >= 20 || date("G:i",$res[$i]['leave_time']) > '20:00' || date("G",$res[$i+1]['get_time'])  < 6){
			if (date("G",$res[$i]['leave_time']) >= 20 or date("G",$res[$i+1]['get_time'])  < 6){

				//�ڶ�����ͬһ��Ա���Ĵ򿨼�¼
				if ($res[$i+1]['staffcode'] == $res[$i]['staffcode']){

					//�뿪ʱ����24����ǰ���ҵڶ��쵽��ʱ����6���Ժ�
				   if (date("G",$res[$i]['leave_time']) <= 23  and  date("G",$res[$i+1]['get_time']) >= 6){

						$res[$i]['desc'] =  '���ϼӰ�';
						$res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i]['leave_time']);


					//�ڶ��쵽��ʱ����6����ǰ
				   }else if(date("G",$res[$i+1]['get_time'])  < 6){

						$res[$i]['desc'] =  '���ϼӰൽ����';
						$res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i+1]['get_time']);

				   }

				//�뿪ʱ����0����ǰ������20���Ժ�
				}else if(date("G",$res[$i]['leave_time']) <= 23 and date("G",$res[$i]['leave_time']) >= 20){	
					
				   $res[$i]['desc'] =  '���ϼӰ�';
				   $res[$i]['overtime'] =  '20:00 - '.date("H:i",$res[$i]['leave_time']);

				}

			}

		}

	}

	//���������Ա��
	if ($type == 'all'){

		$writecache = "\$res = array (\r\n";
		foreach ($res as $value) {
			$writecache .= N_var_export($value).",\r\n";		//������Ҫ���������
		}
		$writecache .= ");\r\n";
		writeover($filename,"<?php\r\n$writecache?>");		//��д���ļ�

	}
}


/*
	+������������������������������������+
	|	���ɼӰ����뵥 |
	+������������������������������������+
*/
if($action == 'toword'){
	
	if (empty($keywords)  ||  $type == 'all'){

		alert_msg('������������Ա����');

	}

	if (getOS() == 'Macintosh'){

		alert_msg('��֧��ƻ��(Mac OS)����ϵͳ��');

	}

	include_once('toword.php');
	exit;
}


if ($keywords){

	//�ٵ����� �����մ�����
	$is_late_num = $attend_num = $no_attend_num = 0;
	foreach ($res as $value){

		if ($value['is_late'] == '�ٵ�')  $is_late_num++;
		if ($value['is_late'] == '����')  $no_attend_num++;

		//if ($value['desc'] != '˫���ռӰ�' && $value['desc'] != '�ڼ��ռӰ�' && $value['get_time'] != $value['leave_time'])  $attend_num++;
		if (!(in_array($value['weekday'],array(6,7)) or $dict_holiday[$value['datetime']] or $dict_week_ext[$value['datetime']]) or $dict_expt[$value['datetime']])  $attend_num++;

		unset($value);

	}

	$all_day = $cls_excel->get_workday($ver, 'workday');

	if ($attend_num >= $all_day){

		$attend_num = 'ȫ�� - '.$all_day.' ��';

	}else{

		$absence = $all_day - $attend_num;
		$attend_num = $attend_num.' ��  &nbsp;&nbsp;ȱϯ��'.$absence.' ��';
		$no_attend_num += $absence;
		//$attend_num = $attend_num.' ��  &nbsp;&nbsp;';

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