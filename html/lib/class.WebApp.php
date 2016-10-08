<?
/**********************************************
* 파일명: class.WebApp.php
* 설  명: 웹어플리케이션 수퍼클래스
* 날  짜: 2003-04-08
* 작성자: 거친마루
***********************************************
* 2003-10-07 싱글톤 추가
* 2003-10-15 confirm 메소드 추가
* 2004-01-14 getConf를 멀티호스트용으로 개선,
*            config 의 scope를 조정하여 local 또는 글로벌 설정을 가져올수 있음
* 2004-08-03 call(), get() 메소드 추가
*            WebApp_Message 클래스 추가
* 2004-12-11 getTemplate() 메소드를 Display 클래스에 위임
*/

class WebApp {

	/**
	* WebAp::import()
	* 동적으로 모듈을 로드한다.
	* 
	* @param string $module : 모듈명 (class.모듈명.php 에서 모듈명부분만)
	* @return true
	*/
	function import($module) {
		if (strpos($module,'/')) {
			$_part = explode('.',$module);
			$module = array_pop($_part);
			$path = implode('/',$_part)."/";
		}
		$file = $path."class.$module.php";
		require_once($file);
		return true;
	}

	/**
	* Webapp::init()
	* 동적으로 모듈을 로드 후 인스턴스를 생성한다.
	*
	* @param string $module : 모듈명 (class.모듈명.php 에서 모듈명부분만)
	* @param [mixed $param[, mixed $param[, mixed $param...]]]
	* @return object
	* @deprecated
	*/
	function init($module) {
		$o = &WebApp::singleton($module);
		return $o;
	}

	/**
	* WebApp::getConf() 
	* 웹 어플리케이션 설정을 얻어옵니다.
	* 다중array의 값일경우 dot 연산자로 구분하여 가져올 수 있습니다 ex) WebApp::getConf('board.rownum');
	* 
	* @param string $key
	* @return mixed
	*/
	function getConf($key="",$scope='merged') {
		global $HOST;

		global $_CONF;
		$_CONF['global'] = @parse_ini_file("conf/global.conf.php",true);
		$_CONF['local'] = @parse_ini_file("hosts/$HOST/conf/global.conf.php",true);

		$_CONF['merged'] = array_merge($_CONF['global'],$_CONF['local']);	// local 설정이 global 설정을 덮어씀!
		if (!$key) return $_CONF[$scope];
		if(strpos($key, ".") > -1) {
			$t = explode(".", $key);
			$v = $_CONF[$scope];
			

			for($z=0,$c=count($t); $z<$c; $z++) {
				$v = $v[$t[$z]];
				if (!$v) {
					$_CONF['global'][$t[$z]] = @parse_ini_file('conf/'.$t[$z].'.conf.php',true);
					$_CONF['local'][$t[$z]] = @parse_ini_file("hosts/$HOST/conf/".$t[$z].'.conf.php',true);
					
					if (!$_CONF['local'][$t[$z]]) unset($_CONF['local'][$t[$z]]);	// 비어있는 로칼설정이 글로벌 설정을 지워버리는 오류 보완
					$_CONF['merged'] = array_merge($_CONF['global'],$_CONF['local']);
					$v = $_CONF[$scope][$t[$z]];
					
				}
				if (!$v) return;
			
		
			}
			return $v;
		} else {
			return $_CONF[$scope][$key];
			
		}
	}

	// 개발중
	function setConf($key,$value='') {
	}

	/**
	* WebApp::mapPath()
	* 경로를 현재 경로 또는 웹루트 경로와 매핑 시켜줌
	* 
	* @param string $path
	* @return string
	* @see asp에서 Server.mappath() 메소드
	*/
	function mapPath($path) {
		if (!defined('__PATH__')) define(__PATH__,getenv('SCRIPT_FILENAME'));
		if (strtolower(substr($path,0,7)) == 'http://') return $path;
		$aPath = explode('/',($path[0] == '/') ? getenv('DOCUMENT_ROOT') : dirname(__PATH__));
		$newPath = explode('/',$path);
		for ($i=0,$cnt=count($newPath); $i<$cnt; $i++) {
			if ($newPath[$i] == '..') {
				if (count($aPath)>1) array_pop($aPath);
			} elseif ($newPath[$i] == '' || $newPath[$i] == '.') {
				//forget it
			} else {
				$aPath[] = $newPath[$i];
			}
		}
		return implode('/',$aPath);
	}

	/**
	* WebApp::getTemplate()
	* Alias of Display::getTemplate()
	* 
	* @param string $filename
	* @return string
	*/
	function getTemplate($filename) {
		return Display::getTemplate($filename);
	}

	/**
	* WebApp::singleton()
	* 오브젝트 저장소
	* 
	* @param string $name [,extra params..]
	* @return object ref
	*/
	function &singleton($name) {
		static $jar;
		if (!is_array($jar)) $jar = array();
		if (is_object($jar[$name])) {
			return $jar[$name];
		} else {
			WebApp::import($name);
			$argv = func_get_args();
			unset($argv[0]);
			$jar[$name] = new $name;
			if (is_array($argv) && count($argv)) call_user_func_array(array(&$jar[$name], $name), $argv);
			return $jar[$name];
		}
	}

	/**
	* WebApp::call()
	* 특정 모듈을 호출한다
	* 
	* @param string $module  모듈별명(도트구분)
	* @param dict $param     파라미터(key값을가진 array)
	*/
	function call($module,$param) {
		$RUN_MODE = WEBAPP_RUNMODE_FUNCTION;

		$_apppath = explode('.',$module);
		$__PATH = 'module/';
		foreach ($_apppath as $_path) {
			$__PATH.= $_path."/";
			$_init = $__PATH."__init__.php";
			if (is_file($_init)) include $_init;
			/*
			$_conf = $path."page.conf.php";
			if (is_file($_conf)) {
				$_cfg = @parse_ini_file($_conf,true);
				if ($_cfg['layout']) $ch = $_cfg['layout'];
				@extract($_cfg['phpvars']);
			}
			*/
		}

		$path = 'module/'.str_replace('.','/',$module).'.php';
		if (is_file($path)) {
			include $path;
		} else {
			$parts = explode('.',$module);
			$__METHOD = array_pop($parts);
			$path = 'module/'.implode('/',$parts).'/__call.php';
			include $path;
		}
	}

	/**
	* WebApp::get()
	* 특정 모듈에서 값을 받아온다
	* 
	* @param string $module  모듈별명(도트구분)
	* @param string $param    가져올 값의 이름
	*/
	function get($module,$param) {
		$path = 'module/'.str_replace('.','/',$module).'/__get.php';
		return include $path;
	}

	/**
	* WebApp::set()
	* 특정 모듈에 값을 대입한다.
	* 
	* @param string $module  모듈별명(도트구분)
	* @param string $param   대입할 값의 이름
	* @param mixed  $data    대입할 값의 데이타
	*/
	function set($module,$param,$data) {
		$path = 'module/'.str_replace('.','/',$module).'/__set.php';
		return include $path;
	}

	//==--------------------------------------------------------------==//
	//==-- 에러 핸들러
	//==--------------------------------------------------------------==//

	function warning($str) {
		trigger_error($str,E_USER_WARNING);
	}

	function raiseError($errstr, $errtype=E_USER_WARNING) {
		trigger_error($errstr,$errtype);
	}

	function showError($errno, $errstr, $errfile, $errline, $errcontext) {
		global $tpl;
		switch ($errno) {
			case E_USER_WARNING: case E_USER_NOTICE:
				$tpl->setLayout('blank');
				$tpl->define('CONTENT', Display::getTemplate('error.htm'));
				$tpl->assign('TITLE',_('ERROR'));
				$tpl->assign('message', $errstr);
				$tpl->printAll();
				exit;
				//echo "<b>에라</b> $errstr $errfile 파일 $errline 번째 라인에서<br>";
				break;
			default:
				// skip other errors
		}
	}

	function showErrors() {
	}

	//==--------------------------------------------------------------==//
	//==-- 경고창 출력, 페이지 이동 관련
	//==--------------------------------------------------------------==//

	/**
	* WebApp::alert()
	* 자바스크립트 경고창을 출력한다.
	* 
	* @param string $msg  경고창으로 출력할 메시지
	*/
	function alert($msg) {
		$msg = str_replace(array("\n","'"),array("\\n","\'"),$msg);
		echo '<html><head><meta http-equiv="content-type" content="text/html; charset=euc-kr"></head><body>';
		echo "<script>alert('$msg');</script>";
		echo "</body></html>";
	}

	/**
	* WebApp::confirm()
	* 자바스크립트 선택창을 출력후 사용자의 결정에 따라 다른 url로 보내준다
	* 
	* @param string $msg  메시지
	* @param string $yes  사용자가 '확인' 버튼을 눌렀을때 이동할 url
	* @param string $no   사용자가 '취소' 버튼을 눌렀을때 이동할 url
	*/
	function confirm($msg,$yes,$no) {
		$msg = str_replace(array("\n","'"),array("\\n","\""),$msg);
		echo '<html><head><meta http-equiv="content-type" content="text/html; charset=euc-kr"></head><body>';
		echo "<script>navigate(confirm('$msg') ? '$yes' : '$no');</script>";
		echo "</body></html>";
		exit;
	}

	/**
	* WebApp::redirect()
	* 해당 페이지로 이동한다
	* 
	* @param string $url  이동할 페이지
	* @param string $msg  경고창으로 출력할 메시지
	*/
	function redirect($url,$msg="") {
		if ($msg) WebApp::alert($msg);
//		$url = urlencode($url);
		if (headers_sent()) {
			echo "<script>document.location.replace('$url');</script>";
			exit;
		} else {
			echo "<script>document.location.replace('$url');</script>";
			exit;
		}
	}

	/**
	* WebApp::moveBack()
	* 히스토리 바로 이전으로 이동한다
	* 
	* @param string $msg  경고창으로 출력할 메시지
	*/
	function moveBack($msg="") {
		if ($msg) WebApp::alert($msg);
		echo "<script>history.back();</script>";
		exit;
	}

	/**
	* WebApp::halt()
	* 프로그램을 종료한다.
	* 
	* @param string $msg  경고창으로 출력할 메시지
	*/
	function halt($msg='') {
		if ($msg) WebApp::alert($msg);
		exit;
	}

	/**
	* WebApp::closeWin()
	* 현재 창을 닫는다
	* 
	* @param boolean $flag 부모창을 리프레시 할것인가
	*/
	function closeWin($flag) {
		if ($flag) echo "<script>opener.location.reload();</script>";
		echo "<script>self.close();</script>";
		exit;
	}


    // 문자 잘르기 ( 한글자르기가 문제가 되어 수정 )
    function content_split($str,$len = 4000) {
        $ret = array();
        while ($str) {
            $i = $len - 1;
            while(ord($str{$i}) > 127) {$i--;}  // 한글이 아닐때까지 찾는다.
            while($i < ($len - 2)) { $i += 2; } // 최대길이까지 2씩 더한다
            $ret[] = substr($str,0,$i+1);
            $str = substr($str,$i+1);
        }
        return $ret;
    }
}

/**
* WebApp_Message
* 
* 
*/
class WebApp_Message {
	var $header;
	var $body;

	function WebApp_Message($header=null,$body=null) {
		if ($header != null) $this->header = $header;
		else $this->header = array();

		if ($body != null) $this->body = $body;
	}

	/**
	* static WebApp_Message::fromString(string $str)
	* 문자열로부터 Mime 메시지를 읽어와서 파싱결과를 리턴
	* 
	*/
	function fromString($str) {
		$lines = split("\r?\n",$str);
		while ($line = array_shift($lines)) {
			list($key,$value) = explode(':',$line,2);
			$value = trim($value);
			if (substr($value,0,2) == '=?') {
				$value = WebApp_Message::decode_2047($value);
			}
			$header[$key] = $value;
		}
		$body = implode("\r\n",$lines);
		return new WebApp_Message($header,$body);
	}

	/**
	* static WebApp_Message::fromFile(string $filename)
	* 파일로부터 Mime 메시지를 읽어와서 파싱결과를 리턴
	* 
	*/
	function fromFile($file) {
		$str = file_get_contents($file);
		return WebApp_Message::fromString($str);
	}

	function setHeader($key,$value=null) {
		if (is_array($key) && $value == null) {
			$this->header = $key;
		} else {
			$this->header[$key] = $value;
		}
	}

	function setBody($body) {
		$this->body = $body;
	}

	function __toString() {
		return (string)$this->body;
	}

	function build() {
		foreach ($this->header as $key=>$value) {
			if (preg_match('/[^\x00-\x80]/x',$value)) {
				$value = $this->encode_2047($value);
			}
			$header.= $key.': '.$value."\r\n";
		}
		return $header."\r\n".$this->body;
	}

	function decode_2047($str) {
		if (substr($str,0,2) == '=?') {
			preg_match('/=\?([^\?]+)\?([bq]{1})\?(.*)\?=/i',$str,&$reg);
			/* $reg[1] stands for encoding */
			if ($reg[2] == 'b') $str = base64_decode($reg[3]);
			if ($reg[2] == 'q') $str = urldecode($reg[3]);
		}
		return $str;
	}

	function encode_2047($str,$method='b',$encoding='euc-kr') {
		switch ($method) {
			case 'b': //base64
				$enc = base64_encode($str);
				break;
			case 'q': //urlencode
				$enc = urlencode($str);
				break;
		}
		return '=?'.$encoding.'?'.$method.'?'.$enc.'?=';
	}
}
?>
