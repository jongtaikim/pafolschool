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
if($_SESSION['def_s']!="1" || !$_SESSION['ADMIN']) {
echo "<meta http-equiv='Refresh' Content=\"0; URL='/doc.view?mcode=$mcode\">";
exit;
}
$mcode = $_REQUEST['mcode'];

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$filepath = 'hosts/'.$HOST.'/doc/'.$mcode.'.msg';

switch($REQUEST_METHOD) {
	case "GET":
		$msg = WebApp_Message::fromFile($filepath);

		$data['content'] = $FH->set_content($msg->__toString());
		$data['title_decorator'] = $msg->header['Title-Decorator'];
		if ($data['title_decorator'] == 'str') $data['title'] = $msg->header['Title'];
        if (!$data['title']) $data['title'] = $DB->sqlFetchOne("SELECT str_title FROM TAB_MENU WHERE num_oid="._OID." AND num_mcode={$mcode}");
		if (!$data['title_decorator']) $data['title_decorator'] = 'str';
		if ($data['title_decorator'] == 'image') $data['title_image_url'] = $msg->header['Title'];
		$DOC_TITLE = "str:".$data['title'];
		$data['code'] = $data['mcode'] = $mcode;




		$tpl->define('CONTENT','html/doc/admin/edit.htm');
		$tpl->assign($data);
	break;
	case "POST":
		$title = $_POST['title'];
		$title_decorator = $_POST['title_decorator'];
		if (!$title_decorator) $title_decorator = 'str';
		if ($title_decorator == 'image') {
			if($_FILES['title_image']['tmp_name']) {
				$filename = date('U') + substr($_FILES['title_image']['name'],strrpos($_FILES['title_image']['name'],'.')+1);
				$title = 'hosts/'.HOST.'/doc/'.$filename;
				WebApp::import('FtpClient');
				$FTP = new FtpClient(WebApp::getConf('account'));
				$FTP->put($_FILES['title_image']['tmp_name'],_DOC_ROOT.'/'.$title);
				if($_POST['title_image_url']) $FTP->delete(_DOC_ROOT.'/'.$_POST['title_image_url']);
				$FTP->close();
				unset($FTP);
			} else {
				$title_decorator = 'str';
				if(!$title) $title = $DB->sqlFetchOne("SELECT str_title FROM TAB_MENU WHERE num_oid="._OID." AND num_mcode={$mcode}");
			}
		} else {
			if($_POST['title_image_url']) {
				WebApp::import('FtpClient');
				$FTP = new FtpClient(WebApp::getConf('account'));
				$FTP->delete(_DOC_ROOT.'/'.$_POST['title_image_url']);
				$FTP->close();
				unset($FTP);
			}
		}
		if ($title_decorator == 'none') $title = '';




//양식 등록하기 2008-03-19 종태
$sql = "select count(*) from TAB_DOC_HTML where 
num_oid = '$_OID' and num_mcode = '$mcode'
";
$in_max = $DB -> sqlFetchOne($sql);


if(!$in_max) {
	$sql = "select max(num_serial) + 1 from TAB_DOC_HTML ";
$max_ser = $DB -> sqlFetchOne($sql);
if(!$max_ser) $max_ser = 1;

$sql = "select max(str_dcode) + 1 from TAB_DOC_HTML  ";
$max_dcode = $DB -> sqlFetchOne($sql);
if(!$max_dcode) $max_dcode = 1;



$title = str_replace("'","\'",$title);
list($str1,$str2,$str3,$str4,$str5) = WebApp::content_split($content);	// 앞에서부터 3개 이하는 버림!


  if ($DB->query("

Insert into TAB_DOC_HTML
   (num_serial, str_dcode, str_title,  str_su_text, str_text1,  str_text2, str_text3, str_text4, str_text5,num_oid,num_mcode)
 Values
   (".$max_ser.", ".$max_dcode.", '양식 $max_ser', '$title', '$str1','$str2','$str3','$str4','$str5','$_OID','$mcode')"

	 )) $DB->commit();

}else{


 if ($DB->query("

update TAB_DOC_HTML set  

str_title='양식 $max_ser',  
str_su_text='$title' , 
str_text1='$str1',  
str_text2='$str2', 
str_text3='$str3', 
str_text4='$str4', 
str_text5='$str5'

where 

num_oid = '$_OID' and num_mcode = '$mcode'

")) $DB->commit();

}










		$content =$_POST['content'];
        $FH->find_upload($content);
	
        $header = array(
            'Content-Type' => 'text/html',
            'Content-Encoding' => 'euc-kr',
            'Title' => $title,
            'Title-Decorator' => $title_decorator
        );	
		$msg = new WebApp_Message($header,$content);
	
		






		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->check_dir('hosts/'.HOST.'/doc','hosts/'.HOST);
		$FTP->put_string($msg->build(), _DOC_ROOT.'/'.$filepath);
		$FTP->close();

		WebApp::moveBack();
		
	break;
}
?>
