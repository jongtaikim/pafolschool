<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-24
* �ۼ���: ������
* ��   ��: ���� ����Ʈ �߰�
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":

	 $sql = "select * from TAB_BOOKMARK where num_oid = $_OID ";
	 $row = $DB -> sqlFetchAll($sql);
	 $tpl->assign(array('LIST'=>$row));
	 
	 
	
	$tpl->setLayout('no4');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/site_add.htm"));
	
	 break;
	case "POST":
	



	$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.linkObj.htm";
	unlink($cache_file);

	switch ($mode) {
		case "write":
		$max_serial = WebApp::maxSerial('TAB_BOOKMARK','num_serial');
		$max_step = WebApp::maxSerial('TAB_BOOKMARK','num_step');
		
		$sql = "INSERT INTO ".TAB_BOOKMARK." (

				NUM_OID, 
				NUM_SERIAL, 
				NUM_STEP, 
				STR_URL, 
				STR_TITLE,
				STR_OPEN
				
				) VALUES (
				
				"._OID.",
				".$max_serial.",
				".$max_step.",
				'".$url."',
				'".$title."',
				'".$open."'
				) ";
		
		
				 if($DB->query($sql)){
				 $DB->commit();
				 WebApp::moveBack('����Ǿ����ϴ�.');
				 exit;
				 }else{
				 echo "sql ���� : ".$sql;
				 exit;
				 }				
				
		
		
		 break;
		case "modify":

		 $sql = "UPDATE ".TAB_BOOKMARK." SET 
		 
		 str_title='$title', 
		 str_url='$url', 
		 str_open='$open'
		 
		 WHERE num_oid=$_OID and num_serial = $code";
		
		 if($DB->query($sql)){
		 $DB->commit();
		 WebApp::moveBack('������');
		 exit;
		 }else{
		 echo "sql ���� : ".$sql;
		 exit;
		 }
		


		 break;
		}
	



	 
	 
	 break;
	}

?>