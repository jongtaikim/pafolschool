<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/

if($fname){
	if(is_file(_DOC_ROOT.$fname)) unlink(_DOC_ROOT.$fname);
}
WebApp::moveBack();

?>