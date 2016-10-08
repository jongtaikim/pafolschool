<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: edit.php
* 작성일: 2005-03-31
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'];

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu_top',$mcode);


switch($REQUEST_METHOD) {
	case "GET":



$sql = "select str_text,str_text2,str_text3,str_text4 from TAB_TITLE_DOC where num_oid = '$_OID' and num_mcode = '$mcode' and num_css = '"._CSS."'";
$str_text = $DB -> sqlFetch($sql);

$str_text['str_text'] = $FH->set_content($str_text[str_text]);
$str_text['str_text2'] = $FH->set_content($str_text[str_text2]);
$str_text['str_text3'] = $FH->set_content($str_text[str_text3]);
$str_text['str_text4'] = $FH->set_content($str_text[str_text4]);


$tpl->assign(array(
	'str_text'=>$str_text[str_text],
	'str_text2'=>$str_text[str_text2],
	'str_text3'=>$str_text[str_text3],
	'str_text4'=>$str_text[str_text4],
	'mcode'=>$mcode,
	'mode'=>$mode,
	));



		$tpl->setLayout('admin');	
		$tpl->define('CONTENT','html/menu/admin/top_edit.htm');

	break;
	case "POST":
		
if($str_text) {

      
$str_text = WebApp::ImgChaneDe($str_text);
$str_text = str_replace("<p>&nbsp;</p>","",$str_text);
$str_text = str_replace("<P>&nbsp;</P>","",$str_text);
$str_text = str_replace("'","''",$str_text);

 $sql = "INSERT INTO ".TAB_TITLE_DOC." (	
 
				NUM_OID,NUM_MCODE,NUM_CSS,STR_TEXT
				) VALUES (
				$_OID, '".$mcode."', '"._CSS."','$str_text') ";
 


			$DB->query($sql);
			$DB->commit();


$sql = "

update TAB_TITLE_DOC set  
STR_TEXT='$str_text'
where 
NUM_OID = '$_OID' AND NUM_MCODE = '$mcode' AND NUM_CSS = '"._CSS."'
";


$DB->query($sql);
$DB->commit();

 }
 



if($str_text2) {
 $str_text2 = str_replace("<p>&nbsp;</p>","",$str_text2);
 $str_text2 = str_replace("<P>&nbsp;</P>","",$str_text2);

 $str_text2 = WebApp::ImgChaneDe($str_text2);
 $str_text2 = str_replace("'","''",$str_text2);
 $sql = "INSERT INTO ".TAB_TITLE_DOC." (	
 
				NUM_OID,NUM_MCODE,NUM_CSS,STR_TEXT2
				) VALUES (
				$_OID, '".$mcode."', '"._CSS."','$str_text2') ";
 


			$DB->query($sql);
			$DB->commit();


$sql = "

update TAB_TITLE_DOC set  
STR_TEXT2='$str_text2'
where 
NUM_OID = '$_OID' AND NUM_MCODE = '$mcode' AND NUM_CSS = '"._CSS."'
";


$DB->query($sql);
$DB->commit();

 }



if($str_text3) {
$str_text3 = WebApp::ImgChaneDe($str_text3);
$str_text3 = str_replace("<p>&nbsp;</p>","",$str_text3);
$str_text3 = str_replace("<P>&nbsp;</P>","",$str_text3);
$str_text3 = str_replace("'","''",$str_text3);
 $sql = "INSERT INTO ".TAB_TITLE_DOC." (	
 
				NUM_OID,NUM_MCODE,NUM_CSS,STR_TEXT3
				) VALUES (
				$_OID, '".$mcode."', '"._CSS."','$str_text3') ";
 


			$DB->query($sql);
			$DB->commit();


$sql = "

update TAB_TITLE_DOC set  
STR_TEXT3='$str_text3'
where 
NUM_OID = '$_OID' AND NUM_MCODE = '$mcode' AND NUM_CSS = '"._CSS."'
";


$DB->query($sql);
$DB->commit();

 }



if($str_text4) {
 $str_text4 = WebApp::ImgChaneDe($str_text4);
 $str_text4 = str_replace("<p>&nbsp;</p>","",$str_text4);
 $str_text4 = str_replace("<P>&nbsp;</P>","",$str_text4);
 $str_text4 = str_replace("'","''",$str_text4);
 $sql = "INSERT INTO ".TAB_TITLE_DOC." (	
 
				NUM_OID,NUM_MCODE,NUM_CSS,str_text4
				) VALUES (
				$_OID, '".$mcode."', '"._CSS."','$str_text4') ";
 


			$DB->query($sql);
			$DB->commit();


$sql = "

update TAB_TITLE_DOC set  
str_text4='$str_text4'
where 
NUM_OID = '$_OID' AND NUM_MCODE = '$mcode' AND NUM_CSS = '"._CSS."'
";


$DB->query($sql);
$DB->commit();

 }
$cache_file = '/hosts/'.HOST.'/'.$mcode.'sub_top.htm';
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.$cache_file);

$cache_file2 = '/hosts/'.HOST.'/'.$mcode.'sub_top2.htm';
$FTP->delete(_DOC_ROOT.$cache_file2);
WebApp::moveBack('저장되었습니다.');

	break;
}
?>
