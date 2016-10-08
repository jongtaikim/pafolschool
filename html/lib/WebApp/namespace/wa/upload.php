<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/upload.php
* 작성일: 2005-07-15
* 작성자: 이범민
* 설  명: 업로드관련 출력
*****************************************************************
*
required Attribute : part, sect, code
case of 'part' Attribute
	script(required)
		(available attributes)
		name			: name of content elements
	editor
		(available attributes)
		oid				: organization id
		name			: name of content elements
		width			: width of editor
		height			: height of editor
		toolbar			: kind of toolbarset
		obj				: Instance Name of FileHost Object
	component
		(available attributes)
		name			: name of content elements
		form			: name of form tag
		width			: width of component
		height			: height of component
		fnwidth			: width of filename column
		fswidth			: width of filesize column
		maxfilenum
		maxfilesize
		obj				: Instance Name of FileHost Object
	filelist
		(available attributes)
		oid				: organization id
		name			: name of content elements
		form			: name of form tag
		var				: variable name of filelist data
*/
if (empty($attr['part']) || empty($attr['sect']) || empty($attr['code'])) return;
$str = file_get_contents('var/_upload_'.$attr['part'].'.htm');
if (empty($attr['name'])) $attr['name'] = 'content';
if (empty($attr['obj'])) $attr['obj'] = 'FH';
switch ($attr['part']) {
	case 'component':
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['width'])) $attr['width'] = '400';
		if (empty($attr['height'])) $attr['height'] = '60';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '282800000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '30';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		break;
	case 'editor': 
		if (empty($attr['modet'])) $attr['modet'] = 'board';
		if (empty($attr['codet'])) $attr['codet'] = 'com';
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '4519200000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '30';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;


case 'editor_mboard': 
		if (empty($attr['modet'])) $attr['modet'] = 'board';
		if (empty($attr['codet'])) $attr['codet'] = 'com';
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '51200000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '1';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;


	case 'editor2': 
		if (empty($attr['modet'])) $attr['modet'] = 'board';
		if (empty($attr['codet'])) $attr['codet'] = 'com';
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '282800000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '30';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;


case 'editor_module': 
		if (empty($attr['modet'])) $attr['modet'] = 'board';
		if (empty($attr['codet'])) $attr['codet'] = 'com';
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '282800000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '30';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;


	case 'editor_xml': 
		if (empty($attr['modet'])) $attr['modet'] = 'board';
		if (empty($attr['codet'])) $attr['codet'] = 'com';
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($attr['liststyle'])) $attr['liststyle'] = '0';
		if (empty($attr['fnwidth'])) $attr['fnwidth'] = '200';
		if (empty($attr['fswidth'])) $attr['fswidth'] = '180';
		if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '882800000';  //maxfile upload 사이즈 200MB일때
		//if (empty($attr['maxfilesize'])) $attr['maxfilesize'] = '943718400'; //maxfile upload 사이즈 900MB일때
		if (empty($attr['maxfilenum'])) $attr['maxfilenum'] = '30';
		if (empty($attr['allowtype'])) $attr['allowtype'] = 'zip, arj, rar, gz, tgz, ace, Z, exe, pdf, doc, docx, hwp, xls, xlsx, ppt, pptx, bmp, jpg, jpeg, png, gif, txt, mp3, mp4, ogg, aiff, avi, mpg, mpeg, mov, rm, swf, flv, wmv, wma, ra, html, htm, alz, dat, ios, psd';
        if (empty($attr['obj'])) $attr['obj'] = 'FH';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;

case 'editor_fck': 
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		break;


case 'editor_basic': 
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
		if (empty($attr['width'])) $attr['width'] = '100%';
		if (empty($attr['height'])) $attr['height'] = '400';
        if (empty($attr['obj'])) $attr['obj'] = 'FH'; 
		$attr['content'] = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
		break;

	case 'filelist':
		if (empty($attr['oid'])) $attr['oid'] = '{_'.$attr['obj'].'->oid}';
		if (empty($attr['form'])) $attr['form'] = 'writeForm';
		if (empty($arrt['var'])) $attr['var'] = 'FILE_LIST';
		break;
}
foreach($attr as $key => $value) {
	$target[] = '%'.$key.'%';
	$source[] = $value;
}
return str_replace($target,$source,$str);
?>
