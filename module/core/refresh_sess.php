<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/core/refresh_sess.php
* �ۼ���: 2006-05-15
* �ۼ���: �̹���
* ��  ��: �������� (no WebApp Request : <script src="module/core/refresh_sess.php"></script>)
*****************************************************************
* 
*/
$HOST = ereg_replace('^www\.','',strtolower(getenv('HTTP_HOST')));
$sess_dir = "../../hosts/$HOST/tmp";


//2009-09-25 ���ǰ��� �����κ� ����
$DB = &WebApp::singleton('DB');
		$mk_30 = mktime() - 1800;

	/*	//��ü ����
		$sql = "delete from TAB_SESSION where  num_date < $mk_30";
		 if($DB->query($sql)){
			$DB->commit();
		 }
	*/
 /*-------------------------------------------------------*/


$sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='".$_SESSION[USERID]."' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
	 if($DB->query($sql)){
	 $DB->commit();
	
		
		$sql = "INSERT INTO ".TAB_SESSION." (
		num_oid,str_id,str_pass,str_ip,num_date,ssid
		) VALUES (
		"._OID.",'".$_SESSION[USERID]."','".$_SESSION[PASSWORD]."','".$_SERVER[REMOTE_ADDR]."'
		,'".mktime()."','".$_REQUEST[PHPSESSID]."') ";
		//echo $sql ;
		 if($DB->query($sql)){
		 $DB->commit();

		 }
	 

	 }


if($HOST && is_dir($sess_dir) && is_writable($sess_dir)) {
    @session_save_path($sess_dir);
    @session_start();
	
	

}
exit;
?>