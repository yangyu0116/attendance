<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
/*
	+——————————————————+
	|	全局函数	   |
    +——————————————————+
*/
/*
   | Author: Yang Yu <niceses@gmail.com>              
   | @param   char|int  $start_date 一个有效的日期格式，例如：20091016，2009-10-16   
   | @param   char|int  $end_date  同上              
   | @return  给定日期之间的周末天数  
*/
function get_weekend_days($start_date,$end_date,$is_workday = false){

	 if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
	 $start_reduce = $end_add = 0;
	 $start_N = date('N',strtotime($start_date));
	 $start_reduce = ($start_N == 7) ? 1 : 0;
	 $end_N = date('N',strtotime($end_date));
	 in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;
	 $alldays = abs(strtotime($end_date) - strtotime($start_date))/86400 + 1;
	 $weekend_days = floor(($alldays + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;
	 if ($is_workday){
		$workday_days = $alldays - $weekend_days;
		return $workday_days;
	 }
	 return $weekend_days;
}


//返回星期
function getWeekDay($date) { 
	$date = str_replace('/','-',$date);
	$dateArr = explode("-", $date); 
	return date("N", mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0])); 
}

//输入两个时间戳，计算差值
function hours_min($start_time,$end_time){

	$start_time = ($start_time == '00:00') ? strtotime('+1 day 00:00'): strtotime($start_time);
	$end_time = ($end_time == '00:00') ? strtotime('00:00'): strtotime($end_time);
	if ($end_time > $start_time) list($start_time, $end_time) = array($end_time, $start_time);

	$sec = $start_time - $end_time;
	$sec = round($sec/60);
	$min = str_pad($sec%60, 2, 0, STR_PAD_LEFT);
	$hours_min = floor($sec/60);
	$min != 0  &&  $hours_min .= ':'.$min;
	return $hours_min;
}

//小时计算，输入小时格式为 $hours_min[0] = 1:10;  返回为2小时
function hours_sum($hours_min){ 

	if (!is_array($hours_min))  return false;

	$tmp_arr = array();
	foreach ($hours_min as $v){
			$tmp_arr = explode(':',$v);
			$hour[] = $tmp_arr[0];
			$min[] = $tmp_arr[1];
	}

	$hours = array_sum($hour);
	$mins = array_sum($min);

	$mins = $mins >= 10 ? str_pad($mins, 2, 0, STR_PAD_RIGHT) : $mins;
	$hours += floor($mins/60);
	$hours += $mins%60 >= 30 ? 1 : 0;
	return $hours;
}


//将秒转化成 ** 小时 ** 分
function sec2time($sec){ 

	$sec = round($sec/60);
	if ($sec >= 60){
		$hour = floor($sec/60);
		$min = $sec%60;
		$res = $hour.' 小时 ';
		$min != 0  &&  $res .= $min.' 分';
	}else{
		$res = $sec.' 分钟';
	}
	return $res;
}


function login_info(){
	global $ver,$timestamp;
    if (!$_SESSION["username"]){
        include_once("phpCAS/CAS.php");
		//phpCAS::setDebug();
		phpCAS::client(CAS_VERSION_2_0,'cas.intra.leju.com',443,'');
        phpCAS::setNoCasServerValidation();
        $auth = phpCAS::checkAuthentication();
        if($auth){
            $_SESSION["username"] = phpCAS::getUser();
			if ($_SESSION["username"] != 'yangyu'){
				$contents = 'login time：'.date("Y年m月d日 H:i:s",$timestamp).' - '.$_SESSION["username"]."\r\n";
				writeover('log/'.$ver.'_log.txt',$contents,'a+');		
			}
			header("Location: http://".$_SERVER['SERVER_NAME'].'/'.$_SESSION["username"]);exit;
        }
        else{
            phpCAS::forceAuthentication();
        }
    }
    return $_SESSION;
}

//生成数组变量
function N_var_export($input,$f = 1,$t = null) {
	$output = '';
	if (is_array($input)) {
		$output .= "array(\r\n";
		foreach ($input as $key => $value) {
			$output .= $t."\t".N_var_export($key,$f,$t."\t").' => '.N_var_export($value,$f,$t."\t");
			$output .= ",\r\n";
		}
		$output .= $t.')';
	} elseif (is_string($input)) {
		$output .= $f ? "'".str_replace(array("\\","'"),array("\\\\","\'"),$input)."'" : "'$input'";
	} elseif (is_int($input) || is_double($input)) {
		$output .= "'".(string)$input."'";
	} elseif (is_bool($input)) {
		$output .= $input ? 'true' : 'false';
	} else {
		$output .= 'NULL';
	}
	return $output;
}

//复写文件
function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'..')!==false && exit('Forbidden');
	touch($filename);
	$handle = fopen($filename,$method);
	$iflock && flock($handle,LOCK_EX);
	fwrite($handle,$data);
	$method=="rb+" && ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}

function alert_msg($msg){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312"><script>alert("'.$msg.'");window.location.href="javascript:history.back()";</script>';
	exit();
}

//防注入
function strip_sql($string){
	global $search_arr,$replace_arr;
	return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search_arr, $replace_arr, $string);
}

//执行时间测试
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
}


//过滤搜索关键词
function sql_key($k){
	$k = str_replace(array("%","_"), array("\%","\_"),$k);
    return $k;
}

//插入纯文本到数据库
function input_text($text,$trim=true){
	if ($trim){
		$text = trim($text);
	}
    $text = htmlspecialchars($text);
	return $text;
}

//获取操作系统
function getOS() { 
	$os=""; 
	$Agent = $GLOBALS["HTTP_USER_AGENT"]; 
	if (eregi('win',$Agent) && strpos($Agent, '95')) { 
		$os="Windows 95"; 
	}
	elseif (eregi('win',$Agent) && eregi('nt',$Agent)) { 
		$os="Windows NT"; 
	} 
	elseif (eregi('win',$Agent) && eregi('nt 5\.1',$Agent)) { 
		$os="Windows XP"; 
	} 
	elseif (eregi('win',$Agent) && ereg('32',$Agent)) { 
		$os="Windows 32"; 
	} 
	elseif (eregi('linux',$Agent)) { 
		$os="Linux"; 
	} 
	elseif (eregi('unix',$Agent)) { 
		$os="Unix"; 
	}
	elseif (eregi('Mac',$Agent) && eregi('PC',$Agent)) { 
		$os="Macintosh"; 
	}
	if ($os=='') $os = "Unknown"; 
	return $os; 
} 
