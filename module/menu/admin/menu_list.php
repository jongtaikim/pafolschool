<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
//모듈이 아닐경우는 지우세요

switch ($REQUEST_METHOD) {
	case "GET":

if($mcode) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '".substr($mcode,0,2)."'";

	$menu1 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu1'=>$menu1));

	if(strlen($mcode) >= 4) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '".substr($mcode,0,4)."'";
	$menu2 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu2'=>$menu2));		
	}

	if(strlen($mcode) >= 6) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '".$mcode."'";
	$menu3 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu2'=>$menu3));		
	}

	


$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND num_mcode LIKE '".$mcode."__'   $que  ORDER BY num_step";
	$menu = $DB -> sqlFetchAll($sql);
	
}else{

	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=2   $que  ORDER BY num_step";	
	$menu = $DB -> sqlFetchAll($sql);


	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=3   $que  ORDER BY num_step";	
	$menu_plus = $DB -> sqlFetchAll($sql);

}

	if(strlen($mcode) > 2) {
		$mcode_ = substr($mcode,0, strlen($mcode)-2);
	}else{
		$mcode_ = $mcode;
	}


	$tpl->assign(array('LIST'=>$menu,'LIST_plus'=>$menu_plus,'mcode' =>$mcode ,'mcode_2' =>$mcode_));

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/menu_list.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>