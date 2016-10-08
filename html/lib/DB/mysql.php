<?php
/**********************************************
* 파일명: DB/mysql.php
* 설  명: MySQL DB 클래스, WebApp 용
* 날  짜: 2003-04-18
* 작성자: 거친마루 (comfuture@maniacamp.com) 
* 2003-09-16 config 정보가 없을시에 대한 처리, dsn 지원
* 2004-01-14 dsn 지원 기능을 DB수퍼 클래스로 이전
***********************************************/

require_once dirname(__FILE__)."/../class.DB.php";

class DB_Mysql extends DB {

	var $dbname;
	var $result;
	var $config = array(
		'array_key_case'	=>	CASE_LOWER,
		'fetch_mode'		=>	MYSQL_ASSOC,
		'character_encoding' => 'euckr'
	);

	function DB_Mysql($host='localhost',$user='',$pass='',$db='') {
		if ($host && $user && $db) {
			$this->connect($host,$user,$pass);
			$this->_selectDB($db);
		}
	}

	function connect($host,$user,$pass) {
		if(!$this->conn = mysql_connect($host,$user,$pass)) {
			$this->error = "DB Connection Error";
			return false;
		} else {
			$this->query("set names {$this->config['character_encoding']}");
			return true;
		}
	}

	function _selectDB($dbname='') {
		if ($dbname) $this->dbname = $dbname;
		if(!@mysql_select_db($this->dbname, $this->conn))
			return $this->sqlError();
		else 
			return true;
	}

	function query($sql) {
		if ($this->result = @mysql_query($sql,$this->conn)) {
			return true;
		} else {
			$this->error = @mysql_error();
			return false;
		}
	}

	function fetch($mode=MYSQL_ASSOC) {
		$row = @mysql_fetch_array($this->result,$mode);
		return @array_change_key_case($row,$this->config['array_key_case']);
	}


	function close() {
		if(@mysql_close($this->conn)) {
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
