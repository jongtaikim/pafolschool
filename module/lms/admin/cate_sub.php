<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-07-11
* 작성자: 김종태
* 설   명: 교육관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');



switch ($REQUEST_METHOD) {
	case "GET":


	//2010-12-08 종태 카테고리
	$sql = "select * from ".$table2." where num_oid = '$_OID' and str_type = '$types'  and  LENGTH(NUM_CCODE)=4  order by num_step asc ";
	$cate_list = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$cate_list));

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/cate_sub.htm"));
	
	 break;
	case "POST":

	 

	 for($ii=0; $ii<count($cates); $ii++) {
		$iia = $ii + 1;
		 if($mode=="reset"){
			 $sql = "UPDATE ".$table2." SET num_step=".$cates[$ii]." WHERE num_oid=$_OID and str_type = '$types' and num_ccode = '".$cates[$ii]."'";
		 }else{
			$sql = "UPDATE ".$table2." SET num_step=".$iia." WHERE num_oid=$_OID and str_type = '$types' and num_ccode = '".$cates[$ii]."'";
		 }
		 if($DB->query($sql)){
		 $DB->commit();
			
			 //WebApp::moveBack('수정됨');
		 }
		
	}
	
	if($mode=="reset"){
	echo '<script>alert("'._la('적용되었습니다.').'"); parent.dataLoads("'.$cate.'");</script>';
	}else{
	echo '<script>alert("'._la('적용되었습니다.').'");</script>';
	}


	 break;
	}

?>