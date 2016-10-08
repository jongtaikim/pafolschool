<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/logout.php
* 작성일: 2005-12-02
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

		$DB = &WebApp::singleton('DB');
		 $sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='".$_SESSION[USERID]."' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
		 if($DB->query($sql)){
		 $DB->commit();
		 }

		$_SESSION['AUTH'] = "";
        $_SESSION['REMOTE_ADDR'] = "";
        $_SESSION['NUM_OID'] = "";
        $_SESSION['USERID'] = "";
        $_SESSION['NAME'] = "";
		$_SESSION['PASSWORD'] = "";
		$_SESSION['ADMIN'] = "";
		$_SESSION['IN_ADMIN'] = "";
		$_SESSION['SES_ORGAN'] = "";
		$_SESSION['SES_HOST'] = "";
		$_SESSION['themeset'] = "";
		$_SESSION['reurl']="";
		
        $USER_TYPE =  "";
		
		session_destroy();
		setCookie('AUTH',false,-3600,'/','.'.HOST);
		setCookie('USERID','',-3600,'/','.'.HOST);
		setCookie('NAME','',-3600,'/','.'.HOST);

		echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";

?>