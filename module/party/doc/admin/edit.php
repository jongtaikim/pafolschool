<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/doc/admin/edit.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'];

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$filepath = 'hosts/'.$HOST.'/doc/party.'.$pcode.'.'.$mcode.'.msg';

switch($REQUEST_METHOD) {
	case "GET":
		$msg = WebApp_Message::fromFile($filepath);

		$data['content'] = $FH->set_content($msg->__toString());
		$data['title_decorator'] = $msg->header['Title-Decorator'];
		if ($data['title_decorator'] == 'str') $data['title'] = $msg->header['Title'];
        if (!$data['title']) {
            $sql = "SELECT str_title FROM ".TAB_PARTY_MENU." WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode={$mcode}";
            $data['title'] = $DB->sqlFetchOne($sql);
        }
		if (!$data['title_decorator']) $data['title_decorator'] = 'str';
		if ($data['title_decorator'] == 'image') $data['title_image_url'] = $msg->header['Title'];
		$data['mcode'] = $mcode;
		
		$tpl->setLayout('admin');
		$tpl->define('CONTENT','html/party/doc/admin/edit.htm');
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
				if(!$title) {
                    $sql = "SELECT str_title FROM TAB_PARTY_MENU WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode={$mcode}";
                    $title = $DB->sqlFetchOne($sql);
                }
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

		$content = $FH->get_content($_POST['content']);
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

		WebApp::redirect($URL->setVar(array('act'=>'party.menu.admin.option','mcode'=>$mcode)),'수정되었습니다');
	break;
}
?>
