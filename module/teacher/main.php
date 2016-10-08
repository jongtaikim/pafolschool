<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-12
* �ۼ���: ������
* ��  ��: main.php ǥ�� ����
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB"); //���Ŭ����
$URL = &WebApp::singleton('WebAppURL'); //URL Ŭ����
$tpl = &WebApp::singleton('Display'); //���ø����� Ŭ����
$mcode = $param['code'];  //<wa:��� code="{mcode}"> wa�ױ׿��� ���� ������ $mcode

$mou_name = "teacher"; //����̸� ����
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name); //�ش��� �������� ȯ�漳���� �ҷ�����
$tpl->assign($conf);
$tpl->assign($conf_main);

//2008-04-17 ���� ���̺귯���� ���ؼ�

if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
else $theme_name = "simple"; //��Ų�� ������� �⺻

$template = $param['template'];
if ($theme_name) $template = "/theme_lib/".$mou_name."/".$theme_name."/attach.".$mou_name."_no.htm"; //��Ų���� ���� ��� �ش� �������� html�� �����´�

$tpl->define('TEACHER_',$template);

/*...... �̰��� ��� select�� ���� ���� �۾��� ���� .... */
if(!$conf['listnum']) $listnum= "5"; else  $listnum = $conf['listnum'];
if(!$conf['img_w']) $img_w= "60"; else  $img_w = $conf['img_w'];
if(!$conf['img_h']) $img_h= "109"; else  $img_h = $conf['img_h'];
if(!$conf['col']) $col= "3"; else  $col = $conf['col'];

$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (
			select 
				NUM_OID, STR_TACH_CODE, STR_NAME, STR_TACH_TYPE,STR_TACH_TITLE
			from TAB_TACH 
			where num_oid = "._OID."   
			and num_view = 1 
			order by STR_TACH_CODE asc
			)b)a
		where a.RNUM >  0 and a.RNUM <= $listnum
";

$data = $DB->sqlFetchAll($sql);

$tpl->assign(array(
'LIST'=>$data,
));

$content = $tpl->fetch("TEACHER_");
echo $content;

?>