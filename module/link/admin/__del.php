<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/link/admin/__del.php
* 작성일: 2005-04-01
* 작성자: 거친마루
* 설  명: 링크형 메뉴를 삭제할때 호출되는 파일
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$sql = "
	DELETE FROM
        TAB_CONTENT_URL
    WHERE
        num_oid="._OID." AND num_mcode='{$mcode}'
";
$DB->query($sql);
$DB->commit();

?>
