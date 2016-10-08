<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/link/admin/__add.php
* 작성일: 2005-04-01
* 작성자: 거친마루
* 설  명: 링크형 메뉴를 생성할때 호출되는 파일
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');


$sql = "
    INSERT INTO TAB_CONTENT_URL
        (num_oid, num_mcode, str_title, str_url, str_target, dt_date)
    VALUES
        ("._OID.",{$mcode},'{$str_title}','#','_self',SYSDATE)
";
$DB->query($sql);
$DB->commit();

?>
