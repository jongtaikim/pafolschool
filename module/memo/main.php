<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-24
* �ۼ���: ������
* ��  ��: main.php ��������
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB"); //���Ŭ����
$URL = &WebApp::singleton('WebAppURL'); //URL Ŭ����
$tpl = &WebApp::singleton('Display'); //���ø����� Ŭ����
$mcode = $param['code'];  //<wa:��� code="{mcode}"> wa�ױ׿��� ���� ������ $mcode

$mou_name = "memo"; //����̸� ����
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name); //�ش��� �������� ȯ�漳���� �ҷ�����
$tpl->assign($conf);
$tpl->assign($conf_main);

//2008-04-17 ���� ���̺귯���� ���ؼ�
if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
else $theme_name = "simple"; //��Ų�� ������� �⺻

$template = $param['template'];
if ($theme_name) $template = "/theme_lib/$mou_name/".$theme_name."/attach.".$mou_name."_no.htm"; //��Ų���� ���� ��� �ش� �������� html
/*...... �̰��� ��� select�� ���� ���� �۾��� ���� .... */

$sql = "
SELECT COUNT(*) 
 FROM TAB_MEMO 
 WHERE num_oid = "._OID." and str_to_id = '".$_SESSION[USERID]."'
  AND str_save='N' AND str_to_del = 'N'
";

$total_memo = $DB->sqlFetchOne($sql);
if(!$total_memo) $total_memo = 0;

$sql = "
SELECT COUNT(*) 
 FROM TAB_MEMO 
 WHERE num_oid = "._OID." AND str_to_id = '".$_SESSION[USERID]."' 
  AND str_reading_date IS NULL AND str_save='N' AND str_to_del = 'N'
";

$new_memo = $DB->sqlFetchOne($sql);
if(!$new_memo) $new_memo = 0;

$tpl->assign(array(
	'MEMO_LIST'=>$data,
	'total_memo'=>$total_memo,
	'new_memo'=>$new_memo
));

$tpl->define('MEMO__',$template);
$content = $tpl->fetch('MEMO__');
echo $content;

?>

