<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��   ��: ����ȭ�� ĳ�������
*****************************************************************
* 
*/
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc.*");
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc_menu/*.htm");
exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/menu.xml");
WebApp::moveBack();

?>