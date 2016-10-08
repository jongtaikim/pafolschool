<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/wrapper.WebApp.php
* 작성일: 2004-09-19
* 작성자: 거친마루
* 설  명: webapp stream wrapper
*****************************************************************
* 
*/

class Stream_WebApp
{
	var $module;
	var $variable;
	var $contents;
	var $position;
	var $stream_is_object = false;

	function stream_open($path, $mode, $option, &$opened_path)
	{
		$url = parse_url($path);
		$this->module = $url['host'];
		$this->variable = $url['path'];
		$this->position = 0;

		if (true === strpos('r',$mode)) {
			if (!is_file('module/'.str_replace('.','/',$this->module).'/__get.php')) return false;
		}
		if (true === strpos('w',$mode)) {
			if (!is_file('module/'.str_replace('.','/',$this->module).'/__set.php')) return false;
		}
		return true;
	}

	function stream_read($length)
	{
		if (!$this->contents) $this->_get_contents();
		if (!$this->stream_is_object) {
			$ret = substr($this->contents, $this->position, $length);
			$this->position += strlen($ret);
			return $ret;
		} else {
		}
	}


	// TODO: data가 string 값이 아닐경우에대한 toString() 및 position 처리
	function stream_write($data)
	{
		if (!$this->contents) $this->_get_contents();
		if (!$this->stream_is_object) {
			$left = substr($this->contents, 0, $this->position);
			$right = substr($this->contents, $this->position + strlen($data));
			$new_contents = $left.$data.$right;
			$this->position += strlen($data);
			return strlen($data);
		} else {
			// TODO: object marshall 처리
		}
	}

	function stream_tell()
	{
		return $this->position;
	}


	function stream_eof()
	{
		return $this->position >= strlen($this->contents);
	}

	function stream_seek($offset, $whence)
	{
		switch ($whence) {
			case SEEK_SET:
				if ($offset < strlen($this->contents) && $offset >= 0) {
					$this->position = $offset;
					return true;
				} else{
					return false;
				}
				break;
			case SEEK_CUR:
				if ($offset >= 0) {
					$this->position += $offset;
					return true;
				} else {
					return false;
				}
				break;
			case SEEK_END:
				if (strlen($this->contents) + $offset >= 0) {
					$this->position = strlen($this->contents) + $offset;
					return true;
				} else {
					return false;
				}
				break;
			default:
				return false;
		}
	}

	function _get_contents()
	{
		$this->contents = WebApp::get($this->module,$this->variable);
		if (!is_string($this->contents)) {
			$this->contents = serialize($this->contents);
			$this->stream_is_object = true;
		}
		return $this->contents;
	}

	function _get_legnth()
	{
	}
}

stream_wrapper_register('webapp','Stream_WebApp') or return WebApp::Error('Failed to register webapp:// protocol');
?>