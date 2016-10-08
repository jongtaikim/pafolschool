<?
/**********************************************
* ���ϸ�: class.DB.php
* ��  ��: 
* ��  ¥: 2003-12-02
* �ۼ���: ��ģ����
***********************************************
* 
* 2004-06-09 php 5���� �Ȱ��� �����ϵ��� ���� ���� - ��ģ����
*/
//putenv('NLS_LANG','American_America.KO16KSC5601');
if (!defined('__DB_CLASS')) define(__DB_CLASS,'__DB_CLASS');
if (!defined('DB_CONSTANTS')) {
	define('DB_ASSOC',1);
	define('DB_BOTH',3);
	define('DB_NUM',2);
	define('DB_CONSTANTS',1);
}

class DB {
	var $conn;
	//var $error;
	var $bindObj;
	var $config = array(
		'array_key_case' => CASE_LOWER // BearTemplate ���� �빮�� ������ ���� ������ ��Ī�ϹǷ� �ҹ��ڷ� �޾Ƴ��°��� ȥ������!
	);

	/**
	* <pre>
	* DB Ŭ������ static Ŭ���������� ���� ȣȯ���� ���� �����ڰ� �ִ�.
	* php4�� ��� �ش� db Ŭ������ �ٷ� ����Ǿ� �ڽ��� ��ü�ϰ�, php5�� ��� �޼ҵ� ���� binding �ȴ�.
	* </pre>
	* 
	*/
	function DB($dsn='default') {
		$thisObj = &$this;
		$thisObj = (object)DB::dsn($dsn);
		$this->bindObj = $thisObj;
	}

	function __call($method,$args) {
		if (is_object($this->bindObj)) {
			$_CLASS = $this->bindObj;
			return call_user_func_array(array(&$_CLASS,$method),$args);
		}
	}

	function __get($varname) {
//		return $varname;
		switch ($varname) {
			case 'error':
				return $this->bindObj->error;
		}
	}

	function dsn($conf) {
		$info = WebApp::getConf("database.${conf}");
		$ret = &DB::singleton($info['dbms'],$info['host'],$info['user'],$info['pass'],$info['db']);
		return $ret;
	}

	function Connection($dsn) {
		$info = @parse_url($dsn);
//		$info['db'] = str_replace('/','',$info['path']);
		$info['db'] = substr($info['path'],1);
		$ret = &DB::singleton($info['scheme'],$info['host'],$info['user'],$info['pass'],$info['db']);
		return $ret;
	}


	function &singleton($scheme,$host,$user,$pass,$db) {
		static $instance;
		$signature = serialize(array($scheme, $host, $user, $pass, $db));
		$class = 'DB_'.$scheme;
		if (is_object($instance[$signature])) {
			return $instance[$signature];
		} else {
			require_once dirname(__FILE__)."/DB/$scheme.php";
			$instance[$signature] = &new $class($host,$user,$pass,$db);
			return $instance[$signature];
		}
	}

	//==-- Must override --==//
	//function query($sql) {
	//	return /* result resource */;
	//}

	//function fetch($result=null) {
	//	if ($result == null) $result = &$this->result;
	//}
	//==-- --==//

	function fetchOne($result=null,$offset=0,$length=1) {
		if ($result == null) $result = &$this->result;
		$data = $this->fetch($result);
		if (is_array($data)) $ret = @array_slice($data,$offset,$length);
		else return;
		if (count($ret) < 2) {	// ������� �ϳ��ϰ�� array�� �ƴ� ��Į������..
			$ret = array_values($ret);
			$ret = $ret[0];
		}
		return $ret;
	}

	function fetchAll() {
		$ret = array();
		while ($ret[] = $this->fetch());
		@array_pop($ret);
		return $ret;
	}

	//==-- Automate --==//
	/**
	* @deprecated
	*/
	function sqlQuery($sql) {
		return $this->query($sql);
	}

	function sqlFetch($sql) {
		if ($this->query($sql)) return $this->fetch();
	}

	/**
	* @deprecated
	*/
	function sqlFetchArray($sql) {
		if ($this->query($sql)) return $this->fetch();
	}

	function sqlFetchAll($sql,$mode=DB_ASSOC) {
		if ($this->query($sql)) return $this->fetchAll($mode);
	}

	/**
	* @deprecated
	*/
	function sqlDataArray($sql,$mode=DB_ASSOC) {
		return $this->sqlFetchAll($sql,$mode);
	}

	function sqlFetchOne($sql,$offset=0,$length=1) {
		if ($result = $this->query($sql)) return $this->fetchOne($result,$offset,$length);
	}

	/**
	* @deprecated
	*/
	function sqlResult($sql,$offset=0,$length=1) {
		return $this->sqlFetchOne($sql,$offset,$length);
	}
	//==-- --==//
	// {{{ ���� �ڵ�ȭ
	function insertQuery($table,$data) {
		if (is_array($data)) {
			foreach ($data as $key=>$val) $item[$key] = $this->quote($val);
		}
		if (count($item)) {
			$columns = implode(', ',array_keys($item));
			$values = implode(', ',array_values($item));
			$query = "INSERT INTO $table ($columns) VALUES ($values)";
			//echo $query."<br>";
			return $this->sqlQuery($query);
		}
	}

	function updateQuery($table,$data,$cond) {
		if (is_array($data)) {
			foreach ($data as $key=>$val) $item[$key] = $this->quote($val);
		}
		if (count($item)) {
			$str = array();
			foreach ($item as $key=>$val) {
				$str[] = $key."=".$item[$key];
			}
			$query = "UPDATE $table SET ".implode(', ',$str)." WHERE $cond";
			return $this->sqlQuery($query);
		}
	}

	function quote($value) {
		return "'".$value."'";
	}
	// }}}
}
?>
