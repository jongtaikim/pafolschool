<?php
/**

* �ۼ���: 2007-06-21
* �ۼ���: ������
* ��  ��: ���/����
*****************************************************************
*/

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];

$_OID2 = "1"; // ���̳�ũ ���������� 1�� ������

switch($REQUEST_METHOD) {
	
	case "GET":
			
			
			
		$tpl->setLayout('menu_nog');
		$tpl->define('CONTENT','html/admin/write.htm');

		if($id) {
			$sql = "SELECT 
						STR_TITLE,
						STR_TEXT1,
						STR_TEXT2,
						STR_TEXT3,
						TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
						NUM_HIT,
						STR_THUMB
					FROM ".TAB_MAIN_BOARD."
					WHERE
						NUM_OID=$_OID2 AND
						STR_CODE='$code' AND
						NUM_SERIAL=$id";
			$data = $DB->sqlFetch($sql);
			$data['id'] = $id;
			$data['content'] = $data['str_text1'].$data['str_text2'].$data['str_text3'];
			$data['content'] = $FH->set_content($data['content']);
			
			if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);
		} else {
			$data['dt_date2'] = date('Y-m-d');
			$data['num_hit'] = '0';
		}
		$data['title'] = $title;
		$data['code'] = $code;
		
		$data['str_title2'] = $data['str_title'];
	

		$tpl->assign($data);
	break;
	case "POST":
		
				
  
  
  /* ������Ʈ�� ���� �ΰ�üũ ���⼭ �� ����*/
   if(!$str_title)
   {
   echo "
		            <script>
		            alert('������ �Է����ּ���');
		            history.go(-1);
		            </script>
		            ";   
    }


   if(!$content)
   {
   echo "
		            <script>
		            alert('������ �Է����ּ���');
		            history.go(-1);
		            </script>
		            ";   
    }
  
  
  /* ������Ʈ�� ���� �ΰ�üũ ���⼭ �� ��*/
   
		

		$content = $FH->get_content($_POST['content']);
		list($str_text1,$str_text2,$str_text3) = content_split($content);

    $str_text1=@str_replace("\'","''",$str_text1);
    $str_text2=@str_replace("\'","''",$str_text2);
    $str_text3=@str_replace("\'","''",$str_text3);

    if($id = $_POST['id']) {
			// ����
			$sql = 
				"UPDATE ".TAB_MAIN_BOARD." SET ".
					"STR_TITLE='".strip_tags($_POST['str_title'])."',".
					"STR_TEXT1='".$str_text1."',".
					"STR_TEXT2='".$str_text2."',".
					"STR_TEXT3='".$str_text3."',".
					"DT_DATE=TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),".
					"NUM_HIT=".$_POST['num_hit'].
				" WHERE ".
					"NUM_OID=".$_OID2." AND ".
					"STR_CODE='".$code."' AND ".
					"NUM_SERIAL=".$id;
		} else {
			// ���
			$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2 AND STR_CODE='$code'";
			$id = $DB->sqlFetchOne($sql) + 1;
			$sql = 
				"INSERT INTO ".TAB_MAIN_BOARD." (".
					"NUM_OID,STR_CODE,NUM_SERIAL,STR_TITLE,STR_TEXT1,STR_TEXT2,STR_TEXT3,CHR_HTML,DT_DATE,NUM_HIT".	
				") VALUES (".
					$_OID2.",".
					"'".$code."',".
					$id.",".
					"'".strip_tags($_POST['str_title'])."',".
					"'".$str_text1."',".
					"'".$str_text2."',".
					"'".$str_text3."',".
					"'Y',".
					"TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),".
					$_POST['num_hit'].
	    
	    			")";
	    		
		
		}
		
		if($DB->query($sql)) {
			$DB->commit();



			// {{{ ���ε� ���� ó��
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			if($FH->thumb_target && $FH->thumb_target != $_POST['str_thumb']) {
				if($_POST['str_thumb']) $FH->del_thumb($_POST['str_thumb']);
				if($conf['use_thumb']) {
					$sql = "UPDATE ".TAB_MAIN_BOARD." SET STR_THUMB='".$FH->thumb_target."'
							WHERE NUM_OID=$_OID2 AND STR_CODE='new.$code' AND NUM_SERIAL=$id";
					$DB->query($sql);
					$DB->commit();
				}
			}
			$FH->rm_tmp_dir();
			$FH->close();
			// }}}

			// ĳ������
			$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
			$FTP->delete(_DOC_ROOT.'/'.$cache_file);
			$FTP->close();

			
			
			/*�����Ե鵵 �ȳ���۾��Ⱑ �����ϰ� ���α׷��������� 9.15*/
			if($flg!='t')
			{
			    WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'')));
		    }else{
		        
		            echo "
		            <script>
		            alert('��ϵǾ����ϴ�');
		            opener.location.reload();
		            self.close();
		            </script>
		            ";
		            
		    
		    /*�����Ե鵵 �ȳ���۾��Ⱑ �����ϰ� ���α׷������� 9.15*/
		    }
		
		
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

			WebApp::raiseError('DB Insert Failed');
		}
	break;
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}
?>