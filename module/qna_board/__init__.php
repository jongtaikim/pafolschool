<?
/**********************************************
* 파일명: __init__.php
* 설  명: 공통 인클루드 파일
* 날  짜: 2005-02-28
* 작성자: 거친마루
***********************************************/

require_once dirname(__FILE__).'/table_define.php';

$__MODULE__  = 'board';
$__NAME__    = _('Bulletin board');
$__VERSION__ = '0.9 beta';
$__RUNMODE__ = 'menu'; // ['menu','single','multi:$param']

// {{{ 리퀘스트 변수 받기
$mcode = $_REQUEST['mcode'];
$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
// }}}

$DB = &WebApp::singleton('DB');

$sql = "SELECT * FROM $CONFIG_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
	if(!$_conf = $DB->sqlFetch($sql)) WebApp::moveBack('존재하지 않는 코드입니다');
	
// }}}
$DOC_TITLE = 'str:'.$_conf['str_title'];



if (!$ch) $ch = '@sub'; //WebApp::getConf("board.layout");

$oid = $_OID;
$skin = $_conf['str_skin'];
if (!$skin) $skin = 'news_emerald';
$board_title = $_conf['str_title'];
$env['use_comment'] = $_conf['chr_comment'];
$env['use_upload'] = $_conf['chr_upload'];
$env['use_recent'] = $_conf['chr_recent'];
$env['listtype'] = $_conf['num_listnum'];


$tpl->assign($_conf);


@extract($_conf['phpvars']);

$dateformat = 'Y-m-d';

//==-- 템플릿 기능버튼 링크 정의 --==//
$modifylink = $URL->setVar('act','.modify');
$replylink = $URL->setVar('act','.reply');
$deletelink = $URL->setVar('act','.delete');

$URL->delVar('id','num');
$writelink = $URL->setVar('act','.write');
$listlink = $URL->setVar('act','.list');
$tpl->assign(array(
	'modifylink' => $modifylink,
	'replylink' => $replylink,
	'deletelink' => $deletelink,
	'writelink' => $writelink,
	'listlink' => $listlink,
	'listnum'=>$_conf['option']['listnum']
));

//2007-10-28 로그인시 정보 가지고 있기 종태
$tpl->assign(array(
	'NAME' => $_SESSION['NAME'],
	'PASSWD' => $_SESSION['PASSWORD'],
	'EMAIL' => $_SESSION['E_MAIL'],
	));

if(check_edumark_ip()){
$tpl->assign(array(
	'NAME' => "울트라웹",
	'PASSWD' => "0000",
	'NAME' => "울트라웹",
	));
}

//==-- 환경변수 정의 --==//
$PERM = &WebApp::singleton('Permission');
$env['writable'] = (($oid == $_OID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w')));
$env['admin'] = (($oid == $_OID) && $_SESSION['ADMIN']);

//==-- 레이아웃 설정하기 --==//



$tpl->setLayout();

if($skin =="news_emerald") $skin = "A_board";


$tpl->define("BOARD_TOP", '/html/qna_board/board_top.htm');
$con_setup = explode("|",$_SESSION[SETUP]);

$tpl->assign(array(
				'str_coment_use'=>$con_setup[0],
				'str_scrab_use'=>$con_setup[1],
				'str_rss_use'=>$con_setup[2],
				
				));

	

?>
