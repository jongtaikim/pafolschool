<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2010-01-18
* �ۼ���: ������
* ��   ��: �̹�����Ʈ
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