<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-21
* 작성자: 김종태
* 설   명: 스킨고르기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

	include _DOC_ROOT.'/html/party/skin/office.config.inc';
	



		$tpl->assign(array(
			'LIST' => $skinList,
			

			));




	
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("party/admin/skin.htm"));
	
	 break;
	case "POST":
	


	$sql = "
	update TAB_PARTY set
   str_layout  =  '".$skin_code."'
   where num_oid = "._OID." and num_pcode = ".$pcode;

	 if($DB->query($sql)){
	 $DB->commit();
 	 
	WebApp::moveBack('적용되었습니다.');
	
 	 
	  
	 }else{
	 echo $DB->error;
	 }

	
	

	 break;
	}

?>