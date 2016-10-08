<?
/**********************************************
* 파일명: class.MiniTemplate.php
* 설  명: dynamic 개념이 없는 가벼운 템플릿
* 날  짜: 2003-02-27
* 작성자: 거친마루
***********************************************/

class MiniTemplate {

	var $src;
	var $arr;
	var $var;
	var $separator;

	function MiniTemplate($filename="") {
		$this->arr = array();
		$this->var = &$GLOBALS;
		$this->separator = array("{", "}");
		if ($filename) $this->define($filename);
	}

	function define($filename) {
		$this->arr = array();
		$this->var = &$GLOBALS;
		$this->src = $this->_getFile($filename);
	}

	function define_doc($str) {
		$this->src = $str;
	}

	function _getFile($filename) {
		if (is_file($filename)) {
			$fp = fopen($filename,"r");
			$src = fread($fp,filesize($filename));
			fclose($fp);
			while(is_long($pos = strpos($buffer, "<!-- INCLUDE FILE '", $pos_offset))) { 
				$pos += 19; 
				$endpos = strpos($buffer, "' -->", $pos); 
				$filename = substr($buffer, $pos, $endpos-$pos);
				$tag = "<!-- INCLUDE FILE '".$filename."' -->"; 
				$fsize = filesize($filename);
				$pos_offset = $pos + $fsize - 19;
				$src = str_replace($tag, $this->_getFile($filename), $this->src);
			}
			return $src;
		} else {
			die("Warning");
		}
	}

	function assign($key,$value="") {
		if (is_array($key)) $this->var = array_merge($this->var,$key);
		else $this->var[$key] = $value;
	}

	function parse() {
		$this->arr = split(implode("|",$this->separator),$this->src);
		for ($i=1,$cnt=count($this->arr); $i<$cnt; $i+=2) {
			$this->arr[$i] = $this->var[$this->arr[$i]];
		}
	}

	function fetch() {
		return (implode("",$this->arr));
	}

	function tprint() {
		echo $this->fetch();
	}

	function free() {
		$this->arr = array();
		$this->var = &$GLOBALS;
	}
}
?>