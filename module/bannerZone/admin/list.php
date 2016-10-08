<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2005-03-18
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$file_dir = 'hosts/'.$HOST.'/files/banner';

switch ($REQUEST_METHOD) {
	case "GET":
        $conf = Display::getMainConf('banner');
        
		$sql = "SELECT /*+ INDEX (".TAB_BANNER." ".IDX_TAB_BANNER.") */ NUM_OID,NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE,STR_P FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
		if($data = $DB->sqlFetchAll($sql)) {
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
				$data[$i]['str_link'] = stripslashes($data[$i]['str_link']);
			}
		}

		$tpl->setLayout('no4');
		$tpl->define('CONTENT','html/banner/admin/list.htm');
		$tpl->assign(array(
            'LIST'  => $data,
            'width' => $conf['width'],
            'height'=> $conf['height']
        ));
	break;
	case "POST":
		switch($mode = $_REQUEST['mode']) {
			case "write":
				$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
				$id = $DB->sqlFetchOne($sql) + 1;
				$sql = "SELECT MAX(NUM_STEP) FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
				$step = $DB->sqlFetchOne($sql) + 1;

				$field = 'NUM_OID,NUM_SERIAL,NUM_STEP,STR_TITLE,STR_LINK,CHR_OPEN,STR_P';
				$value = "
					$_OID,
					$id,
					$step,
					'".addslashes(trim($_POST['str_title']))."',
					'".addslashes(trim($_POST['str_link']))."',
					'".$_POST['chr_open']."',
					'".$_POST['str_p']."'
				";
				$sql = "INSERT INTO ".TAB_BANNER."(".$field.") VALUES (".$value.")";

				if($DB->query($sql)) {
					$DB->commit();

					if($_FILES['upfile']['tmp_name']) {
						$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
						if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files/banner')) {
							$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files');
							$FTP->mkdir('banner');
						}
						$ext = array_pop(explode('.',$_FILES['upfile']['name']));
						$str_file = date('U').'.'.$ext;
						chmod($_FILES['upfile']['tmp_name'],0666);
						if($FTP->put($_FILES['upfile']['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/banner/'.$str_file)) {
							$sql = "UPDATE ".TAB_BANNER." SET STR_FILE='".$str_file."' WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
							$DB->query($sql);
							$DB->commit();
						}
					}
				} else {
					WebApp::moveBack('입력중 오류가 발생했습니다.');
				}
			break;
			case "modify":
			
				if(!$id = $_POST['id']) WebApp::moveBack('잘못된 요청입니다.');
				$field = "STR_TITLE='".addslashes(trim($_POST['str_title']))."',".
						"STR_LINK='".addslashes(trim($_POST['str_link']))."',".
						"CHR_OPEN='".$_POST['chr_open']."', ".
						"STR_P='".$_POST['str_p']."'";
				$sql = "UPDATE ".TAB_BANNER." SET ".$field." WHERE NUM_OID=$_OID AND NUM_SERIAL=".$id;
		
				if($DB->query($sql)) {
					$DB->commit();

					if($_FILES['upfile']['tmp_name']) {
						$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
						if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files/banner')) {
							$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files');
							$FTP->mkdir('banner');
						}
						$ext = array_pop(explode('.',$_FILES['upfile']['name']));
						$str_file = date('U').'.'.$ext;
						echo $_FILES['upfile']['tmp_name'];
						chmod($_FILES['upfile']['tmp_name'],0666);
						if($FTP->put($_FILES['upfile']['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/banner/'.$str_file)) {
							$sql = "UPDATE ".TAB_BANNER." SET STR_FILE='".$str_file."' WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
							$DB->query($sql);
							$DB->commit();
							// 기존파일 삭제
							if($_POST['prevFile']) $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/banner/'.$_POST['prevFile']);
						}
					}
					
					
				} else {
					WebApp::moveBack('수정중 오류가 발생했습니다.');
				}
			break;
            case "listorder";
				//순서변경;
				if($listorder = $_POST['listorder']) {
					$listorder = explode(";",$listorder);
					foreach($listorder as $_serial) {
						if(!$_serial) continue;
						$i++;
						$sql = "UPDATE ".TAB_BANNER." SET NUM_STEP=$i WHERE NUM_OID=$_OID AND NUM_SERIAL=$_serial";
						$DB->query($sql);
						$DB->commit();
					}
				}
			break;
			case "delete":
				if($_POST['prevFile']) @unlink($file_dir.'/'.$_POST['prevFile']);
				$sql = "DELETE FROM ".TAB_BANNER." WHERE NUM_OID=$_OID AND NUM_SERIAL=".$_POST['id'];
				$DB->query($sql);
				$DB->commit();
			break;
		}

		// 캐쉬파일 삭제
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->delete(_DOC_ROOT.'/'.$cache_local_path);
		$FTP->close();

		WebApp::redirect($URL->setVar(array('act'=>'.list')));
	break;
}
?>