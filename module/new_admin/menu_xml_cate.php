<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu_xml.php
* 작성일: 2006-07-06
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");



$xml = '<'.'?xml version="1.0" encoding="euc-kr"?'.'>'.'
<tree>


	<tree icon="image/icon/madang.png" text="서브페이지" action="javascript:selectMenu();" src="media_cate.admin.xml"/>
	<tree icon="image/icon/madang.png" text="노출안되는페이지" action="javascript:selectMenu(1);" src="media_cate.admin.xml?mcode=1"/>
	
</tree>';
echo $xml;
exit;
?>