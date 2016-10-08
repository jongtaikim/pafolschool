<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/cafe.php
* �ۼ���: 2008-12-26
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/

if($no) {

$DB = &WebApp::singleton('DB'); 
$sql = "select count(*) from TAB_PARTY where num_oid = $_OID and num_pcode = $no ";
if($DB -> sqlFetchOne($sql) == 0){
WebApp::moveBack('ī�䰡 �������� �ʽ��ϴ�.');
exit;
}

$sql = "select str_pname from TAB_PARTY where num_oid = $_OID and num_pcode = $no ";
$pname = $DB -> sqlFetchOne($sql);
?>

<head>
<title><?=$pname?> �Դϴ�.</title>
</head>
<link rel="stylesheet" type="text/css" href="/css/admin.css">
<FRAMESET>
<frame src ="party.main?pcode=<?=$no?>&skin_num=<?=$skin?>" frameborder="0" width="100%" height="100%" name="" scrolling="auto"></iframe>
</FRAMESET>
<? }else{ 


$DOC_TITLE = 'str:ī����';

$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM ".TAB_PARTY." WHERE num_oid=$_OID ORDER BY num_step";
$DB->query($sql);
$data = array();
while($row = $DB->fetch()) {
    $row['link'] = '/cafe?no='.$row['num_pcode'];
    $intro_path = 'hosts/'.HOST.'/files/party/'.$row['num_pcode'].'.intro.msg';
    $MSG = WebApp_Message::fromFile($intro_path);
    $row['str_intro'] = cut_str(str_replace('&nbsp;',' ',strip_tags($MSG->__toString())),100);
    $data[] = $row;
}

$tpl->setLayout('admin');
$tpl->define('CONTENT','html/party/list.htm');
$tpl->assign('LIST',$data);
}

function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}

?>

