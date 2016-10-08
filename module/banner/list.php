<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-09
* 작성자: 이현민
* 설   명: 교육청 통합배너관리
*****************************************************************
str_type : S(학교관리배너), M(교육청관리배너)
* 
*/

$DB = &WebApp::singleton('DB');
$DOC_TITLE = "str:통합배너관리";
	if(!$_SESSION[ADMIN]){
	WebApp::moveBack('권한이없습니다.');
	exit;
	}
switch ($REQUEST_METHOD) {
	case "GET":

        $conf = Display::getMainConf('banner');
        
		$sql = "SELECT /*+ INDEX (".TAB_BANNER." ".IDX_TAB_BANNER.") */ NUM_OID,NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE, STR_TYPE, STR_SCHOOL FROM ".TAB_BANNER." WHERE NUM_OID=$_OID AND STR_TYPE='M'";
		


		if($data = $DB->sqlFetchAll($sql)) {
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
				$data[$i]['str_link'] = stripslashes($data[$i]['str_link']);

				$data[$i]['school']['E'] = substr($data[$i]['str_school'],0,1);
				$data[$i]['school']['M'] = substr($data[$i]['str_school'],1,1);
				$data[$i]['school']['H'] = substr($data[$i]['str_school'],2,1);
			}
		}

		$tpl->setLayout('@sub');
		$tpl->define("CONTENT", Display::getTemplate("banner/list.htm"));
		$tpl->assign(array(
            'LIST_banner'  => $data,

        ));
	break;
	case "POST":

		if(in_array("E",$school)) $school_E = "Y";
		else $school_E = "N";
		if(in_array("M",$school)) $school_M = "Y";
		else $school_M = "N";
		if(in_array("H",$school)) $school_H = "Y";
		else $school_H = "N";
		$str_school = $school_E.$school_M.$school_H;

		switch($mode = $_REQUEST['mode']) {
			case "write":
				$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
				$id = $DB->sqlFetchOne($sql) + 1;
				$sql = "SELECT MAX(NUM_STEP) FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
				$step = $DB->sqlFetchOne($sql) + 1;

				$field = 'NUM_OID,NUM_SERIAL,NUM_STEP,STR_TITLE,STR_LINK,CHR_OPEN,STR_TYPE,STR_SCHOOL';
				$value = "
					$_OID,
					$id,
					$step,
					'".addslashes(trim($_POST['str_title']))."',
					'".addslashes(trim($_POST['str_link']))."',
					'".$_POST['chr_open']."',
					'M',
					'$str_school'
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
						if(WebApp::saveThumbImg($_FILES['upfile']['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/banner/'.$str_file,154,46,100)) {
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
						"STR_TYPE='M',".
						"STR_SCHOOL='$str_school',".
						"CHR_OPEN='".$_POST['chr_open']."'";
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

						chmod($_FILES['upfile']['tmp_name'],0666);
						if(WebApp::saveThumbImg($_FILES['upfile']['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/banner/'.$str_file,154,46,100)) {
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