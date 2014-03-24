<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
/*
	+——————————————————+
	|	excel类		   |
    +——————————————————+
*/
class cls_excel{
   	var $db;
	//构造函数
	public function __construct() {

		global $db,$dict_holiday;
		$this->_db = $db;
		$this->dict_holiday = $dict_holiday;
	}
	
	//设定当前操作的版本
	public function set_ver($ver){

		$this->ver = $ver;
	}

	//插入新的记录
    public function insert($insert){

		$insert[1] = $this->get_by_code($insert[0]);
		if (empty($insert[1])){
			$insert[1] = $insert[0];
		}

		$sql = "INSERT INTO `attendence` (`staffcode`,`staffname`,`datetime`,`weekday`,`get_time`,`leave_time`,`sheet`) VALUES ('".$insert[0]."','".$insert[1]."','".$insert[2]."','".$insert[5]."','".$insert[3]."','".$insert[4]."','".$insert[6]."') ";
		$this->_db->query($sql);
		return true;
    }

	//插入新的考勤月份
    public function insert_ver($ver, $workday = 22){

		$this->_db->query("INSERT INTO `version` (`ver`,`workday`) VALUES ('".$ver."','".$workday."') ");
		return true;
    }

	//加入新员工
    public function insert_user($code,$name,$email,$duty){

		$this->_db->query("INSERT INTO `book` (`code`,`name`,`email`,`duty`) VALUES ('".$code."','".$name."','".$email."','".$duty."') ");
		$this->_db->query("UPDATE `attendence` SET `staffname`= '".$name."' WHERE `staffcode` = '".$code."' ");
		return true;
    }

	public function get_by_code($code){

		return $this->_db->getOne("SELECT `name` FROM `book` WHERE code='".$code."' ");
    }

	protected function is_username($username){

		if (!is_string($username) || strlen($username) < 2) return false;

		$str_arr = substr($username,0,2);

		if ( ctype_alpha($str_arr{0}) && ctype_alpha($str_arr{1}) ){
			return true;
		}else{
			return false;
		}
	}

	protected function is_email($email){

		$ascii = ord(substr($email,1,1));
		return ($ascii > 96 && $ascii < 123);
	}


	public function get($keywords, $sheet){
		
		$is_email = false;

		if ($this->is_email($keywords)){
			
			$keywords = $this->get_staffcode_by_email($keywords);
			$is_email = true;
		}else if($this->is_username($keywords)){

			$keywords = $this->get_name_by_email($keywords);
		}else{

			$keywords = strtoupper($keywords);
		}

		if (substr($keywords,0,1) == 'F' || $is_email){
			$field = 'staffcode';
		} else{
			$field = 'staffname';
		}

		return $this->_db->getAll("SELECT `staffcode`,`staffname`,`datetime`,`weekday`,`get_time`,`leave_time` FROM `attendence` WHERE $field = '".$keywords."' AND `sheet` = '".$sheet."' ORDER BY `staffcode`,`datetime` ");
	}

	public function get_all($sheet){

		return $this->_db->getAll("SELECT `staffcode`,`staffname`,`datetime`,`weekday`,`get_time`,`leave_time` FROM `attendence` WHERE `sheet` = '".$sheet."' ORDER BY `staffcode`,`datetime` ");
	}

	public function get_workday($sheet, $workdaytype = 'workday'){

		return $this->_db->getOne("SELECT $workdaytype FROM `version`  WHERE ver='".$sheet."' ");
	}

	/*
	public function get_workday($sheet){

		return $this->_db->getOne("SELECT count(*) FROM `attendence` WHERE staffcode='F0283' and weekday not in (6,7) and datetime not in ('".implode("','",array_flip($this->dict_holiday))."') and sheet='".$sheet."' ");
	}
	*/

	public function get_all_users(){

		return $this->_db->getAll("SELECT * FROM `book` ORDER BY `code`");
	}

	public function get_default_ver(){

		return $this->_db->getOne("SELECT `ver` FROM `version` ORDER BY `id` DESC limit 1");
	}

	public function get_staffcode_by_email($email){

		return $this->_db->getOne("SELECT `code` FROM `book` where email = '".$email."' ");
	}

	public function get_name_by_email($email){

		return $this->_db->getOne("SELECT `name` FROM `book` where email = '".$email."' ");
	}

	public function get_duty_by_code($code){

		return $this->_db->getOne("SELECT `duty` FROM `book` where code = '".$code."' ");
	}


}