<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: ����Ʈ ��û
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", "html/board/admin/manage/move.htm");
	

	$tpl->assign(array('mcode'=>$mcode));



	 break;
	case "POST":
	
if($a_bbs && $b_bbs) {
	


 $sql = "update tab_board set num_mcode = '$b_bbs' where num_oid = '$_OID' and num_mcode = '$a_bbs'";
	 $DB->query($sql);
	 $DB->commit();

 $sql = "delete from tab_menu_right where num_oid = '$_OID' and str_sect = 'menu' and str_code = '$b_bbs'";
	 $DB->query($sql);
	 $DB->commit();

 $sql = "update tab_menu_right set str_code = '$b_bbs' where num_oid = '$_OID' and str_sect = 'menu' and str_code = '$a_bbs'";
	 $DB->query($sql);
	 $DB->commit();

 $sql = "update tab_files set str_code = '$b_bbs' where num_oid = '$_OID' and str_sect = 'menu' and str_code = '$a_bbs'";
	 $DB->query($sql);
	 $DB->commit();

	 echo '<script>alert("�Ϸ�Ǿ����ϴ�.");
	 history.go(-1);
	 </script>';

	 
}else{

	 echo '<script>alert("������ ��� �Է��ϼ���");
	 history.go(-1);
	 </script>';


}
	 

	
	
	break;
	}

?>