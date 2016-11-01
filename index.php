<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: index.php
* 설  명 : WebApp ASP복합형 V.4.2
* 날  짜 : 2011-10-27
* 개  발 :  now17 김종태 (NOW CMS 4.2)
*****************************************************************
* 
*/


//2011-03-01 종태 변수 감사
function valueGETChk(){
	foreach( $_GET as $val => $value )
	{
			if(strstr($value, "--") || strstr($value, "1=1")   || strstr($value, "a=a")  || strstr($value, "'")  || strstr($value, '"')  || strstr($value, "#")  || strstr($value, "/*")  || strstr($value, "*/") || strstr($value, "UNION")|| strstr($value, ";") || strstr($value ,"<script") || strstr($value ,"/script>") || strstr($value ,"<SCRIPT")|| strstr($value ,"/SCRIPT>") || strstr($value ,"alert(")  ||  strstr($value ,"_NPWVS_") ){
			

			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>계속</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';

			echo '<h1>[경고] 불순한 변수가 포함되었습니다!!</h1>';

			echo "</head><body></body></html>";
			exit;
			 }

	//숫자값 변형 방지 
  if(($val =="def"  || $val =="mcode" || $val =="oid"  || $val =="boid" || $val =="pcode" ||  $val =="cate"  || $val =="ym"  || $val =="page" || $val =="port" || $val=="docPage" || $val=="fcode") && $value !=""){
	     $msgs = intval($value);
		 if($val=='page' && $value==0){
			 $msgs = 1;
		 }
		
		 if($val == "mcode" && $value == "main"){
			 $msgs = 1;
		 }

		if($msgs <=0){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>계속</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';

		 echo '<h5>불순한 url접근입니다..</h5>';

		 echo "</head><body></body></html>";
		 exit;
		 }
	 }
	}
} 

function valuePOSTChk(){
	foreach( $_POST as $val => $value )
	{
			if((strstr($value, "1=1")  && $val == "1")   || strstr($value, "a=a") ||  strstr($value, "UNION") ||  strstr($value, ") or (")   ){
				echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>계속</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';
				echo '<h1>[경고] 불순한 변수가 포함되었습니다!</h1>';
				echo "</head><body></body></html>";
				exit;
			}
	}

} 

//valueGETChk();
valuePOSTChk();



require_once "index_head.php";


$__ = parse_url($REQUEST_URI);

if ($__['scheme']) {    // if uri contains char ':' consider module as 'doc.view'
    $ch = substr($__['scheme'],1);
    $act = 'doc.view';
    $p = $__['path'];
} else {
    $act = substr($__['path'],1);
    if ($act == 'index.php' || !$act) $act = 'main';
    if ($act{0} == '=') {
        $p = substr($act,1);
        $act = 'doc.html';
    }
}


$WEBAPP_PATH = substr($_PARSED_URL['path'],strlen($CONF['system']['install_path']));
define('HUMAN_URI',$CONF['system']['use_webappurl']);

if ($_REQUEST['act']) $act = $_REQUEST['act'];
if ($_REQUEST['p']) $p = $_REQUEST['p'];
if ($_REQUEST['ch']) $ch = $_REQUEST['ch'];

$REQUEST_METHOD = getenv("REQUEST_METHOD");


if(!is_dir("hosts/".$HOST."/tmp")){
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>계속</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';
	echo "<H1>Not Found</H1>The requested URL ".$_SERVER["REDIRECT_URL"]." was not found on this server.";
	echo "</head><body></body></html>";
	exit;
}

if($HOST && is_dir("hosts/".$HOST."/tmp")) {
  session_save_path("hosts/".$HOST."/tmp");
  session_start();
  }

if($_GET[themeset]) {
	$_SESSION[themeset_] = $_GET[themeset];
	setCookie('themeset__',$_GET[themeset],0,'/');
}

if($_GET[baseurl]) {
	$_SESSION[baseurl_] = $_GET[baseurl];
	setCookie('baseurl__',$_GET[baseurl],0,'/');
}



if(preg_match("/MSIE 6.0[0-9]*/", $_SERVER[HTTP_USER_AGENT]))  $ie = 6;
if(preg_match("/MSIE 7.0[0-9]*/", $_SERVER[HTTP_USER_AGENT]))  $ie = 7;
if(preg_match("/MSIE 8.0[0-9]*/", $_SERVER[HTTP_USER_AGENT]))  $ie = 8;
if(preg_match("/MSIE 9.0[0-9]*/", $_SERVER[HTTP_USER_AGENT]))  $ie = 9;

define('_IE', $ie);

define('HOST', $HOST);
define('DOMAIN_', $domain_);


$_path = explode('.',$act);
$_workpath = 'module/';
$_workext = '.php';

if (substr($_path[0],0,1) == '@' && is_dir('hosts/'.$HOST.'/'.$_workpath)) {
	$_workpath = 'hosts/'.$HOST.'/'.$_workpath;
    $_path[0] = substr($_path[0],1);
}


$APPFILE = array_pop($_path).$_workext;
$APPPATH = $_workpath.implode('/',$_path);


ini_alter("include_path","$APPPATH:$APPPATH/lib:./lib:".ini_get("include_path"));
ini_alter("display_errors","on");
ini_alter("magic_quotes_gpc","off");
require_once "class.WebApp.php";
require_once 'config.php';
require_once "lib.gettext.php";



$RUN_MODE = WEBAPP_RUNMODE_GLOBAL;
$pathinfo = explode('/',$APPPATH);


foreach ($pathinfo as $_path) {
    $path.= $_path."/";
    $_common = $path."__init__.php";
    if (is_file($_common)) include $_common;
}
$module = $APPPATH.'/'.$APPFILE;


	foreach( $_GET as $val => $value ){
	if(strstr($val,"sch_")){
		
			if($value !="") $add_where .=  " and ".str_replace("sch_","",$val)." = '$value' ";
		
		$tpl->assign(array($val =>$value));
	}

	if(strstr($val,"like_")){
		
			if($value !="") $add_where .=  " and ".str_replace("like_","",$val)." like '%$value%' ";
		
		$tpl->assign(array($val =>$value));
	}

	if(strstr($val,"in_")){
		
			if($value !="") $add_where .=  " and ".str_replace("in_","",$val)." in ($value) ";
		
		$tpl->assign(array($val =>$value));
	}

	if(strstr($val,"time_s_")){
		
			if($value !="") {
				
				$add_where .=  " and ".str_replace("time_s_","",$val)." >= '".WebApp::mkday($value)."' ";
			}
		
		$tpl->assign(array($val =>$value));
	}

	if(strstr($val,"time_e_")){
	
			if($value !="") {
				$add_where .=  " and ".str_replace("time_e_","",$val)." <= '".WebApp::mkday($value)."' ";
			}
		
		$tpl->assign(array($val =>$value));
	}
	}


require_once "runModule.php";



foreach( $_REQUEST as $val => $value )
{
$tpl->assign(array($val=>$value));

}





$tpl->printAll();



?>