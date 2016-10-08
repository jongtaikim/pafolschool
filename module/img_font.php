<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-01-18
* 작성자: 김종태
* 설   명: 이미지폰트
*****************************************************************
* 
*/
$dir1= _DOC_ROOT."/font2";	



$num = 0;
$d1 = opendir($dir1);
while($file = readdir($d1)) {
  if(is_dir($file)) continue;


if(strstr($file,".")) {
if($file !="." ||$file !=".."  ) {
 $a = explode(".",$file);
	
 $font[$num]['name'] =$a[0];	
}

}

$num++;
}
closedir($dir1);


$tpl->assign(array('FONT'=>$font,'win'=>$win));


$tpl->setLayout('admin');
$tpl->define("CONTENT", Display::getTemplate("img_font.htm"));

?>