<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-11
* 작성자: 김종태
* 설   명: 팝업순서변경
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	

	$sql = "select * from TAB_POPUP where num_oid = "._OID." and str_type = 'host' and str_open = 'B' order by num_setp asc ";
	$data1 = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$data1));
	
	

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("popup/admin/list_array.htm"));
	
	 break;
	case "POST":
	$ia = 1;
	 for($ii=0; $ii<count($id); $ii++) {
		 $sql = "UPDATE ".TAB_POPUP." SET num_setp=".$ia." WHERE num_oid="._OID." and str_type='host' and str_open = 'B' and num_serial = ".$id[$ii]."";
		 $DB->query($sql);

		$ia++;
	 }
 		 $DB->commit();

   	  echo '<script>alert("적용되었습니다.");parent.closewPop(2);</script>';
	
	
	 break;
	}

?>