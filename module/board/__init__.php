<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-03
* �ۼ���: ������
* ��   ��: �Խ��� ���� ������ ����
*****************************************************************
* 
*/

if($_OID == _AOID) {
	if(strstr($REQUEST_URI,"?")){
			$REQUEST_URI_r = str_replace("board","tong_board",$REQUEST_URI);
			echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI_r."&mcode=$mcode'\">";
		}else{
			echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI_r."?mcode=$mcode'\">";
		}
		exit;	
}

require_once dirname(__FILE__).'/table_define.php';


// {{{ ������Ʈ ���� �ޱ�
//$mcode = $_REQUEST['mcode'];
//$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
// }}}

$DB = &WebApp::singleton('DB');

$sql = "SELECT * FROM $CONFIG_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";

	if(!$_conf = $DB->sqlFetch($sql)){
		$_SESSION[nonBoard] = $cate;
	}else{
		unset($_SESSION[nonBoard]);
	}

	

// }}}



if (!$ch) $ch = '@sub'; //WebApp::getConf("board.layout");

$oid = $_OID;
$skin = $_conf['str_skin'];
if(!$_conf['str_skin']) $_conf['str_skin'] = "B_board";
if (!$skin) $skin = 'B_board';
$board_title = $_conf['str_title'];

$board_admin_id = $_conf['str_admin_id'];
//2009-09-24 ��Ų���� ����

if($skin == "A_board" || $skin == "boardType1") {
	$_conf[str_skin]="B_board";
	$skin = "B_board";
}

if(!$_conf[chr_listtype]) $_conf[chr_listtype] = "B";

$tpl->assign($_conf);

$dateformat = 'Y-m-d';

//==-- ���ø� ��ɹ�ư ��ũ ���� --==//
$modifylink = "/board.modify?mcode=$mcode&cate=$cate&id=$id";
$replylink = "/board.reply?mcode=$mcode&cate=$cate&id=$id";
$deletelink = "/board.delete?mcode=$mcode&cate=$cate&id=$id";

$URL->delVar('id','num');
$writelink = "/board.write?mcode=$mcode&cate=$cate";
$listlink = "/board/".$mcode;
$tpl->assign(array(
	'modifylink' => $modifylink,
	'replylink' => $replylink,
	'deletelink' => $deletelink,
	'writelink' => $writelink,
	'listlink' => $listlink,
	'listnum'=>$_conf['option']['listnum']
));

//2007-10-28 �α��ν� ���� ������ �ֱ� ����
$tpl->assign(array(
	'NAME' => $_SESSION['NAME'],
	'PASSWD' => $_SESSION['PASSWORD'],
	'EMAIL' => $_SESSION['E_MAIL'],
	));


 
//==-- ȯ�溯�� ���� --==//
$PERM = &WebApp::singleton('Permission');

if($_SESSION[nonBoard]){
	$env['writable'] = (($oid == $_OID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$_SESSION[nonBoard],'w')));
}else{
	$env['writable'] = (($oid == $_OID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w')));
}


$env['admin'] = (($oid == $_OID) && $_SESSION['ADMIN']);

//==-- ���̾ƿ� �����ϱ� --==//


if(($PERM->check('menu',$mcode,'a') || $_SESSION[USERID] == $board_admin_id) && $_SESSION[USERID]) {
	$_SESSION[ADMIN_sub] = true;
}else{
	unset($_SESSION[ADMIN_sub]);
}



$tpl->setLayout('@sub');


$tpl->define("BOARD_TOP", '/html/board/board_top.htm');
$tpl->define("BOARD_TOP2", '/html/board/skin/'.$skin.'/board_top.htm');
$con_setup = explode("|",$_SESSION[SETUP]);

$tpl->assign(array(
				'str_coment_use'=>$con_setup[0],
				'str_scrab_use'=>$con_setup[1],
				'str_rss_use'=>$con_setup[2],
				
				));

$tpl->assign($env);



require_once _DOC_ROOT.'/module/file.php';





?>
