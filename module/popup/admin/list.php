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


		$sql = "SELECT COUNT(*) FROM ".TAB_POPUP." WHERE num_oid = "._OID." ";
		$total = $DB->sqlFetchOne($sql);
		if(!$total) $total = 0;

		if(!$listnum)$listnum = 15;

		$page = $_REQUEST['page'];
		if (!$page) $page = 1;

		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;

		$sql = "
		


		select * from TAB_POPUP where num_oid = "._OID." order by dt_date desc
		limit $seek, $listnum";

		


		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('LIST'=>$row));

		if(_OID != _AOID){
		$sql = "select * from TAB_POPUP where num_oid = "._AOID."  $psql ";
		$row2 = $DB -> sqlFetchAll($sql);

		$tpl->assign(array('LIST_g'=>$row2));
		}



		$tpl->setLayout('no3');

		$tpl->define("CONTENT","html/popup/admin/list.htm");
		$tpl->assign(array(
		'title'=>$title,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
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