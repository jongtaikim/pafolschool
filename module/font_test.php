<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-06-16
* �ۼ���: ������
* ��   ��: ��Ʈ �׽�Ʈ
*****************************************************************
* 
*/

if(!$jp) 	$jp = 100;
if(!$textval) $textval = "�����׽�Ʈ";
if(!$size) $size = 10;
$color = str_replace("#","",$color);
if(!$color) $color = "000000";

/***��Ʈ ���� �б�***/

$dir1= "./font2/";

$num = 0;
$d1 = opendir($dir1);
while($file = readdir($d1)) {
  if(is_dir($file)) continue;

if(strstr($file,".ttf")) {

$a = explode(".",$file);
	
$fonts[$num]['name'] =$a[0];	

}

$num++;
}
closedir($dir1);



$tpl->setLayout('admin');
$tpl->define("CONTENT", Display::getTemplate("font_test.htm"));
$tpl->assign(array(
					'LIST'=>$fonts,
					'jp'=>$jp,
					'textval'=>$textval,
					'size'=>$size,
					'color'=>$color,
					
					));
	
	 


?>