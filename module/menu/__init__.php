<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-31
* �ۼ���: ������
* ��   ��: �޴�ī���� ��ȣ ���
*****************************************************************
* 
*/

if(_MCODE || $mcode){
$DB = &WebApp::singleton('DB');
$sql = "select NUM_CATE from TAB_MENU where num_oid = "._OID." and num_mcode =  "._MCODE." ";
$cate = $DB -> sqlFetchOne($sql);
$tpl = &WebApp::singleton('Display'); 
$tpl->assign(array('cate'=>$cate));

}



?>