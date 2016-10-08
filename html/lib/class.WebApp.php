<?
/**********************************************
* ���ϸ�: class.WebApp.php
* ��  ��: �����ø����̼� ����Ŭ����
* ��  ¥: 2003-04-08
* �ۼ���: ��ģ����
***********************************************
* 2003-10-07 �̱��� �߰�
* 2003-10-15 confirm �޼ҵ� �߰�
* 2004-01-14 getConf�� ��Ƽȣ��Ʈ������ ����,
*            config �� scope�� �����Ͽ� local �Ǵ� �۷ι� ������ �����ü� ����
* 2004-08-03 call(), get() �޼ҵ� �߰�
*            WebApp_Message Ŭ���� �߰�
* 2004-12-11 getTemplate() �޼ҵ带 Display Ŭ������ ����
*/

class WebApp {

	/**
	* WebAp::import()
	* �������� ����� �ε��Ѵ�.
	* 
	* @param string $module : ���� (class.����.php ���� ����κи�)
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
	* �������� ����� �ε� �� �ν��Ͻ��� �����Ѵ�.
	*
	* @param string $module : ���� (class.����.php ���� ����κи�)
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
	* �� ���ø����̼� ������ ���ɴϴ�.
	* ����array�� ���ϰ�� dot �����ڷ� �����Ͽ� ������ �� �ֽ��ϴ� ex) WebApp::getConf('board.rownum');
	* 
	* @param string $key
	* @return mixed
	*/
	function getConf($key="",$scope='merged') {
		global $HOST;

		global $_CONF;
		$_CONF['global'] = @parse_ini_file("conf/global.conf.php",true);
		$_CONF['local'] = @parse_ini_file("hosts/$HOST/conf/global.conf.php",true);

		$_CONF['merged'] = array_merge($_CONF['global'],$_CONF['local']);	// local ������ global ������ ���!
		if (!$key) return $_CONF[$scope];
		if(strpos($key, ".") > -1) {
			$t = explode(".", $key);
			$v = $_CONF[$scope];
			

			for($z=0,$c=count($t); $z<$c; $z++) {
				$v = $v[$t[$z]];
				if (!$v) {
					$_CONF['global'][$t[$z]] = @parse_ini_file('conf/'.$t[$z].'.conf.php',true);
					$_CONF['local'][$t[$z]] = @parse_ini_file("hosts/$HOST/conf/".$t[$z].'.conf.php',true);
					
					if (!$_CONF['local'][$t[$z]]) unset($_CONF['local'][$t[$z]]);	// ����ִ� ��Į������ �۷ι� ������ ���������� ���� ����
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

	// ������
	function setConf($key,$value='') {
	}

	/**
	* WebApp::mapPath()
	* ��θ� ���� ��� �Ǵ� ����Ʈ ��ο� ���� ������
	* 
	* @param string $path
	* @return string
	* @see asp���� Server.mappath() �޼ҵ�
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
	* ������Ʈ �����
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
	* Ư�� ����� ȣ���Ѵ�
	* 
	* @param string $module  ��⺰��(��Ʈ����)
	* @param dict $param     �Ķ����(key�������� array)
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
	* Ư�� ��⿡�� ���� �޾ƿ´�
	* 
	* @param string $module  ��⺰��(��Ʈ����)
	* @param string $param    ������ ���� �̸�
	*/
	function get($module,$param) {
		$path = 'module/'.str_replace('.','/',$module).'/__get.php';
		return include $path;
	}

	/**
	* WebApp::set()
	* Ư�� ��⿡ ���� �����Ѵ�.
	* 
	* @param string $module  ��⺰��(��Ʈ����)
	* @param string $param   ������ ���� �̸�
	* @param mixed  $data    ������ ���� ����Ÿ
	*/
	function set($module,$param,$data) {
		$path = 'module/'.str_replace('.','/',$module).'/__set.php';
		return include $path;
	}

	//==--------------------------------------------------------------==//
	//==-- ���� �ڵ鷯
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
				//echo "<b>����</b> $errstr $errfile ���� $errline ��° ���ο���<br>";
				break;
			default:
				// skip other errors
		}
	}

	function showErrors() {
	}

	//==--------------------------------------------------------------==//
	//==-- ���â ���, ������ �̵� ����
	//==--------------------------------------------------------------==//

	/**
	* WebApp::alert()
	* �ڹٽ�ũ��Ʈ ���â�� ����Ѵ�.
	* 
	* @param string $msg  ���â���� ����� �޽���
	*/
	function alert($msg) {
		$msg = str_replace(array("\n","'"),array("\\n","\'"),$msg);
		echo '<html><head><meta http-equiv="content-type" content="text/html; charset=euc-kr"></head><body>';
		echo "<script>alert('$msg');</script>";
		echo "</body></html>";
	}

	/**
	* WebApp::confirm()
	* �ڹٽ�ũ��Ʈ ����â�� ����� ������� ������ ���� �ٸ� url�� �����ش�
	* 
	* @param string $msg  �޽���
	* @param string $yes  ����ڰ� 'Ȯ��' ��ư�� �������� �̵��� url
	* @param string $no   ����ڰ� '���' ��ư�� �������� �̵��� url
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
	* �ش� �������� �̵��Ѵ�
	* 
	* @param string $url  �̵��� ������
	* @param string $msg  ���â���� ����� �޽���
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
	* �����丮 �ٷ� �������� �̵��Ѵ�
	* 
	* @param string $msg  ���â���� ����� �޽���
	*/
	function moveBack($msg="") {
		if ($msg) WebApp::alert($msg);
		echo "<script>history.back();</script>";
		exit;
	}

	/**
	* WebApp::halt()
	* ���α׷��� �����Ѵ�.
	* 
	* @param string $msg  ���â���� ����� �޽���
	*/
	function halt($msg='') {
		if ($msg) WebApp::alert($msg);
		exit;
	}

	/**
	* WebApp::closeWin()
	* ���� â�� �ݴ´�
	* 
	* @param boolean $flag �θ�â�� �������� �Ұ��ΰ�
	*/
	function closeWin($flag) {
		if ($flag) echo "<script>opener.location.reload();</script>";
		echo "<script>self.close();</script>";
		exit;
	}


    // ���� �߸��� ( �ѱ��ڸ��Ⱑ ������ �Ǿ� ���� )
    function content_split($str,$len = 4000) {
        $ret = array();
        while ($str) {
            $i = $len - 1;
            while(ord($str{$i}) > 127) {$i--;}  // �ѱ��� �ƴҶ����� ã�´�.
            while($i < ($len - 2)) { $i += 2; } // �ִ���̱��� 2�� ���Ѵ�
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
	* ���ڿ��κ��� Mime �޽����� �о�ͼ� �Ľ̰���� ����
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
	* ���Ϸκ��� Mime �޽����� �о�ͼ� �Ľ̰���� ����
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
