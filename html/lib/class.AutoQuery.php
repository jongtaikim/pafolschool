<?
/**********************************************
* 파일명: class.AutoQuery.php
* 설  명: 폼값과 테이블 칼럼을 비교하여 자동쿼리를 만들어줌
* 날  짜: 2003-06-20
* 작성자: 거친마루
***********************************************/

class AutoQuery {
	var $sql;
	var $table;
	var $item;
	var $query;
	var $fields;
	var $field_info;
	var $debug;
	
	function AutoQuery($table="") {
		$this->DB = &WebApp::singleton('DB');
		$this->item = array();
		$this->fields = array();
		$this->field_info = array();
		if ($table) $this->setTable($table);
	}

	function setDebug($debug=1) {
		$this->debug = $debug;
	}

	function setTable($table) {
		$this->table = $table;
		$this->fields = $this->field_info = $this->item = array();
		$_fh = mysql_list_fields($this->DB->dbname, $table);
		$_fc = mysql_num_fields($_fh);
		for ($i = 0; $i < $_fc; $i++) {
			$this->fields[] = $field = mysql_field_name($_fh, $i);
			$this->field_info[$field]['type']  = mysql_field_type($_fh, $i);
			$this->field_info[$field]['len']  = mysql_field_len($result, $i);
			$this->field_info[$field]['flags'] = mysql_field_flags($result, $i);
		}

		if ($this->fields) {
			foreach ($this->fields as $field) {
				if ($_REQUEST[$field]) {
					$this->item[$field] = $this->quote($_REQUEST[$field]);
				}
			}
		}
	}

	function insert($data="") {
		if (is_array($data)) {
			foreach ($data as $key=>$val) $this->item[$key] = $this->quote($val);
		}
		if (count($this->item)) {
			$columns = implode(', ',array_keys($this->item));
			$values = implode(', ',array_values($this->item));
			$this->query = "INSERT INTO $this->table ($columns) VALUES ($values)";
			if ($this->debug) echo $this->query."<br>";
			return $this->DB->query($this->query);
		}
	}

	function update($cond,$data="") {
		if (is_array($data)) {
			foreach ($data as $key=>$val) $this->item[$key] = $this->quote($val);
		}
		if (count($this->item)) {
			$item = array();
			foreach ($this->item as $key=>$val) {
				$item[] = $key."=".$this->item[$key];
			}
			$this->query = "UPDATE $this->table SET ".implode(', ',$item)." WHERE $cond";
			if ($this->debug) echo $this->query."<br>";
			return $this->DB->query($this->query);
		}
	}

	function delete($data) {
		if (is_array($data)) {
			foreach ($data as $key=>$val) $this->item[$key] = $this->quote($val);
			$cond = array();
			foreach ($this->item as $key=>$val) {
				$cond[] = $key."=".$this->item[$key];
			}
			$this->query = "DELETE FROM $this->table WHERE ".implode(' OR ',$cond);
			if ($this->debug) echo $this->query."<br>";
			return $this->DB->query($this->query);
		}

	}

	function quote($value) {
//		return (is_numeric($value)) ? $value : "'".$value."'";
		$value = "'".$value."'";
		return $value;
	}

	function reset() {
		unset($this->item,$this->query);
	}

}

?>