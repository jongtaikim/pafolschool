<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-24
* 작성자: 김종태
* 설   명: 환경설정
*****************************************************************
* 
*/

if($_SESSION[themeset_]){
	$THEME = $_SESSION[themeset_];
}else{
	//$THEME = WebApp::getConf('design.theme');
	$THEME = "pafolschool";
}

if($_SERVER[HTTP_HOST] == 'sport.pafolschool.com' || $_SERVER[HTTP_HOST] == 'pafolsports.pafolschool.com'){
	$THEME = "pafolschool_sp";
    header("HTTP/1.0 404 Not Found");

    echo '<meta name="naver-site-verification" content="e371fc7581ed8f80bee6eb24c27ce60e1788804d"/>';
    echo "<h1>페이지를 찾을 수 없습니다.</h1>";
    die();
    exit;
}
define('REQUEST_URI',$REQUEST_URI);
define('REQUEST_METHOD',$REQUEST_METHOD);
define('HOST',$HOST);
define('MODULE',$act);
define('APPFILE',$APPFILE);
define('APPPATH',$APPPATH);

$tlogin_ = "N";
$gpin_ = "N";
if(strstr($_SERVER["HTTP_USER_AGENT"],"Firefox")){
	$tlogin_ = "N";
	$gpin_ = "N";
}
$gpin_ = "N";
define('_T_LOGIN',$tlogin_ ); //통합로그인 여부
define('_GPIN',$gpin_ ); //지핀사용여부



$_OID = WebApp::getConf('oid');
$_ONAME = WebApp::getConf('oname');
$_OPHONE = WebApp::getConf('ophone');
$_EMAIL = WebApp::getConf('email');
$_DOC_ROOT = WebApp::getConf('system.document_root');
//$_FTP = WebApp::getConf('ftp');
$_ID = WebApp::getConf('id');
$_NAVER_API = WebApp::getConf('naver_api');

$_THEME = WebApp::getConf('design');

$_ATTACH = WebApp::getConf('attach_main');
$_CSS = WebApp::getConf('css');
$_FDATA = WebApp::getConf('fdata');
$_LIVE = WebApp::getConf('live');
$_S_TITLE = WebApp::getConf('s_title');
$INFO = WebApp::getConf("database.default");
$_COPY_NO = WebApp::getConf('copy_no');
$_BI_NO = WebApp::getConf('bi_no');
$_JUMIN_NO = WebApp::getConf('jumin_no');
$_QMENU_USE = WebApp::getConf('qmenu_use');
$_POPUP = WebApp::getConf('popup');

$_onlineOffice = WebApp::getConf('onlineOffice');
$_onlinePoll = WebApp::getConf('onlinePoll');
$_onlineForm = WebApp::getConf('onlineForm');
$_onlineVote = WebApp::getConf('onlineVote');
$_onlineAfter = WebApp::getConf('onlineAfter');

define('_onlineOffice', $_onlineOffice); //인터넷교무실 사용여부
define('_onlinePoll', $_onlinePoll); //온라인 설문 사용여부
define('_onlineForm', $_onlineForm); //온라인신청 사용여부
define('_onlineVote', $_onlineVote); //인터넷 투표 사용여부
define('_onlineAfter', $_onlineAfter); //방과후학교 사용여부

define('_AOID', "1"); //인트라넷 OID
define('_AOIDHOST', "center"); //인트라넷 주소
define('_AOIDADMIN', "iadmin"); //인트라넷관리자 가상아이디(쪽지발송)
define('_AOIDADMINNM', "교육청관리자"); //인트라넷관리자 가상아이디(쪽지발송)
define('_AOIDNEWS2', 1210); //인트라넷 정보나눔
define('_AOIDNEWS', 1115); //인트라넷 정보나눔
define('_AOIDAS1', 1113); //인트라넷 작업요청게시판
define('_AOIDAS2', 1211); //긴급공지게시판
define('_AOIDAS3', 1114); // 문의게시판
define('_AOIDAS4', 1116); // FAQ
define('_HELP_URL', "http://center.now17.co.kr/doc.view?mcode=1310"); //메뉴얼사이트
define('_NAVER_API', $_NAVER_API); //메뉴얼사이트

define('_DMBS', $INFO[dmbs]); //디비 타입

define('_COPY_NO', $_COPY_NO); //복사방지
define('_BI_NO', $_BI_NO); //비속어
define('_JUMIN_NO', $_JUMIN_NO); //주민번호방지
define('_QMENU_USE', $_QMENU_USE); //퀵메뉴 사용여부


define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
define('_CSS', $_CSS);

define('_FDATA', $_FDATA);
define('_THEME', $_THEME[theme]);
define('_OID', $_OID);
define('_ONAME', $_ONAME);
define('_OPHONE', $_OPHONE);
define('_EMAIL', $_EMAIL);
define('_DOC_ROOT',$_DOC_ROOT);
define('_ROOT',$_DOC_ROOT);
define('_LINK1',$_LINK1);
define('_LINK2',$_LINK2);
define('_LINK3',$_LINK3);
define('_S_TITLE',$_S_TITLE);
define('_S_TITLE2',$_S_TITLE2);
define('_POPUP_USE',$_POPUP[popup_use]);
define('_DOMAIN',$domain_);
define('_ACT',$act);
define('_ACT2',$act2);

define ('_MODULE', _DOC_ROOT."/lib/ewut_module.php");		// 빈번한 함수 모음

$OFFICE_MCODE = 2;
define('_OFFICE_MCODE',$OFFICE_MCODE);

$OFFSCH_MCODE = 3;
define('_OFFSCH_MCODE',$OFFSCH_MCODE);

$_TITLE = WebApp::getConf('title');

define('THEME', $THEME);
@define('_MCODE',$mcode);
@define('_PCODE',$pcode);
@define('_CATE',$cate);

if($mcode) $_SESSION[doc_mcode] = $mcode;

if($_GET[PageNum]) { $_SESSION[_pn] = $_GET[PageNum];}
@define('_PN',$_SESSION[_pn]);

//define('DEFAULT_FILE_FTP_NUM',WebApp::getConf('system.default_file_ftp_num'));
define('TAB_FILES',WebApp::getConf('system.file_table'));
if (REQUEST_METHOD == 'POST') WebApp::import('Form');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');
set_error_handler(array('WebApp','showError'));



# Function (회사 IP인지 체크)
function check_edumark_ip() {
    static $REMOTE_ADDR;
    if(!$REMOTE_ADDR) $REMOTE_ADDR = getenv('REMOTE_ADDR');

	$except = array('1');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	//if ($ipbase == '125.7.178' && ($iptail >= 1 && $iptail <= 50)) return (!in_array($iptail,$except));
	if (
($ipbase == '203.109.24' && ($iptail >= 1 && $iptail <= 255))
	
	) return (!in_array($itail,$except));
    return false;
}
/*
if(check_edumark_ip()){
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>계속</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';

			echo '<h1>404 Error</h1>';

			echo "</head><body></body></html>";
			exit;
	exit;
}*/
?>