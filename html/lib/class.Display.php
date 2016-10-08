<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/class.Display.php
* 작성일: 2004-07-23
* 작성자: 거친마루
* 설  명: 디스플레이 클래스 (Template_ 확장)
*****************************************************************
* 2004-12-11 getTemplate() 메소드 추가
*/

require_once dirname(__FILE__)."/class.Template_.php";

class Display extends Template_ {
	var $template_dir = '.';
	var $compile_dir = 'cache/template';
	var $cache_dir = 'cache/output';
	var $prefilter = 'emulate_include|adjustPath & .|customtag|webapp';
	var $postfilter = 'arrangeSpace';
    var $html_head = '';
    var $html_body = '';
    var $layout = '';

	function Display() {
		if (func_num_args()) $this->setLayout(func_get_arg());
	}

	function setLayout($conf='default') {
		if ($_GET['ch']) $conf = $_GET['ch'];
		if ($conf{0} == '@') {
			$_file = Display::getTemplate('conf/layout.conf.php');

			$conf = substr($conf,1);
		} else {
			$_file = 'conf/layout.conf.php';
		}
        $this->layout = $conf;
		$layout_conf = @parse_ini_file($_file,true);
		$layers = $layout_conf[$this->layout];
		@array_walk($layers,array(&$this,'cb_apply_theme'));

    if ($this->layout == 'xml') {
			header('Content-Type: text/xml');
			$this->define('LAYOUT','var/layout_blank');
		} elseif ($this->layout == 'frameset' || $this->layout == 'blank') {
			$this->define('LAYOUT','var/layout_blank.htm');
		} elseif ($this->layout == 'default' || !is_file($layers['LAYOUT'])) {
			$this->define('LAYOUT','var/layout_default.htm');
		} else {
			$this->define($layers);
		}
	}

	function define($arg, $path='') {
		if ($path) {
			$path = $this->cb_apply_theme($path);
			$this->_define($arg, $path);
		} else {
			foreach ((array)$arg as $fid => $path) {
				$path = $this->cb_apply_theme($path);
				$this->_define($fid, $path);
			}
		}
	}

	function define_doc($area,$str) {
		$this->define('#'.$area,$str);
	}

	/**
	* WebApp::getTemplate()
	* 템플릿 경로를 리턴한다. (호스트, 테마 기본 디렉토리 반영)
	* 
	* @param string $filename
	* @return string
	*/
	function getTemplate($filename, $THEME = THEME, $HOST = HOST) {

		$tpl_order = array(
			'hosts/'.$HOST.'/'.$filename,
			'theme/'.$THEME.'/'.$filename,
			'html/'.$filename
		);

		for ($i=0,$cnt=count($tpl_order); $i<$cnt;$i++) {
			$template = $tpl_order[$i];
			if (!is_file($template)) continue;
      //echo "<br>template : ".$template."<br>";
			return $template;
			break;
		}
	}

	/**
	* WebApp::array_merge_recursive2()
	* 다차원 배열을 병합한다.
	*/
	function array_merge_recursive2($arr1, $arr2) {
		if (!is_array($arr1) or !is_array($arr2)) return $arr2;
		foreach ($arr2 AS $key2 => $val2) $arr1[$key2] = Display::array_merge_recursive2(@$arr1[$key2], $val2);
		return $arr1;
	}

    /**
	* WebApp::getThemeConf()
	* 테마설정을 가져온다.
	*/
    function getThemeConf($THEME = THEME) {
        static $THEME_CONF;
        if(!defined('THEME')) define('THEME',$THEME);
        if(!$THEME_CONF) {
            $THEME_CONF = parse_ini_file(WebApp::getTemplate('template.conf.php',$THEME),true);

			eval("\$THEME_CONF['attach']['layouts'] = ".$THEME_CONF['attach']['layouts'].';');
            eval("\$THEME_CONF['attach']['layers'] = ".$THEME_CONF['attach']['layers'].';');
            eval("\$THEME_CONF['attach']['manage_files'] = ".$THEME_CONF['attach']['manage_files'].';');
        }
        return $THEME_CONF;
    }

	/**
	* WebApp::getMainConf()
	* 메인페이지에 표시되는 메인 모듈들에 대한 설정을 가져온다
	*/
	function getMainConf($sect = false, $flag = false, $THEME = THEME, $HOST = HOST) {
		static $MAIN_CONF;
		if($flag || !$MAIN_CONF) {
			$MAIN_CONF = @parse_ini_file('theme/'.$THEME.'/conf/main.conf.php',true);
            if (!is_array($local_conf = @parse_ini_file('hosts/'.$HOST.'/conf/main.conf.php',true))) $local_conf = array();
			$MAIN_CONF = Display::array_merge_recursive2($MAIN_CONF,$local_conf);
		}
        
		return ($sect ? $MAIN_CONF[$sect] : $MAIN_CONF);
	}

    /**
	* WebApp::getAttachConf()
	* 메인페이지에 표시되는 모듈들에 대한 배치설정을 가져온다.
	*/
    function getAttachConf($sect = false, $flag = false, $THEME = THEME, $HOST = HOST) {
        static $ATT_CONF;
        if($flag || !$ATT_CONF) {
            $ATT_CONF = @parse_ini_file('theme/'.$THEME.'/conf/attach.conf.php',true);
            if (!is_array($local_conf = @parse_ini_file('hosts/'.$HOST.'/conf/attach.conf.php',true))) $local_conf = array();
            $ATT_CONF = Display::array_merge_recursive2($ATT_CONF,$local_conf);
            foreach($ATT_CONF as $key => $_conf) {
                eval("\$ATT_CONF['$key']['file'] = ".$_conf['file'].';');
                eval("\$ATT_CONF['$key']['avail_layer'] = ".$_conf['avail_layer'].';');
                eval("\$ATT_CONF['$key']['avail_width'] = ".$_conf['avail_width'].';');
            }
        }
        return ($sect ? $ATT_CONF[$sect] : $ATT_CONF);
    }

    function getAttachConf2($sect = false, $flag = false, $THEME = THEME, $HOST = HOST) {
        static $ATT_CONF;
        if($flag || !$ATT_CONF) {
            $ATT_CONF = @parse_ini_file('theme/'.$THEME.'/conf/attach.conf2.php',true);
            if (!is_array($local_conf = @parse_ini_file('hosts/'.$HOST.'/conf/attach.conf.php',true))) $local_conf = array();
            $ATT_CONF = Display::array_merge_recursive2($ATT_CONF,$local_conf);
            foreach($ATT_CONF as $key => $_conf) {
                eval("\$ATT_CONF['$key']['file'] = ".$_conf['file'].';');
                eval("\$ATT_CONF['$key']['avail_layer'] = ".$_conf['avail_layer'].';');
                eval("\$ATT_CONF['$key']['avail_width'] = ".$_conf['avail_width'].';');
            }
        }
        return ($sect ? $ATT_CONF[$sect] : $ATT_CONF);
    }


	function parse($arg,$var='') {	// for 하위호환성 유지 (루프 영역의 데이타를 개별적으로 중첩 assign 한다)
		if (is_array($var)) return $this->assign($arg,$var);
/*
		if (is_array($arg)) $var = array_merge($var=&$this->var_[$this->scp_], $arg);
		else $this->var_[$this->scp_][$arg] = @func_get_arg(1);
*/
	}

    function push_head($str) {
        $this->html_head.= $str."\n";
    }

    function push_body($str) {
        $this->html_body.= $str."\n";
    }

	function printAll() {
		global $REMOTE_ADDR;
		if ($this->tpl_['CONTENT']) {

			if ($GLOBALS['DOC_TITLE']) {
				list($title_type,$title_value) = explode(':',$GLOBALS['DOC_TITLE'],2);
				switch ($title_type) {
				    case 'image':
                        $this->define('#TITLE','<img src="'.$title_value.'">');
                        break;
				    case 'html': case 'file':
                        $this->define('!TITLE',Display::getTemplate($title_value));
                        break;
				    case 'str':
                        $this->define('TITLE', Display::getTemplate('titlebar.htm'));
                        $this->assign('title_text',$title_value);
                        break;
				    case 'raw': default:
                        $this->define('#TITLE',$title_value);
                        break;
				}
			}
            if ($this->html_head || $this->html_body) {
		if($REMOTE_ADDR=="218.37.41.229"){
echo "=======================================01";
		}
                $output = $this->fetch('LAYOUT');
                echo preg_replace(
                    array('@</head@','@</body@'),
                    array($this->html_head.'</head', $this->html_body.'</body'),
                    $output
                );
            } else {
		if($REMOTE_ADDR=="218.37.41.229"){
echo "=======================================02";
		}

				$this->print_('LAYOUT');
            }
		}
	}

	function cb_apply_theme(&$arr) {
		if ($arr{0} == '@') {
			$arr = Display::getTemplate(substr($arr,1));
		}
		return $arr;
	}

 // ------------------------------------------------------------------------------------------------
 // 문자열 자르기 (2Byte문자용)
 // text_cut("원본문자열",짜를길이,"덧붙임글자");
 // (주) 아이노크 김미희
 // ------------------------------------------------------------------------------------------------

 function text_cut($str, $len, $suffix="...") { 
   if ($len >= strlen($str)) return $str;
   $klen = $len - 1;
   while (ord($str{$klen}) & 0x80) $klen--;
   return substr($str, 0, $len - ((($len + $klen) & 1) ^ 1)) . $suffix;
 }


}

?>
