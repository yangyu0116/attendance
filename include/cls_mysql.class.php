<?php
//----------------------------------------------------
//      Master/Slave���ݿ��д�ֿ�������
//
// ������֧������д������һ̨Masterִ�У����ж�������
//         Slaveִ�У������ܹ�֧�ֶ�̨Slave����
//----------------------------------------------------


//������
//$this->db->execute("CREATE TABLE `tbl1` ( `id` INTEGER(11) NOT NULL AUTO_INCREMENT,  `name` CHAR(32) DEFAULT NULL,  `email` CHAR(64) DEFAULT NULL,  PRIMARY KEY (`id`))ENGINE=MyISAM;");
/*
//��ȡӰ������
$s = $this->db->getAffectedRows();
echo $s;

//��ȡ����
$s = $this->db->getAll("select * from tbl1");
print_r($s);

//ѡ���������ݿ�
$this->db->selectDb("test");

//�ر���������
$this->db->disconnect(null, true);
*/
//include_once($_SERVER['DOCUMENT_ROOT'].'/include/memcache5.php');


/**
* ��������
*/
define("_DB_INSERT", 1);
define("_DB_UPDATE", 2);
define("_DB_REPLACE",3);

/**
* cls_mysql class
*
* �������ܹ��ֱ���һ̨Masterд��������̨Slave������
*/
class cls_mysql
{
    /**
     * ���ݿ�������Ϣ
     */
    var $wdbConf = array();
    var $rdbConf = array();
    /**
     * Master���ݿ�����
     */
    var $wdbConn = null;
    /**
     * Slave���ݿ�����
     */
    var $rdbConn = array();
    /**
     * ���ݿ���
     */
    var $dbResult;
    /**
     * ���ݿ��ѯ�����
     */
    var $dbRecord;

    /**
     * SQL���
     */
    var $dbSql;
    /**
     * ���ݿ����
     */
    var $dbCharset = "GBK";
    /**
     * ���ݿ�汾
     */
    var $dbVersion = "4.1";


    /**
     * ��ʼ����ʱ���Ƿ�Ҫ���ӵ����ݿ�
     */
    var $isInitConn = false;
    /**
     * �Ƿ�Ҫ�����ַ���
     */
    var $isCharset = true;
    /**
     * ���ݿ�������ȡ��ʽ
     */
    var $fetchMode = MYSQL_ASSOC;
    /**
     * ִ���з��������Ƿ��¼��־
     */
    var $isLog = true;
    /**
     * �Ƿ��ѯ�����ʱ����ֹ�ű�ִ��
     */
    var $isExit = false;
	/**
     * ִ��SQL����
     */
	var $querynum = 0;



    //------------------------
    //
    //  ������DB����
    //
    //------------------------

    /**
     * ���캯��
     *
     * ����������Ϣ��������Ϣ����ṹ��
     * $masterConf = array(
     *        "host"    => Master���ݿ�������ַ
     *        "user"    => ��¼�û���
     *        "pwd"    => ��¼����
     *        "db"    => Ĭ�����ӵ����ݿ�
     *    );
     * $slaveConf = array(
     *        "host"    => Slave1���ݿ�������ַ|Slave2���ݿ�������ַ|...
     *        "user"    => ��¼�û���
     *        "pwd"    => ��¼����
     *        "db"    => Ĭ�����ӵ����ݿ�
     *    );
     */
    function __construct($masterConf, $slaveConf=array()){
        //�������ݿ�������Ϣ
        if (is_array($masterConf) && !empty($masterConf)){
            $this->wdbConf = $masterConf;
        }
        if (!is_array($slaveConf) || empty($slaveConf)){
            $this->rdbConf = $masterConf;
        } else {
            $this->rdbConf = $slaveConf;
        }
        //��ʼ�����ӣ�һ�㲻�Ƽ���
        if ($this->isInitConn){
            $this->getDbWriteConn();
            $this->getDbReadConn();
        }
		/*
		if (!$this->sina_mc){
            $this->sina_mc=new sina_mc();
        }
		*/
    }

    /**
     * ��ȡMaster��д��������
     */
    function getDbWriteConn(){
        //�ж��Ƿ��Ѿ�����
        if ($this->wdbConn && is_resource($this->wdbConn)) {
            return $this->wdbConn;
        }
        //û�����������д���
        $db = $this->connect($this->wdbConf['host'], $this->wdbConf['user'], $this->wdbConf['pwd'], $this->wdbConf['db']);
        if (!$db || !is_resource($db)) {
            return false;
        }
        $this->wdbConn = $db;
        return $this->wdbConn;
    }

    /**
     * ��ȡSlave�Ķ���������
     */
    function getDbReadConn(){
        //����п��õ�Slave���ӣ������ѡһ̨Slave
        if (is_array($this->rdbConn) && !empty($this->rdbConn)) {
            $key = array_rand($this->rdbConn);
            if (isset($this->rdbConn[$key]) && is_resource($this->rdbConn[$key])) {
                return $this->rdbConn[$key];
            }
        }
        //���ӵ�����Slave���ݿ⣬���û�п��õ�Slave�������Master
        $arrHost = explode("|", $this->rdbConf['host']);
        if (!is_array($arrHost) || empty($arrHost)){
            return $this->getDbWriteConn();
        }
        $this->rdbConn = array();
        foreach($arrHost as $tmpHost){
            $db = $this->connect($tmpHost, $this->rdbConf['user'], $this->rdbConf['pwd'], $this->rdbConf['db']);
            if ($db && is_resource($db)){
                $this->rdbConn[] = $db;
            }
        }
        //���û��һ̨���õ�Slave�����Master
        if (!is_array($this->rdbConn) || empty($this->rdbConn)){
            $this->errorLog("Not availability slave db connection, call master db connection");
            return $this->getDbWriteConn();
        }
        //����������ӵ�Slave����ѡ��һ̨
        $key = array_rand($this->rdbConn);
        if (isset($this->rdbConn[$key])  && is_resource($this->rdbConn[$key])){
            return $this->rdbConn[$key];
        }
        //���ѡ���slave��������Ч�ģ����ҿ��õ�slave��������һ̨��ѭ�������������õ�slave����
        if (count($this->rdbConn) > 1){
            foreach($this->rdbConn as $conn){
                if (is_resource($conn)){
                    return $conn;
                }
            }
        }
        //���û�п��õ�Slave���ӣ������ʹ��Master����
        return $this->getDbWriteConn();
    }

    /**
     * ���ӵ�MySQL���ݿ⹫������
     */
    function connect($dbHost, $dbUser, $dbPasswd, $dbDatabase){
        //�������ݿ�����
        $db = mysql_connect($dbHost, $dbUser, $dbPasswd);
        if (!$db) {
            $this->errorLog("Mysql connect ". $dbHost ." failed");
            return false;
        }
        //ѡ�����ݿ�
        if (!mysql_select_db($dbDatabase, $db)) {
            $this->errorLog("select db $dbDatabase failed", $db);
            return false;
        }
        //�����ַ���
        if ($this->isCharset){
            if ( $this->dbVersion == '' ){
                $res = mysql_query("SELECT VERSION()");
                $this->dbVersion = mysql_result($res, 0);
            }

            if ($this->dbCharset!='' && preg_match("/^(5.|4.1)/", $this->dbVersion)){
                if (mysql_query("SET NAMES '".$this->dbCharset."'", $db) === false){
                    $this->errorLog("Set db_host '$dbHost' charset=". $this->dbCharset ." failed.", $db);
                    return false;
                }
            }
        }
        return $db;
    }

    /**
     * �ر����ݿ�����
     */
    function disconnect($dbConn=null, $closeAll=false){
        //�ر�ָ�����ݿ�����
        if ($dbConn && is_resource($dbConn)){
            mysql_close($dbConn);
            $dbConn = null;
        }
        //�ر��������ݿ�����
        if ($closeAll){
            if ($this->rdbConn && is_resource($this->rdbConn)){
                mysql_close($this->rdbConn);
                $this->rdbConn = null;
            }
            if (is_array($this->rdbConn) && !empty($this->rdbConn)){
                foreach($this->rdbConn as $conn){
                    if ($conn && is_resource($conn)){
                        mysql_close($conn);
                    }
                }
                $this->rdbConn = array();
            }
        }
        return true;
    }

    /**
     * ѡ�����ݿ�
     */
    function selectDb($dbName, $dbConn=null){
        //����ѡ��һ�����ӵ����ݿ�
        if ($dbConn && is_resource($dbConn)){
            if (!mysql_select_db($dbName, $dbConn)){
                $this->errorLog("Select database:$dbName failed.", $dbConn);
                return false;
            }
            return true;
        }
        //����ѡ���������ӵ����ݿ�
        if ($this->wdbConn && is_resource($this->wdbConn)){
            if (!mysql_select_db($dbName, $this->wdbConn)){
                $this->errorLog("Select database:$dbName failed.", $this->wdbConn);
                return false;
            }
        }
        if (is_array($this->rdbConn && !empty($this->rdbConn))){
            foreach($this->rdbConn as $conn){
                if ($conn && is_resource($conn)){
                    if (!mysql_select_db($dbName, $conn)){
                        $this->errorLog("Select database:$dbName failed.", $conn);
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * ִ��SQL��䣨�ײ������
     */
    function query($sql, $isMaster=false){
        if (trim($sql) == ""){
            $this->errorLog("Sql query is empty.");
            return false;
        }
        //��ȡִ��SQL�����ݿ�����
        if (!$isMaster){
            $optType = trim(strtolower(array_shift(explode(" ", ltrim($sql)))));
        }
        if ($isMaster || $optType!="select"){
            $dbConn = $this->getDbWriteConn();
        } else {
            $dbConn = $this->getDbReadConn();
        }
        if (!$dbConn || !is_resource($dbConn)){
            $this->errorLog("Not availability db connection. Query SQL:". $sql);
            if ($this->isExit) {
                exit;
            }
            return false;
        }
		$this->querynum++;
        //ִ�в�ѯ
        $this->dbSql = $sql;
        $this->dbResult = null;
        $this->dbResult = @mysql_query($sql, $dbConn);
        if ($this->dbResult === false){
            $this->errorLog("Query sql failed. SQL:".$sql, $dbConn);
            if ($this->isExit) {
                exit;
            }
            return false;
        }
        return true;
    }

    /**
     * ������־
     */
    function errorLog($msg='', $conn=null){
        if (!$this->isLog){
            return;
        }
        if ($msg=='' && !$conn) {
            return false;
        }
        $log = "MySQL Error: $msg";
        if ($conn && is_resource($conn)) {
            $log .= " mysql_msg:". mysql_error($conn);
        }
        $log .= " [". date("Y-m-d H:i:s") ."]";
        error_log($log);
		echo '<div style="display:none">'.$log.'</div>';
        return true;
    }




    //--------------------------
    //
    //       ���ݻ�ȡ�ӿ�
    //
    //--------------------------
    /**
     * ��ȡSQLִ�е�ȫ�������(��ά����)
     *
     * @param string $sql ��Ҫִ�в�ѯ��SQL���
     * @return �ɹ����ز�ѯ����Ķ�ά����,ʧ�ܷ���false
     */
    function getAll($sql, $isMaster=false){
        if (!$this->query($sql, $isMaster)){
            return false;
        }
        $this->dbRecord = array();
        while ($row = @mysql_fetch_array($this->dbResult, $this->fetchMode)) {
            $this->dbRecord[] = $row;
        }
        @mysql_free_result($this->dbResult);
        if (!is_array($this->dbRecord) || empty($this->dbRecord)){
            return false;
        }
        return $this->dbRecord;
    }





    /**
     * ��ȡ���м�¼(һά����)
     *
     * @param string $sql ��Ҫִ�в�ѯ��SQL���
     * @return �ɹ����ؽ����¼��һά����,ʧ�ܷ���false
     */
    function getRow($sql, $isMaster=false){
        if (!$this->query($sql, $isMaster)){
            return false;
        }
        $this->dbRecord = array();
        $this->dbRecord = @mysql_fetch_array($this->dbResult, $this->fetchMode);
        @mysql_free_result($this->dbResult);
        if (!is_array($this->dbRecord) || empty($this->dbRecord)){
            return false;
        }
        return $this->dbRecord;
    }



    /**
     * ��ȡһ������(һά����)
     *
     * @param string $sql ��Ҫ��ȡ���ַ���
     * @param string $field ��Ҫ��ȡ����,�����ָ��,Ĭ���ǵ�һ��
     * @return �ɹ�������ȡ�Ľ����¼��һά����,ʧ�ܷ���false
     */
    function getCol($sql, $field='', $isMaster=false){
        if (!$this->query($sql, $isMaster)){
            return false;
        }
        $this->dbRecord = array();
        while($row = @mysql_fetch_array($this->dbResult, $this->fetchMode)){
            if (trim($field) == ''){
                $this->dbRecord[] = current($row);
            } else {
                $this->dbRecord[] = $row[$field];
            }
        }
        @mysql_free_result($this->dbResult);
        if (!is_array($this->dbRecord) || empty($this->dbRecord)){
            return false;
        }
        return $this->dbRecord;
    }


    /**
     * ��ȡһ������(��������)
     *
     * @param string $sql ��Ҫִ�в�ѯ��SQL
     * @return �ɹ����ػ�ȡ��һ������,ʧ�ܷ���false
     */
    function getOne($sql, $field='', $isMaster=false){
        if (!$this->query($sql, $isMaster)){
            return false;
        }
        $this->dbRecord = array();
        $row = @mysql_fetch_array($this->dbResult, $this->fetchMode);
        @mysql_free_result($this->dbResult);
        if (!is_array($row) || empty($row)){
            return false;
        }
        if (trim($field) != ''){
            $this->dbRecord = $row[$field];
        }else{
            $this->dbRecord = current($row);
        }
        return $this->dbRecord;
    }




    /**
     * ��ȡָ�����������ļ�¼
     *
     * @param string $table ����(���ʵ����ݱ�)
     * @param string $field �ֶ�(Ҫ��ȡ���ֶ�)
     * @param string $where ����(��ȡ��¼���������,������WHERE,Ĭ��Ϊ��)
     * @param string $order ����(����ʲô�ֶ�����,������ORDER BY,Ĭ��Ϊ��)
     * @param string $limit ���Ƽ�¼(��Ҫ��ȡ���ټ�¼,������LIMIT,Ĭ��Ϊ��)
     * @param bool $single �Ƿ�ֻ��ȡ������¼(�ǵ���getRow����getAll,Ĭ����false,������getAll)
     * @return �ɹ����ؼ�¼�����������,ʧ�ܷ���false
     */
    function getRecord($table, $field='*', $where='', $order='', $limit='', $single=false, $isMaster=false){
        $sql = "SELECT $field FROM $table";
        $sql .= trim($where)!='' ? " WHERE $where " : $where;
        $sql .= trim($order)!='' ? " ORDER BY $order " : $order;
        $sql .= trim($limit)!='' ? " LIMIT $limit " : $limit;
        if ($single){
            return $this->getRow($sql, $isMaster);
        }
        return $this->getAll($sql, $isMaster);
    }

    /**
     * ��ȡָ����������ļ�¼(��getRecored����)
     *
     * @param string $table ����(���ʵ����ݱ�)
     * @param string $field �ֶ�(Ҫ��ȡ���ֶ�)
     * @param string $where ����(��ȡ��¼���������,������WHERE,Ĭ��Ϊ��)
     * @param array $order_arr ��������(��ʽ������: array('id'=>true), ��ô���ǰ���IDΪ˳������, array('id'=>false), ���ǰ���ID��������)
     * @param array $limit_arr ��ȡ���ݵ���������()
     * @return unknown
     */
    function getRecordByWhere($table, $field='*', $where='', $arrOrder=array(), $arrLimit=array(), $isMaster=false){
        $sql = " SELECT $field FROM $table ";
        $sql .= trim($where)!='' ? " WHERE $where " : $where;
        if (is_array($arrOrder) && !empty($arrOrder)){
            $arrKey = key($arrOrder);
            $sql .= " ORDER BY $arrKey " . ($arrOrder[$arrKey] ? "ASC" : "DESC");
        }
        if (is_array($arrLimit) && !empty($arrLimit)){
            $startPos = intval(array_shift($arrLimit));
            $offset = intval(array_shift($arrLimit));
            $sql .= " LIMIT $startPos,$offset ";
        }
        return $this->getAll($sql, $isMaster);
    }

    /**
     * ��ȡָ�������ļ�¼
     *
     * @param string $table ����
     * @param int $startPos ��ʼ��¼
     * @param int $offset ƫ����
     * @param string $field �ֶ���
     * @param string $where ����(��ȡ��¼���������,������WHERE,Ĭ��Ϊ��)
     * @param string $order ����(����ʲô�ֶ�����,������ORDER BY,Ĭ��Ϊ��)
     * @return �ɹ����ذ�����¼�Ķ�ά����,ʧ�ܷ���false
     */
    function getRecordByLimit($table, $startPos, $offset, $field='*', $where='', $oder='', $isMaster=false){
        $sql = " SELECT $field FROM $table ";
        $sql .= trim($where)!='' ? " WHERE $where " : $where;
        $sql .= trim($order)!='' ? " ORDER BY $order " : $order;
        $sql .= " LIMIT $startPos,$offset ";
        return $this->getAll($sql, $isMaster);
    }

    /**
     * ��ȡ�����¼
     *
     * @param string $table ����
     * @param string $orderField ��Ҫ������ֶ�(����id)
     * @param string $orderMethod ����ķ�ʽ(1Ϊ˳��, 2Ϊ����, Ĭ����1)
     * @param string $field ��Ҫ��ȡ���ֶ�(Ĭ����*,���������ֶ�)
     * @param string $where ����(��ȡ��¼���������,������WHERE,Ĭ��Ϊ��)
     * @param string $limit ���Ƽ�¼(��Ҫ��ȡ���ټ�¼,������LIMIT,Ĭ��Ϊ��)
     * @return �ɹ����ؼ�¼�Ķ�ά����,ʧ�ܷ���false
     */
    function getRecordByOrder($table, $orderField, $orderMethod=1, $field='*', $where='', $limit='', $isMaster=false){
        //$order_method��ֵΪ1��Ϊ˳��, $order_methodֵΪ2��2������������
        $sql = " SELECT $field FROM $table ";
        $sql .= trim($where)!='' ? " WHERE $where " : $where;
        $sql .= " ORDER BY $orderField " . ( $orderMethod==1 ? "ASC" : "DESC");
        $sql .= trim($limit)!='' ? " LIMIT $limit " : $limit;
        return $this->getAll($sql, $isMaster);
    }

    /**
     * ��ҳ��ѯ(���Ʋ�ѯ�ļ�¼����)
     *
     * @param string $sql ��Ҫ��ѯ��SQL���
     * @param int $startPos ��ʼ��¼������
     * @param int $offset ÿ�ε�ƫ����,��Ҫ��ȡ������
     * @return �ɹ����ػ�ȡ�����¼�Ķ�ά����,ʧ�ܷ���false
     */
    function limitQuery($sql, $startPos, $offset, $isMaster=false){
        $start_pos = intval($startPos);
        $offset = intval($offset);
        $sql = $sql . " LIMIT $startPos,$offset ";
        return $this->getAll($sql, $isMaster);
    }


    //--------------------------
    //
    //     �����ݷ��ز���
    //
    //--------------------------
    /**
     * ִ��ִ�з�Select��ѯ����
     *
     * @param string $sql ��ѯSQL���
     * @return bool  �ɹ�ִ�з���true, ʧ�ܷ���false
     */
    function execute($sql, $isMaster=false){
        if (!$this->query($sql, $isMaster)){
            return false;
        }
        return true;
//        $count = @mysql_affected_rows($this->dbLink);
//        if ($count <= 0){
//            return false;
//        }
//        return true;
    }

    /**
     * �Զ�ִ�в���(���Insert/Update����)
     *
     * @param string $table ����
     * @param array $field_array �ֶ�����(�����еļ��൱���ֶ���,����ֵ�൱��ֵ, ���� array( 'id' => 100, 'user' => 'heiyeluren')
     * @param int $mode ִ�в�����ģʽ (�ǲ��뻹�Ǹ��²���, 1�ǲ������Insert, 2�Ǹ��²���Update)
     * @param string $where ����Ǹ��²���,�������WHERE������
     * @return bool ִ�гɹ�����true, ʧ�ܷ���false
     */
    function autoExecute($table, $arrField, $mode, $where='', $isMaster=false){
        if ($table=='' || !is_array($arrField) || empty($arrField)){
            return false;
        }
        //$modeΪ1�ǲ������(Insert), $modeΪ2�Ǹ��²���
        if ($mode == 1){
            $sql = " INSERT INTO `$table` SET ";
        } elseif ($mode == 2) {
            $sql = " UPDATE `$table` SET ";
        } elseif ($mode == 3) {
            $sql = " REPLACE INTO `$table` SET  ";
        } else {
            $this->errorLog("Operate type '$mode' is error, in call DB::autoExecute process table $table.");
            return false;
        }
        foreach ($arrField as $key => $value){
            $sql .= "`$key`='$value',";
        }
        $sql = rtrim($sql, ',');
        if ($mode==2 && $where!=''){
            $sql .= "WHERE $where";
        }
        return $this->execute($sql, $isMaster);
    }

    /**
     * �����
     *
     * @param string $tblName ��Ҫ�����������
     * @return mixed �ɹ�����ִ�н����ʧ�ܷ��ش������
     */
    function lockTable($tblName){
        return $this->query("LOCK TABLES $tblName", true);
    }

    /**
     * ����������н���
     *
     * @param string $tblName ��Ҫ�����������
     * @return mixed �ɹ�����ִ�н����ʧ�ܷ��ش������
     */
    function unlockTable($tblName){
        return $this->query("UNLOCK TABLES $tblName", true);
    }

    /**
     * �����Զ��ύģ��ķ�ʽ�����InnoDB�洢���棩
     * һ������ǲ���Ҫʹ������ģʽ�������Զ��ύΪ1�������ܹ����InnoDB�洢�����ִ��Ч�ʣ����������ģʽ����ô��ʹ���Զ��ύΪ0
     *
     * @param bool $autoCommit �����true�����Զ��ύ��ÿ������SQL֮���Զ�ִ�У�ȱʡΪfalse
     * @return mixed �ɹ�����true��ʧ�ܷ��ش������
     */
    function setAutoCommit($autoCommit = false){
        $autoCommit = ( $autoCommit ? 1 : 0 );
        return $this->query("SET AUTOCOMMIT = $autoCommit", true);
    }

    /**
     * ��ʼһ��������̣����InnoDB���棬����ʹ�� BEGIN �� START TRANSACTION��
     *
     * @return mixed �ɹ�����true��ʧ�ܷ��ش������
     */
    function startTransaction(){
        if (!$this->query("BEGIN")){
            return $this->query("START TRANSACTION", true);
        }
    }

    /**
     * �ύһ���������InnoDB�洢���棩
     *
     * @return mixed �ɹ�����true��ʧ�ܷ��ش������
     */
    function commit(){
        if (!$this->query("COMMIT", true)){
            return false;
        }
        return $this->setAutoCommit( true );
    }

    /**
     * �������󣬻��һ���������InnoDB�洢���棩
     *
     * @return mixed �ɹ�����true��ʧ�ܷ��ش������
     */

    function rollback(){
        if (!$this->query("ROLLBACK", true)){
            return false;
        }
        return $this->setAutoCommit( true );
    }


    //--------------------------
    //
    //    ����������ز���
    //
    //--------------------------
    /**
     * ��ȡ���һ�β�ѯ��SQL���
     *
     * @return string �������һ�β�ѯ��SQL���
     */
    function getLastSql(){
        return $this->dbSql;
    }

    /**
     * ��ȡ�ϴβ�������ĵ�ID
     *
     * @return int ���û�����ӻ��߲�ѯʧ��,����0, �ɹ�����ID
     */
    function getLastId(){
        $dbConn = $this->getDbWriteConn();
        if (($lastId = mysql_insert_id($dbConn)) > 0){
            return $lastId;
        }
        return $this->getOne("SELECT LAST_INSERT_ID()", '', true);
    }

    /**
     * ��ȡ��¼������ļ�¼���� (����Select����)
     *
     * @return int �����һ���޽�������߼�¼�����Ϊ��,����0, ���򷵻ؽ��������
     */
    function getNumRows($res=null){
        if (!$res || !is_resource($res)){
            $res = $this->dbResult;
        }
        return mysql_num_rows($res);
    }

    /**
     * ��ȡ�ܵ�Ӱ��ļ�¼���� (����Update/Delete/Insert����)
     *
     * @return int ���û�����ӻ���Ӱ���¼Ϊ��, ���򷵻�Ӱ���������
     */
    function getAffectedRows(){
        $dbConn = $this->getDbWriteConn();
        if ( ($affetedRows = mysql_affected_rows($dbConn)) <= 0){
            return $affetedRows;
        }
        return $this->getOne("SELECT ROW_COUNT()", "", true);
    }

}

