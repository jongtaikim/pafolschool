<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/class.HTTP.php
* 작성일: 2004-03-25
* 작성자: 거친마루
* 설  명: HTTP 모듈
*****************************************************************
* 
*/

class HTTP_Request
{
	var $header;
	var $var;
	var $body;
	var $path;

	function HTTP_Request($header='',$body='')
	{
		$this->header = array();
		$this->body = '';
	}

	function setPath($path='/')
	{
		$this->path = $path;
	}

	function setHeader($key,$value='')
	{
		if (is_array($key)) {
			$this->header = array_merge($this->header,$key);
		} else {
			$this->header[$key] = $value;
		}
	}

	function setVar($key,$value='')
	{
		if (is_array($key)) {
			$this->var = @array_merge($this->var,$key);
		} else {
			$this->var[$key] = $value;
		}
	}

	function setBody($msg='')
	{
		$this->body = urlencode($msg);
	}

	function build($method='GET')
	{
		if ($this->header) {
			while (list($_key, $_val) = each($this->header)) {
				$header.= $_key.": ".$_val."\r\n";
			}
		}
		if ($this->var) {
			while (list($_key, $_val) = each($this->var)) {
				$query.= $_key."=".urlencode($_val)."&";
			}
		}
		$body = $this->body;
		if ($query) $body.= (($body) ? $body.'&' : '').substr($query,0,-1);
		else $body = $this->body;

		switch (strtoupper($method)) {
			case "GET":
				$str = "GET ".$this->path.'?'.$query. " HTTP/ 1.0\r\n";
				$str.= $header."\r\n";
				break;
			case "POST":
				$str = "POST ".$this->path." HTTP/ 1.0\r\n";
				$str.= "Content-length: ".strlen($body)."\r\n";
				$str.= $header."\r\n";
				$str.= $body;
				break;
		}
		return $str;
	}
}

class HTTP_Response
{
	var $header;
	var $body;

	function HTTP_Response($header='',$body='')
	{
		$lines = split("\r\n",trim($header));
		if ($lines) {
			$arr = array();
			foreach ($lines as $line) {
				list($key,$value) = explode(':',$line,2);
				$arr[$key] = $value;
			}
		}
		$this->header = $arr;
		$this->body = $body;
	}
}

class HTTP
{
	var $conn;
	var $host;
	var $request;
	var $response;

	function HTTP($oRequest)
	{
		$this->request = $oRequest;
	}

	function Connection($url)
	{
		$_parts = parse_url($url);
		if (!$_parts['port']) $_parts['port'] = 80;
		@parse_str($_parts['query'],$_query);
		$request = new HTTP_Request;
		$request->setHeader('Host', $_parts['host']);
		$request->setPath($_parts['path']);
		$request->setVar($_query);
		$o = new HTTP($request);
		$o->host = $_parts['host'];
		$o->port = $_parts['port'];
		return $o;
	}

	function setHeader($key,$value='') {
		return $this->request->setHeader($key,$value);
	}

	function setVar($key,$value='') {
		return $this->request->setVar($key,$value);
	}

	function setBody($msg='')
	{
		$this->request->setBody($msg);
	}

	function post()
	{
		$this->_connect();
		$this->setHeader('Content-type','application/x-www-form-urlencoded');
		fputs($this->conn,$this->request->build('POST'));
		return $this->result();
	}

	function get()
	{
		$this->_connect();
		fputs($this->conn,$this->request->build('GET'));
		return $this->result();
	}

	function result()
	{
		while(($line = fgets($this->conn,1024)) && trim($line) != "") {
			$header.= $line;
		}

		while(!feof($this->conn)) {
			$body.= fgets($this->conn,1024);
		}

		$this->response = new HTTP_Response($header,$body);
		return $this->response;
		//$this->_close();
	}

	function _connect()
	{
		$fp = fsockopen($this->host, $this->port, &$errno, &$errstr, 10);
		if(!$fp) return $this->setError($this->host."로의 접속에 실패했습니다. $errno, $errstr");
		$this->conn = $fp;
	}

	function reset()
	{
		$this->request = $this->response = null;
	}

	function setError($msg='')
	{
		if ($msg) echo $msg;
		return false;
	}
}

/*
require_once "class.HTTP.php";

$HTTP = HTTP::Connection("http://homepage.com/path/to/file");
$HTTP->setHeader('test','1111');
$HTTP->setVar('aaaa','2222');

$ret = $HTTP->post();

print_r($ret->header);
echo $ret->body;
*/
?>