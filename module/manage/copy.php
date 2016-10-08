<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-12-19
* 작성자: 김종태
* 설   명: 호스트 카피
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
echo "cp -R "._DOC_ROOT."/hosts/sample1.nowmall.co.kr/ "._DOC_ROOT."/hosts/test4.nowmall.co.kr/";
exec("cp -R "._DOC_ROOT."/hosts/sample1.nowmall.co.kr/ "._DOC_ROOT."/hosts/test4.nowmall.co.kr/");
?>