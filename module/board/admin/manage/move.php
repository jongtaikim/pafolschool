<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
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

	 echo '<script>alert("완료되었습니다.");
	 history.go(-1);
	 </script>';

	 
}else{

	 echo '<script>alert("정보를 모두 입력하세요");
	 history.go(-1);
	 </script>';


}
	 

	
	
	break;
	}

?>