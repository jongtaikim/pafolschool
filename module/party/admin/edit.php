<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��   ��: ī����δ빮 ������
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
	list($str1,$str2,$str3) = WebApp::content_split($content);	// �տ������� 3�� ���ϴ� ����!


	 $sql = "UPDATE ".TAB_PARTY." SET str_main_html1='$str1',str_main_html2='$str2',str_main_html3='$str3' WHERE num_oid=$_OID and num_pcode = $pcode";
	 $DB->query($sql);
	 $DB->commit();
	 WebApp::moveBack('����Ǿ����ϴ�.');
	  
	

	 break;
	}

?>