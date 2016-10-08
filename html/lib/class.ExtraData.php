<?
/**********************************************
* 파일명: class.ExtraData.php
* 설  명: 기본항목외의 정보를 serialize관리
* 날  짜: 2003-06-20
* 작성자: 거친마루
***********************************************/

class ExtraData {
	var $data;

	function ExtraData() {
		$this->data = array();
	}

	function pack() {
		foreach ($_REQUEST as $key=>$val) {
			if ($key[0] == 'x' && $key[1] == '_') {	
				$this->data[$key] = $val;
			}
		}
		return (count($this->data)) ? addslashes(serialize($this->data)) : "";
	}

	function unpack($extra) {
		return unserialize(stripslashes($extra));
	}
}

if ($_SERVER["PATH_TRANSLATED"] == realpath(__FILE__)) {
	$extra = new ExtraData;
	echo $extra->pack();
}
?>