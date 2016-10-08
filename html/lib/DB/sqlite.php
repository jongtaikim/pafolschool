<?php
/**********************************************
* ���ϸ�: DB/sqlite.php
* ��  ��: Sqlite DB Ŭ����, WebApp ��
* ��  ¥: 2004-06-22
* �ۼ���: ��ģ���� (comfuture@maniacamp.com) 
***********************************************/

require_once dirname(__FILE__)."/../class.DB.php";

class DB_Sqlite extends DB {

	var $dbname;
	var $result;
	var $config = array(
		'array_key_case'	=>	CASE_LOWER,
		'fetch_mode'		=>	SQLITE_ASSOC
	);

	function DB_Sqlite($host='localhost',$user='',$pass='',$db='') {
		// user, pass�� ������
		if ($host && $db) {
			if (phpversion() > 5) dl('lib/sqlite.so');
			$this->connect($host, $db);
		}
	}

	function connect($host, $db) {
		if(!$this->conn = sqlite_open("$host/$db")) {
			$this->error = "DB Connection Error";
			return false;
		} else {
			return true;
		}
	}

	function query($sql) {
		if ($this->result = @sqlite_query($sql,$this->conn)) {
			return true;
		} else {
			$this->error = @sqlite_error();
			return false;
		}
	}

	function fetch($mode=DB_BOTH) {
		$row = @sqlite_fetch_array($this->result,$mode);
		return @array_change_key_case($row,$this->config['array_key_case']);
	}

	function close() {
		if(@sqlite_close($this->conn)) {
			return;
		}	else {
			return $this->sqlError();
		}
	}

	function sqlError() {
		$this->error = mysql_error();
		return false;
	}
}

?>
