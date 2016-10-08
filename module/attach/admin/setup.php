<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-08
* 작성자: 김종태
* 설  명: 레이아웃 환경설정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	$_LAYOUT = WebApp::getConf('layout');
	$tpl->assign($_LAYOUT);


	
	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=2 AND num_view=1 $que  ORDER BY num_step";
    $data = $DB->sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$data));


	$tpl->setLayout('no');
	$tpl->define("CONTENT", Display::getTemplate("attach/admin/setup.htm"));
	
	 break;
	case "POST":

for($ii=0; $ii<count($mcode_layout); $ii++) {
	 $sql = "UPDATE ".TAB_MENU." SET str_layout='".$layout[$ii]."' WHERE num_oid=$_OID and num_mcode= '".$mcode_layout[$ii]."'";
	 $DB->query($sql);
	 $DB->commit();
	
}


			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
            

			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->delSection("layout");
			foreach( $_REQUEST as $val => $value )
			{
			if($val == "end")  break;
			if($value !="") {
		
			if($val !="mcode_layout" ){
			if($val !="layout") {
			$INI->setVar($val,$value,"layout");			
			}
			}
			
			}
			
			} 
		
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');		

	WebApp::moveBack('설정되었습니다.');
	 
	 break;
	}
?>