<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/attach/admin/edit_part.php
* 작성일: 2006-05-08
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$name = $_REQUEST['name'];
$id = substr($name,strrpos($name,'_')+1);
if(!$name || !$id) msgClose('잘못된 요청입니다.');

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','part');
$ATT_CONF = Display::AttachConf();
$attach_file = array_pop($ATT_CONF[$name]['file']);
$tpl = &WebApp::singleton('Display');
switch($REQUEST_METHOD) {
	case "GET":

		$sql = "SELECT num_serial,str_title, str_name, str_text1,str_text2,str_text3 FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID AND str_name='$name' and num_css='"._CSS."'";
        $data = $DB->sqlFetch($sql);
		

		$msg = $data[str_text1];// 파일지정하고
		if(!$msg) $msg = file_get_contents(Display::getTemplate($attach_file));// 파일지정하고
        $data['content'] = $FH->set_content($msg);
        $data['width'] = $width;

        $tpl->setLayout('admin');
        $tpl->define('CONTENT','html/attach/admin/add_part.htm');
        $tpl->assign($data);
	break;
	case "POST":
        $str_title = $_POST['str_title'];
       $content = str_replace(">&nbsp;</TD","><img src=/b.gif width=1 height=1></TD",$content);




		$sql = "select count(*) from ".TAB_ATTACH_PART." WHERE num_oid=$_OID AND num_serial=$id and num_css='"._CSS."'";
		$tmp= $DB -> sqlFetchOne($sql);

		
		$content = str_replace("'","''",$content);
		$content = &WebApp::ImgChaneDe($content);


		list($str1,$str2,$str3) = WebApp::content_split($content);	// 앞에서부터 3개 이하는 버림!
		
		

		if($tmp > 0) {
		$sql = "UPDATE ".TAB_ATTACH_PART." SET str_title='$str_title', str_text1 = '".$str1."', str_text2 = '".$str2."', str_text3 = '".$str3."' WHERE num_oid=$_OID AND num_serial=$id and num_css='"._CSS."'";			
		}else{
		$sql = "INSERT INTO ".TAB_ATTACH_PART." (num_oid,num_serial,str_name,str_title,str_text1,str_text2,str_text3,num_css) ".
                "VALUES ($_OID,$id,'$name','$str_title','".$str1."','".$str2."','".$str3."','"._CSS."')";
		}

	

		if(!$DB->query($sql)) {
            
	   
	   
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

	           msgClose('저장 실패하였습니다.');
		
		}

        $DB->commit();


		$_SESSION['get_thumb_filename'] = "";
		unset($_SESSION['get_thumb_filename']);
        
        $msg = $content;

        $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        $FTP->put_string($msg,_DOC_ROOT."/hosts/".HOST."/attach/attach.".$name.".msg");
        msgClose('저장되었습니다.');
	break;
}

function msgClose($msg) {
    if($msg) WebApp::alert($msg);
    echo "<script>parent.closewPop(2);</script>";

	//WebApp::closeWin();
}
?>