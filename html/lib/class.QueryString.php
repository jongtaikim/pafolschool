<?
/**************************************
* ���ϸ�: class.QueryString.php
* ���: ������Ʈ�� �Ľ�, ����
* �ۼ���: 2003-04-18
* �ۼ���: ��ģ����
***************************************
*/

class QueryString {
	var $vars;

	function QueryString($str="") {
		$_part = parse_url(REQUEST_URI);
		
		if (!$str) $str = $_part['query'];
		$str = ereg_replace('^([^\?]*\?)','',$str);
		
		parse_str($str,$this->vars);
	
	}

	function setVar($key,$val="") {
		if (is_array($key)) {
			$this->vars = array_merge($this->vars,$key);
		
		} else {
			$this->vars[$key] = $val;
		}
		
		return $this->getVar($this->vars);
	}

	function getVar($alter="") {
		if (!$alter) $alter = &$this->vars;
		$buff = array();

		foreach ($alter as $_key=>$_val) if ($_val !== '') $buff[] = "$_key=$_val";
		
	
		return (($qs = implode("&amp;",$buff)) ? "?$qs" : '');
	}

	function alterVar($key,$val="") {
		if (is_array($key)) {
			$alter = array_merge($this->vars,$key);
		} else {
			$alter = $this->vars;
			$alter[$key] = $val;
		}
		return $this->getVar($alter);
	}

	function delVar() {
		$argc = func_num_args();
		$argv = func_get_args();
		for ($i = 0; $i < $argc; $i++) {
			unset($this->vars[$argv[$i]]);
		}
		return $this->getVar();
	}
}

?>
