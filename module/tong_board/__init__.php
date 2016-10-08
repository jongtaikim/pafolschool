<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-03
* 작성자: 김종태
* 설   명: 게시판 공통 인쿠르드 파일
*****************************************************************
* 
*/


require_once dirname(__FILE__).'/table_define.php';

$tpl->assign(array(
	'__OID'=>_OID ,
	'_AOID'=>_AOID ,
	
	));

$oid = _AOID;
$_OID = _AOID;





// 관리자 타고 오면 자동로그인
if($ses_oid) {
	
		$DB = &WebApp::singleton('DB');
		$sql = "select str_host,str_organ from TAB_ORGAN where num_oid = $ses_oid ";
        $organdb = $DB -> sqlFetch($sql);

		$sql = "select str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup


		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$ses_oid AND 
		str_id='admin'
		 ";
       $data = $DB->sqlFetch($sql);

		
		$_SESSION['SES_ORGAN'] = $organdb['str_organ'];
		$_SESSION['SES_HOST'] = $organdb['str_host'];
		$_SESSION['SES_ORGAN_OID'] = $ses_oid;
        
        
		//2008-12-04 종태 학교선생님,학교관리자는 권한 지정함
		if($data[chr_mtype] == "z") {
		$mem_type = array("t");
		$_SESSION['MEM_TYPE'] = $mem_type;
		$USER_TYPE = $_SESSION['CHR_MTYPE'];	
		$_SESSION['CHR_MTYPE'] = "t";
		}else{
		$mem_type = array("s");
		$_SESSION['MEM_TYPE'] = $mem_type;
		$USER_TYPE = $_SESSION['CHR_MTYPE'];	
		$_SESSION['CHR_MTYPE'] = "s";
		}
		
		$_SESSION['C_OID'] = $oid;

        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
       
		unset($_SESSION['ADMIN']);
		
		$_SESSION['C_OID'] = $oid;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $_SESSION['SES_ORGAN'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        

}





		
	if($_SESSION[ADMIN] || check_edumark_ip() ){
    $DB = &WebApp::singleton('DB');

	$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup
		
		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$_OID AND 
		 chr_mtype = 'z' and ROWNUM = 1
		
		
		";

		
		if($data = $DB->sqlFetch($sql)){
	
		
		
		$_SESSION['SES_ORGAN'] = _ONAME;
		$_SESSION['SES_HOST'] = $_AOIDHOST;
		$_SESSION['SES_ORGAN_OID'] = _AOID;

		$_SESSION['ADMIN'] = true;
        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = _ONAME;
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];
		}
	}





		$_SESSION['C_OID'] = $oid;
        $_SESSION['NAME'] = _ONAME;
		$_SESSION['NICKNAME'] = $data['str_nick'];

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
$sql = "select str_title from TAB_MENU where num_oid = $_OID  and num_mcode = $mcode";
$DOC_TITLE = 'str:'.$DB -> sqlFetchOne($sql);;



if (!$ch) $ch = '@sub'; //WebApp::getConf("board.layout");

$oid = _AOID;
//$skin = $_conf['str_skin'];
if (!$skin) $skin = 'tong_board';
$board_title = $_conf['str_title'];

$board_admin_id = $_conf['str_admin_id'];

$tpl->assign($_conf);

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





if($_OID != _AOID) { //인트라넷이 아닐경우 처리 2008-12-05 종태
	if(!$_SESSION[USERID]){
			
			if($_SERVER[REDIRECT_QUERY_STRING]) {
			$_SESSION['reurl'] =  $_SERVER[REDIRECT_URL]."?".$_SERVER[REDIRECT_QUERY_STRING];	
			}else{
			$_SESSION['reurl'] =  $_SERVER[REDIRECT_URL];
			}

	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login'\">";
	}

	if(!$_SESSION[ADMIN]){
	WebApp::moveBack('페이지를 열람할 권한이 없습니다.');
	}

}

//2008-12-05 종태 인트라넷에서 글작성시와 아닐시 구분
if($_SESSION['SES_ORGAN']) { 
	$ss_organ = $_SESSION['SES_ORGAN'];
}else{
	$ss_organ = _ONAME;
}

if($_SESSION['SES_HOST']) {
	$ss_host = $_SESSION['SES_HOST'];
}else{
	$ss_host = $_SERVER[HTTP_HOST];
}


$tpl->assign(array(
	'NAME' => $_SESSION['NAME'],
	'PASSWD' => $_SESSION['PASSWORD'],
	'EMAIL' => $_SESSION['E_MAIL'],
	'str_tmp1_s' => $ss_organ,
	'str_tmp2_s' => $ss_host,
	));


 

//==-- 환경변수 정의 --==//
$PERM = &WebApp::singleton('Permission');
//$env['writable'] = (($_OID == _AOID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w')));
$env['writable'] = ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w'));
$env['admin'] = ($_OID == _AOID);

if(_OID == _AOID) {
	$_SESSION['IN_ADMIN'] = true;
}else{
	$_SESSION['IN_ADMIN']="" ;
}



//==-- 레이아웃 설정하기 --==//


if(_OID == _AOID) {
$tpl->setLayout('@sub');
}else{
$tpl->setLayout('no4');	

}




$tpl->define("BOARD_TOP", '/html/board/board_top.htm');
$con_setup = explode("|",$_SESSION[SETUP]);

$tpl->assign(array(
				'str_coment_use'=>$con_setup[0],
				'str_scrab_use'=>$con_setup[1],
				'str_rss_use'=>$con_setup[2],
				
				));

	

include _DOC_ROOT.'/module/file.php';

?>
