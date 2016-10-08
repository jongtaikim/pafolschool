<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-01-29
* 작성자: 김종태
* 설   명: url 위젯 덧글 삭제
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

if($serial && $code_url){

	$code_url = str_replace("&","|",$code_url);
		if($aut_del =="y"){
			 $sql = "delete from TAB_COMMENT where num_oid = "._OID." and num_code = '".$code_url."' and num_serial = ".$serial." ";
		}else{
			 $sql = "update TAB_COMMENT set num_del = '1' where num_oid = "._OID." and num_code = '".$code_url."' and num_serial = ".$serial." ";
		}
	 if($DB->query($sql)){
		 $DB->commit();
		
		if($aut_del =="y"){
			$sql = "delete from TAB_COMMENT where num_oid = "._OID." and num_code = '".$code_url."' and num_main_serial = ".$serial." ";
			$DB->query($sql);
			$DB->commit();
		}else{
		
		WebApp::pointUpdate("comment","1","nown");
		}


		 WebApp::moveBack('삭제되었습니다.');
	 exit;
	 }else{
	 echo "sql 에러 : ".$sql;
	 exit;
	 }
}else{
	 WebApp::moveBack('값이 부족합니다.');
}
	

?>