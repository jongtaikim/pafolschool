<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-08
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* ���� : <wa:applet module="banner.main">���ø� ����</wa:applet>
*/


$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'. "inc.main.bannerZone.htm";
$del = "y";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {

$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');


if(_STYPE == 'E') $str_school="Y__";
elseif(_STYPE == 'M') $str_school="_Y_";
elseif(_STYPE == 'H') $str_school="__Y";
else $str_school="XXX"; //���հ�����



//�б������ڰ� ����� ���չ��
$sql = "SELECT
			NUM_OID, NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE
			FROM ".TAB_BANNER." 
			WHERE NUM_OID="._OID." ";
$data2 = $DB->sqlFetchAll($sql);

if($data1 && $data2) $data = array_merge($data1,$data2);
elseif($data1 && !$data2) $data = $data1;
else $data = $data2;

if($data) {
	$width_att = $conf['width'] ? ' width="'.$conf['width'].'"' : '';
	$height_att = $conf['height'] ? ' height="'.$conf['height'].'"' : '';

	for($i=0,$cnt=count($data);$i<$cnt;$i++) {
		if($data[$i]['num_oid'] == _AOID) $data[$i]['file_url'] = 'hosts/'._AOIDHOST.'/files/banner/'.$data[$i]['str_file'];
		else $data[$i]['file_url'] = 'hosts/'.HOST.'/files/banner/'.$data[$i]['str_file'];
		
		
		
		if($imgs[0] > 154){
		WebApp::saveThumbImg(_DOC_ROOT."/".$data[$i]['file_url'],_DOC_ROOT."/".$data[$i]['file_url'],154,46,100);
		}


		$data[$i]['banner_tag'] = '<img src="'.$data[$i]['file_url'].'"'.$width_att.$height_att.' border="0">';
	}

	$tpl->assign("LIST",$data);
}
	
	

$make ="y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}

?>