<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-12-19
* �ۼ���: ������
* ��   ��: ȣ��Ʈ ī��
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
echo "cp -R "._DOC_ROOT."/hosts/sample1.nowmall.co.kr/ "._DOC_ROOT."/hosts/test4.nowmall.co.kr/";
exec("cp -R "._DOC_ROOT."/hosts/sample1.nowmall.co.kr/ "._DOC_ROOT."/hosts/test4.nowmall.co.kr/");
?>