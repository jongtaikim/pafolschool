<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-16
* �ۼ���: ������
* ��   ��:  ������ �޴� xml
*****************************************************************
* 
*/
include 'admin_menu.php';

header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

 echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
//http://now17.ezsol.kr/admin.xml
if(!$menu) $menu="";
?>


<menu>
<? if(count($menu) > 0){?>
	<? for($ii=0; $ii<count($menu); $ii++) { ?>
	<depth1 name="<?=$menu[$ii][title]?>" link="<?=$menu[$ii][link].$menu[$ii][pn]?>" target="" >
		<? for($i=0; $i<count($menu[$ii]['submenu']); $i++) { ?>
		<depth2 link="<?=$menu[$ii]['submenu'][$i][link].$menu[$ii]['submenu'][$i][pn]?>" name="<?=$menu[$ii]['submenu'][$i][title]?>" target=""/>    
		<? } ?>
	</depth1>
	<? } ?>
<? }else{ ?>
	<depth1 name="������" link="#" target="" >
		<depth2 link="#" name="���������" target=""/>    
	</depth1>
<? } ?>
</menu>


