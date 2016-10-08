<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/class.WebForm.php
* 작성일: 2004-11-08
* 작성자: 거친마루
* 설  명: webform 구현 라이브러리
*****************************************************************
* 
*/

// _parse_attr, array2php 함수가 이미 불려와 있음

class WebForm_Parser
{
	var $form_elements;
	var $elements;
	var $content;
	var $stat;
	var $is_multipart = false;

	function WebForm_Parser($str='') {
		$this->form_elements = array(
			'INPUT','BUTTON','SELECT','TEXTAREA'
		);

		//==-- init --==//
		$this->elements = array();
		$this->stat = array();

		$form_elements = implode('|',$this->form_elements);
		$this->content = preg_replace_callback(
            "%<({$form_elements}[^ />]+)( ?[^/>]+)?(?:(?:/>)|>(.*?)</\\1>)%is",
			array(&$this,'cb_webform'),
			$str
		);
	}

	function getContent() {
		return $this->content;
	}

	function getStat() {
		if (count($this->elements)) {
			foreach ($this->elements as $el) {
				$this->stat[] = $el->getInfo();
			}
		}

		$stat_content = serialize($this->stat);
		$hash = md5($stat_content);
		$stat_info = array(
			'__FORM_URL' => $GLOBALS['__html__'],
			'__FORM_KEY' => $hash
		);

		savetofile('cache/dynamic/'.$GLOBALS['__html__'].'/form_'.$hash, $stat_content);
		return '<INPUT type="hidden" name="__FORMSTAT" value="'.base64_encode(serialize($stat_info)).'" />';
	}

	function cb_webform(&$match) {
		$tagName = $match[1];
		$_attr = $match[2];
		$innerHTML = $match[3];
		$attr = _parse_attr($match[2]);

		$this->elements[] = $el = new WebForm_Element($tagName, $attr, $innerHTML);
		if ($el->attr['type'] == 'file') $this->is_multipart = true;
		return $el->getTag();
	}
}


class WebForm_Element
{
	var $tagName;
	var $attr;
	var $innerHTML;

	function WebForm_Element($tagName='',$attr='', $innerHTML='') {
		$this->tagName = strtoupper($tagName);
		$this->attr = $attr;
		$this->innerHTML = $innerHTML;

		if ($this->tagName == 'BUTTON') {
			$this->tagName = 'INPUT';
			$this->attr['type'] = 'button';
			$this->attr['value'] = trim(strip_tags($this->innerHTML));
			$this->innerHTML = '';
		}
	}

	function getTag() {
		return $this->__toString();
	}

	function getInfo() {
		return array(
			'name' => $this->attr['name'],
			'hname' => $this->attr['hname'],
			'required' => $this->attr['required'],
			'option' => explode(' ',$this->attr['option']),
			'pattern' => $this->attr['pattern'],
			'span' => $this->attr['span'],
			'glue' => $this->attr['glue']
		);
	}

	function __toString() {
		$ret = "<".$this->tagName." ".array2param($this->attr);
		if ($this->innerHTML) {
            $ret.= '>';
			$ret.= $this->innerHTML;
			$ret.= "</".$this->tagName.">";
		} else {
			$ret.= '/>';
		}
		return $ret;
	}
}
?>
