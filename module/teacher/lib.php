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

$mou_name = "teacher"; //����̸� ����
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

if(!$conf['listnum']) $listnum= "5"; else  $listnum = $conf['listnum'];

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
$tpl->assign(array('LIST'=>$data));


$tpl->define('TEACHER_',$template);
$content = $tpl->fetch('TEACHER_');
echo $content;
echo "|||$mou_name"; //ajax������� innerHTML�� ���� ���̾� Ÿ�� ���̵� ������

?>