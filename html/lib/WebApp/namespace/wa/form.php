<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/form.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: 웹폼을 해석하는 루틴
*****************************************************************
* 
*/
if ($innerHTML) {
	//include_once "class.WebForm.php";   // webform parser;
    include_once "WebApp/WebForm.php";
	$WF = new WebForm_Parser($innerHTML);
	$content = $WF->getContent();
	$content = customtag($content);
	$stat = $WF->getStat();

	$attr['method'] = 'post';
	$attr['onsubmit'] = ((!empty($attr['onsubmit'])) ? ';' : '').'return validate(this)';
	if ($WF->is_multipart) $attr['enctype'] = 'multipart/form-data';

	$ret = "<script type=\"text/javascript\">WebApp.Import('lib.validate.js');</script>\n";
	$ret.= "<FORM ".array2param($attr).">\n";
	//$ret.= '<INPUT type="hidden" name="act" value="'.MODULE.'" />';
	$ret.= $content;
	$ret.= $stat;
	$ret.= "\n</FORM>";
	return $ret;
}
?>
