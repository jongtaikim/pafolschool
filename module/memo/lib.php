<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-12
* �ۼ���: ������
* ��  ��: lib.php ǥ�� ����
*****************************************************************
* 
*/
$mcode = $param['code'];  //<wa:��� code="{mcode}"> wa�ױ׿��� ���� ������ $mcode

$mou_name = "memo"; //����̸� ����
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getConf($mou_name);
$conf =  WebApp::getConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php'; //�������� ����ó���� ����

$tpl->assign($conf);
$tpl->assign($conf_main);

$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm"; //�������� ���� �׸������� html �������� 

/*...... �̰��� ��� select�� ���� ���� �۾��� ���� .... */

$tpl->define('MEMO__',$template);
$content = $tpl->fetch('MEMO__');
echo $content;
echo "|||$mou_name"; //ajax������� innerHTML�� ���� ���̾� Ÿ�� ���̵� ������

?>

