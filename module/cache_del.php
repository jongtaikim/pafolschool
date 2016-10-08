<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설   명: 매인화면 캐시지우기
*****************************************************************
* 
*/
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc.*");
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc_menu/*.htm");
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/menu.xml");
WebApp::moveBack();

?>