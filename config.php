<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-24
* �ۼ���: ������
* ��   ��: ȯ�漳��
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
    echo "<h1>�������� ã�� �� �����ϴ�.</h1>";
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
define('_T_LOGIN',$tlogin_ ); //���շα��� ����
define('_GPIN',$gpin_ ); //���ɻ�뿩��



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

define('_onlineOffice', $_onlineOffice); //���ͳݱ����� ��뿩��
define('_onlinePoll', $_onlinePoll); //�¶��� ���� ��뿩��
define('_onlineForm', $_onlineForm); //�¶��ν�û ��뿩��
define('_onlineVote', $_onlineVote); //���ͳ� ��ǥ ��뿩��
define('_onlineAfter', $_onlineAfter); //������б� ��뿩��

define('_AOID', "1"); //��Ʈ��� OID
define('_AOIDHOST', "center"); //��Ʈ��� �ּ�
define('_AOIDADMIN', "iadmin"); //��Ʈ��ݰ����� ������̵�(�����߼�)
define('_AOIDADMINNM', "����û������"); //��Ʈ��ݰ����� ������̵�(�����߼�)
define('_AOIDNEWS2', 1210); //��Ʈ��� ��������
define('_AOIDNEWS', 1115); //��Ʈ��� ��������
define('_AOIDAS1', 1113); //��Ʈ��� �۾���û�Խ���
define('_AOIDAS2', 1211); //��ް����Խ���
define('_AOIDAS3', 1114); // ���ǰԽ���
define('_AOIDAS4', 1116); // FAQ
define('_HELP_URL', "http://center.now17.co.kr/doc.view?mcode=1310"); //�޴������Ʈ
define('_NAVER_API', $_NAVER_API); //�޴������Ʈ

define('_DMBS', $INFO[dmbs]); //��� Ÿ��

define('_COPY_NO', $_COPY_NO); //�������
define('_BI_NO', $_BI_NO); //��Ӿ�
define('_JUMIN_NO', $_JUMIN_NO); //�ֹι�ȣ����
define('_QMENU_USE', $_QMENU_USE); //���޴� ��뿩��


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

define ('_MODULE', _DOC_ROOT."/lib/ewut_module.php");		// ����� �Լ� ����

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



# Function (ȸ�� IP���� üũ)
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
			<html xmlns="http://www.w3.org/1999/xhtml"><html><head><title>���</title><meta http-equiv="content-type" content="text/html; charset=euc-kr">';

			echo '<h1>404 Error</h1>';

			echo "</head><body></body></html>";
			exit;
	exit;
}*/
?>