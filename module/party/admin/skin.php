<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-21
* �ۼ���: ������
* ��   ��: ��Ų����
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
 	 
	WebApp::moveBack('����Ǿ����ϴ�.');
	
 	 
	  
	 }else{
	 echo $DB->error;
	 }

	
	

	 break;
	}

?>