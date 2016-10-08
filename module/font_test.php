<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-06-16
* 작성자: 김종태
* 설   명: 폰트 테스트
*****************************************************************
* 
*/

if(!$jp) 	$jp = 100;
if(!$textval) $textval = "장평테스트";
if(!$size) $size = 10;
$color = str_replace("#","",$color);
if(!$color) $color = "000000";

/***폰트 폴더 읽기***/

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