<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/ifr/go.php
* 작성일: 2008-10-08
* 작성자: 김종태
* 설  명:  아이프레임 메뉴
*****************************************************************
*/

$mcode = $_REQUEST['mcode'];
$PERM = &WebApp::singleton('Permission');
$PERM->apply('menu',$mcode,'l');
$DB = &WebApp::singleton('DB');
$sql = "
    SELECT
        /* INDEX (TAB_CONTENT_URL PK_TAB_CONTENT_URL) */
        str_url,str_height
    FROM
        TAB_CONTENT_URL
    WHERE
        num_oid="._OID." AND num_mcode={$mcode}
";

$data = $DB->sqlFetch($sql);

$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode= '$mcode' ";
$DOC_TITLE = "str:".$DB -> sqlFetchOne($sql);




$data[str_url] = str_replace("|id|",$_SESSION[USERID],$data[str_url]);
$data[str_url] = str_replace("|nickname|",$_SESSION[NICKNAME],$data[str_url]);


$tpl->assign(array(
'url'=>$data[str_url],
'hh'=>$data[str_height]
));

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("ifr/go.htm"));

//TODO: target이 현재창이 아닌경우에대한 액션을 여기서 할 수있을까?    
?>
