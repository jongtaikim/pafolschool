<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/link/go.php
* 작성일: 2004-04-02
* 작성자: 거친마루
* 설  명: URL로 리다이렉트시켜주는 모듈
*****************************************************************
* NOTE: DB를 한번 더 읽고 웹접근도 다시 일어나므로, 사용을권장하지는 않음
*       레퍼러를 별도로 기록하고싶거나 기타 이유가 있을경우 기능확장용
*/

$mcode = $_REQUEST['mcode'];
$DB = &WebApp::singleton('DB');
$sql = "
    SELECT
        /* INDEX (TAB_CONTENT_URL PK_TAB_CONTENT_URL) */
        str_url, str_target
    FROM
        TAB_CONTENT_URL
    WHERE
        num_oid="._OID." AND num_mcode={$mcode}
";

$data = $DB->sqlFetch($sql);
WebApp::redirect($data['str_url']);
//TODO: target이 현재창이 아닌경우에대한 액션을 여기서 할 수있을까?    
?>
