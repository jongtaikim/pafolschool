<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-05
* 작성자: 이현민
* 설   명: 카페회원설정
*****************************************************************
* 
*/
switch ($mode) {
	case "update":
		$sql = "update TAB_PARTY_MEMBER set str_mtype='$mtype' where num_oid='$_OID' and num_pcode=$pcode and str_id='$id'";
		$DB->query($sql);
		if($DB->commit()){
			echo "Y";
		}
	break;

	case "update2":
		$sql = "update TAB_MEMBER set num_auth='$auth' where num_oid='$_OID'  and str_id='$id'";
		$DB->query($sql);
		if($DB->commit()){
			echo "Y";
		}
	break;
	case "delete":
		$sql = "delete from TAB_PARTY_MEMBER where num_oid='$_OID' and num_pcode=$pcode and str_id='$id'";
		$DB->query($sql);
		if($DB->commit()){

			$sql = "update TAB_PARTY set num_user=num_user-1 where  num_oid=$_OID and num_pcode=$pcode";
			$DB->query($sql);
			$DB->commit();

			WebApp::moveBack('삭제했습니다.');
		}
	break;
}
?>