<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/admin/__add.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB->query("
	INSERT INTO ".TAB_PARTY_COUNCIL_CONFIG."
		(num_oid, num_pcode, num_mcode, str_title, str_skin, chr_oddcolor, chr_evencolor, chr_upload)
	VALUES
		($_OID, $pcode, $mcode, '$menu_name','default','#FFFFFF','#FFFFFF', 'Y')
");
if (!$DB->error) {
	$DB->commit();
    include 'module/party/council/admin/__init__.php';
    updateConf($pcode,$mcode,$party_conf_file);
} else {
	WebApp::raiseError('상담실 메뉴 생성중 오류가 발생했습니다.');
}
?>
