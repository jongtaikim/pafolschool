<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설   명: 카페메인대문 에디터
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.main_edit');
switch ($REQUEST_METHOD) {
	case "GET":
	

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("/party/admin/edit.htm"));
	
	 break;
	case "POST":

	$content = WebApp::ImgChaneDe($content);
	$content = str_replace(">&nbsp;</TD","><img src=/b.gif width=1 height=1></TD",$content);
	$content = str_replace("'","''",$content);
	list($str1,$str2,$str3) = WebApp::content_split($content);	// 앞에서부터 3개 이하는 버림!


	 $sql = "UPDATE ".TAB_PARTY." SET str_main_html1='$str1',str_main_html2='$str2',str_main_html3='$str3' WHERE num_oid=$_OID and num_pcode = $pcode";
	 $DB->query($sql);
	 $DB->commit();
	 WebApp::moveBack('저장되었습니다.');
	  
	

	 break;
	}

?>