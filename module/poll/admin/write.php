<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: write.php
* �ۼ���: 2005-03-24
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
	
		$mtypes = WebApp::get('member',array('key'=>'member_types'));
		$tpl->define("CONTENT","html/poll/admin/write.htm");

		if($id = $_REQUEST['id']) {
			$DB = &WebApp::singleton('DB');
			$sql = "SELECT
						*
					FROM ".TAB_POLL_MAIN."
					WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
			if(!$data = $DB->sqlFetch($sql)) WebApp::raiseError('�����׸��� ã�� �� �����ϴ�.');
			$data['id'] = &$data['num_serial'];
			$sql = "SELECT * FROM ".TAB_POLL_CONTENTS." WHERE NUM_OID=$_OID AND NUM_MAIN=$id";
			$data['LIST'] = $DB->sqlFetchAll($sql);

			if($data[chr_check] == 'cd'){
				$sql = "select str_code from TAB_POLL_CODE where NUM_OID=$_OID AND NUM_MAIN=$id";
				$cddata = $DB->sqlFetchAll($sql);
				for($a=0; $a<sizeof($cddata) ; $a++){
					$data['cddata'][] = $cddata[$a]['str_code'];
				}
			}
			$data['groups'] = explode(",",$data['str_poll_group']);
			
			$data['dt_start_date'] = date('Y-m-d',$data['dt_start_date'] );
			$data['dt_finish_date'] = date('Y-m-d',$data['dt_finish_date'] );

		} else {
			$data['dt_start_date'] = $data['dt_finish_date'] = date('Y-m-d');
		}

		$tpl->assign($data);
		$tpl->assign(array(
			'MTYPES'=>$mtypes,
		));
	break;
	case "POST":
		$DB = &WebApp::singleton('DB');

		$str_title = strip_tags($_POST['str_title']);
		$dt_start_date = $_POST['dt_start_date'];
		$dt_finish_date = $_POST['dt_finish_date'];
		$chr_check = $_POST['chr_check'];
		$chr_result = $_POST['chr_result'];
		$mytypes = $_POST['mytypes'];
		$str_poll_group = $_POST['str_poll_group'];

		if($chr_check == 'mt'){
			//ȸ�����Ѻ� üũ 
			$chr_group = implode(",", $mytypes);
		}elseif($chr_check == 'cd'){
			//�ڵ�Ÿ��
			if($ccnt > 900){
				WebApp::moveBack('�����ڵ�� �ִ� 900������ �߱ް����մϴ�.');
			}
			if(!$ccnt && !$str_poll_group){
				WebApp::moveBack('�����ڵ���� �Է��ϼ���.');
			}

			if($str_poll_group){
				$chr_group = $str_poll_group;
			}else{
				for($a=1 ; $a<=$ccnt ; $a++){
					$microtime = md5(microtime()*$a);
					$chr_group .= strtoupper(substr($microtime, -4));
					if($a != $ccnt) $chr_group .= ",";
				}
			}

		}
		

		include 'module/file.php';
		
	
		$FH = &WebApp::singleton('FileHost');

		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

		
		$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/poll/");
		$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/poll/",777);
			
		$dt_start_date_ = explode("-",$dt_start_date);
		$dt_finish_date_ = explode("-",$dt_finish_date);
			
		$dt_start_date=mktime(0,0,0,$dt_start_date_[1],$dt_start_date_[2],$dt_start_date_[0]);
		$dt_finish_date=mktime(23,59,59,$dt_finish_date_[1],$dt_finish_date_[2],$dt_finish_date_[0]);
	
		
		
		if($id = $_REQUEST['id']) {
			// ����
			$sql = "UPDATE ".TAB_POLL_MAIN." SET
						STR_TITLE='$str_title',
						DT_START_DATE='$dt_start_date',
						DT_FINISH_DATE='$dt_finish_date',
						CHR_CHECK='$chr_check',
						CHR_RESULT='$chr_result',
						STR_POLL_GROUP='$chr_group',
						STR_TYPE='$str_type'
					WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
		} else {
			// ���
			$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_POLL_MAIN." WHERE NUM_OID=$_OID";
			$id = $DB->sqlFetchOne($sql) + 1;
			$sql = "INSERT INTO ".TAB_POLL_MAIN." (
						NUM_OID,NUM_SERIAL,STR_SECT,STR_TITLE,DT_START_DATE,
						DT_FINISH_DATE,CHR_CHECK,CHR_RESULT,DT_DATE,STR_POLL_GROUP,STR_TYPE
					) VALUES (
						$_OID,$id,'$sect','$str_title','$dt_start_date',
						'$dt_finish_date','$chr_check','$chr_result','".mktime()."', '$chr_group','$str_type'
					)";
		}

		if($DB->query($sql)) {
			$DB->commit();
			
		
			
			

			for($ii=0; $ii<count($contents); $ii++) {
				$ia = $ii+1;
				$upfiles_name[$ii] = "upfile".$ia;
				$upfiles_name_del[$ii] = "upfile_del".$ia;
				
				if($$upfiles_name_del[$ii]){
				
				$pupsql[$ii] = " , str_file = '' ";
				unlink(_DOC_ROOT."/hosts/".HOST."/poll/".$$upfiles_name_del[$ii]);
				
				}else{

				if($$upfiles_name[$ii]) {
				$file = new FileUpload($upfiles_name[$ii]); // datafile�� form������ �̸� 
				$file->Path = _DOC_ROOT."/hosts/".HOST."/poll/";  // �������� /�� �ٿ�����

				//$file->file_mkdir(); 
				if(!$file->Ext("gif,jpg,png"))  {
				echo '<script>alert("�̹��� ���ϸ� �����մϴ�.");  </script>';
				exit;
				 }
				$mk = mktime();

				$file->file_rename2_tmp($id."-".$ia); 
				if(!$file->upload()){
				echo '<script>alert("���ε忡 ���� �߽��ϴ�.");  </script>';
				exit;
				}
				$file->upload();
				
				GDImageResize(_DOC_ROOT."/hosts/".HOST."/poll/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/poll/".$file->SaveName."_100", '100', '100');

				//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �̹����϶� ���� ���� ������� ������

				$files[$ii][file_name] = $file->SaveName;

				$pupsql[$ii] = " , str_file = '".$files[$ii][file_name]."' ";
				}
				
				}
	
			}


			// �׸� ���/����
			$old_contents_num = $_POST['old_contents_num'];
			$contents = $_POST['contents'];
			$votes = $_POST['votes'];
			$cids = $_POST['cids'];
			$cnt = max($old_contents_num,count($cids));
			for($i=0;$i<$cnt;$i++) {
				$content = trim(strip_tags($contents[$i]));
				$vote = ((int)$votes[$i] < 1 ? 0 : (int)$votes[$i]);
				$cid = $cids[$i];
				if($content == '' && ($old_contents_num > $i)) {
					// ����
					$sql = "DELETE FROM ".TAB_POLL_CONTENTS."
							WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND NUM_SERIAL=$cid";
				} else {
					if($old_contents_num > $i) {
						// ����
						$sql = "UPDATE ".TAB_POLL_CONTENTS." SET STR_CONTENTS='$content' ".$pupsql[$i]."
								WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND NUM_SERIAL=$cid";
					} else {
						// �߰�
						$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_POLL_CONTENTS." WHERE NUM_OID=$_OID";
						$cid = $DB->sqlFetchOne($sql) + 1;
						$sql = "INSERT INTO ".TAB_POLL_CONTENTS." (
									NUM_OID,NUM_MAIN,NUM_SERIAL,STR_CONTENTS,NUM_VOTE ,STR_FILE
								) VALUES (
									$_OID,$id,$cid,'$content',0,'".$files[$ii][file_name]."'
								)";
					}
				}
				if($DB->query($sql)) $DB->commit();
			}

			// ĳ�� ����
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->delete(_DOC_ROOT.'/'.$cache_file);
			$FTP->close();

			WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'')),'����Ǿ����ϴ�.');
		} else {
			WebApp::raiseError('���忡 �����Ͽ����ϴ�.');
		}
	break;
}


?>