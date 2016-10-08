<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/create.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
include 'module/admin/__init__.php';

switch($REQUEST_METHOD) {
	case "GET":
        $tpl->setLayout('no3');
        $tpl->define('CONTENT','html/party/admin/create.htm');

	break;
	case "POST":
        $str_pname = $_POST['str_pname'];
        $str_pass = $_POST['str_pass'];
        $str_officer = $_POST['str_officer'];


$DB = &WebApp::singleton('DB');
        $sql = "SELECT  MAX(num_pcode) FROM ".TAB_PARTY." WHERE num_oid=$_OID";
		$pcode = $DB->sqlFetchOne($sql);
        
		if(!$pcode) {
			$pcode = 10;
		}else{
		$pcode++;
		}


        $sql = "INSERT INTO ".TAB_PARTY." (
                    num_oid, num_pcode, num_step, str_pname, str_pass, str_officer
                ) VALUES (
                    $_OID, $pcode, $pcode, '$str_pname', '$str_pass','$str_officer'
                )";
        if($DB->query($sql)) {
    
            $DB->commit();

            include

            WebApp::redirect('party.admin.list','생성되었습니다.');
        } else {
            if($_FILES['photo']['tmp_name']) @unlink($_FILES['photo']['tmp_name']);
            die($sql);
            WebApp::moveBack('생성실패 : DB 오류입니다.');
        }
	break;
}
?>