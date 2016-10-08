<?
/**
* 파일명: DB/oracle.php
* 설  명: 오라클 DB
* 작성자: 거친마루
* 날  짜: 2004-01-13
*
***********************************************
*/
//$_ENV['NLS_LANG'] = 'American_America.KO16KSC5601';
//putenv('NLS_LANG=American_America.KO16KSC5601');
require_once dirname(__FILE__)."/../class.DB.php";

class DB_Oracle extends DB {

	var $conn;
	var $stmt;
	var $error;
	var $config = array(
		'array_key_case'	=>	CASE_LOWER,	// BearTemplate 에서 대문자 변수는 동적 영역을 지칭하므로 소문자로 받아내는것이 혼동없다!
		'fetch_mode'		=>	OCI_ASSOC	// TODO: fetch_mode 아직 적용 안됨
	);

	function DB_Oracle($host='',$user='',$pass='',$sid='') {
		// XXX : 호스트정보는 버림
		if ($user && $pass && $sid) $this->connect($user,$pass,$sid);
	}

	function connect($user,$pass,$sid) {
		if (!$this->conn) $this->conn = @OciLogon($user,$pass,$sid);
	}
	
	function parse($sql) {
		$this->stmt = @OciParse($this->conn,$sql);
	}

	function exec($mode=OCI_DEFAULT) {
		@OciExecute($this->stmt,$mode);
		if ($this->error = @OciError($this->stmt)) return false;
		return true;
	}

	//==-- OCI specific --==//
	function commit() {
		if (!$this->error) return @OciCommit($this->conn);
	}

	function rollback() {
		return @OciRollback($this->conn);
	}

	function defineByName($val,&$word) {
		@OciDefineByName($this->stmt,$val,&$word);
	}

	function fetchinto(&$row,$mode=OCI_ASSOC) {
		$ret = @OciFetchInto($this->stmt,&$row,$mode);
		$row = @array_change_key_case($row,$this->config['array_key_case']);
		return $ret;
	}

	function fetchstatement(&$results) {
		return @OciFetchStatement($this->stmt,&$resutls);
	}
	
	function bindByName($place_holder,&$var,$length) {
		return @OciBindByName($this->stmt,$place_holder,&$var,$length);
	}
	
	//추후 서브쿼리및...루프 돌릴때....5월 7일 강준철 추가...--;
	//function bindByName1($place_holder,&$var,$length) { 
		//return @OCIBindByName($this->stmt1,$place_holder,$var,$length);
	//}

	function FreeStatement() {
		return @OciFreeStatement($this->stmt);
	}
	//==-- --==//

	function disconnect() {
		if($this->error) {
			@OciRollback($this->conn);
			die("<font color=red>rollback occurrred!!".$this->error["message"]."</font>");
		} else {
			@Ocicommit($this->conn);
		}
		@Ocilogoff($this->conn);
	}

	function query($sql,$mode=OCI_DEFAULT) {
		$this->stmt = @OciParse($this->conn,$sql);
		return @$this->exec($mode);
	}
	// XXX: Warning! OciFetch와 다름.. DB 클래스의 일관성을 유지하기위해 한개 Row 를 return 하는 기능을 한다.
	function fetch($mode=OCI_ASSOC) {
		@OciFetchinto($this->stmt,&$row,$mode);
		return @array_change_key_case($row,$this->config['array_key_case']);
	}
}

?>
