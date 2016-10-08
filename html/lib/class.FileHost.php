<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: class.FileHost.php
* �ۼ���: 2005-03-14
* �ۼ���: �̹���
* ��  ��: ���ϼ��� ���ε����� ��Ʈ��
*****************************************************************
* Dependency : class.DB.php, class.FtpClient.php
*/
if(!defined('TAB_FILES')) define('TAB_FILES','TAB_FILES');
if(!defined('DEFAULT_FILE_FTP_NUM')) define('DEFAULT_FILE_FTP_NUM','01');

class FileHost {
	var $oid;
	var $sect;			// 'menu' | 'main' | 'class' | 'ioffice' | 'club'
	var $code;
	var $host;
	var $root_dir;
	var $account;
	var $file_dir;
	var $ftp = false;
	var $thumb_target = false;
	var $disable_upload = false;
	var $FILE_LIST;

	function FileHost($sect='menu',$code='',$host='') {
		$this->oid = $GLOBALS['_OID'];
		$this->set_code($sect,$code);
		$this->set_host($host);
	}

	function set_oid($oid='') {
		if($oid != '') $this->oid = $oid;
	}

	function set_code($sect='menu',$code='') {
		if($code == '') $code = $_REQUEST['mcode'];
		$this->sect = $sect;
		$this->code = $code;
		$this->thumb_target = false;
		$this->file_dir = $this->root_dir.'/hosts/'.$this->oid.'/'.$this->sect;
	}

	function set_host($host='') {
		if($host) {
			$conf_file = 'hosts/'.$host.'/conf/global.conf.php';
			$conf = @parse_ini_file($conf_file,true);
			$s_num = $conf['file_ftp_num'];
			$this->oid = $conf['oid'];
		}
		if(!$s_num) $s_num = DEFAULT_FILE_FTP_NUM;
		$file_ftp_conf_section = 'file'.$s_num.'_account';
		if(!$ftp_conf) $ftp_conf = @parse_ini_file('conf/ftp.conf.php',true);
		$file_ftp_conf = $ftp_conf[$file_ftp_conf_section];
		$this->host = $GLOBALS['FILE_HOST'] = $file_ftp_conf['host'];
		$this->root_dir = $GLOBALS['FILE_FTP_ROOT'] = $file_ftp_conf['root_dir'];
		$this->account = array('host'=>$this->host,'user'=>$file_ftp_conf['user'],'pass'=>$file_ftp_conf['pass']);
		$this->file_dir = $this->root_dir.'/hosts/'.$this->oid.'/'.$this->sect;
		if(!$d_upload = WebApp::getConf('system.disable_upload','global')) $d_upload = array();
		$this->disable_upload = (@in_array($s_num,@explode(',',$d_upload)) || WebApp::getConf('disable_upload','local'));
	}

	function connect() {
		if(!$this->ftp) {
			WebApp::import('FtpClient');
			$this->ftp = new FtpClient($this->account);
      //echo "<xmp>";
      //print_R($this->ftp);
      //echo "</xmp>";
      //exit;
			if(!$this->ftp->conn) WebApp::raiseError('File Ftp Server ���� ����');
		}
		return $this->ftp;
	}

	function set_content($content) {
		if($file_list = $this->find_files($content)) {
			$GLOBALS['included_files_in_content'] = 
				$GLOBALS['included_files_in_content'] ?
				$GLOBALS['included_files_in_content'].'|'.implode('|',$file_list) : 
				implode('|',$file_list);
		}
		return str_replace(
			'src="http://%FILE_HOST%',
			'src="http://'.$this->host,
			$content
		);
	}

	function get_content($content) {
		return str_replace(
			'src="http://'.$this->host,
			'src="http://%FILE_HOST%',
			$content
		);
	}

	// html�� ���Ե� �̹��� ������ ã�´�.
	function find_files($content) {
		$content = $this->get_content($content);
		$pos_offset = 0;
		$check_url = 'src="http://%FILE_HOST%/hosts/'.$this->oid.'/'.$this->sect.'/';
		$check_len = strlen($check_url);
		while(is_long($pos = strpos($content, $check_url, $pos_offset))) {
			$pos += $check_len;
			$endpos = strpos($content,'"',$pos);
			$file_list[] = substr($content, $pos, $endpos-$pos);
			$pos_offset = $endpos + 1;
		}
		return $file_list;
	}





		function GDImageLoad($filename)
		{
			   global $IsTrueColor, $Extension;

			  $image_type = @GetImageSize($filename);

			   switch( $image_type[2] ) {
					  case 2: // JPEG�ϰ��
							 $im = imagecreatefromjpeg($filename);
							 $Extension = "jpg";
							 break;
					  case 1: // GIF�� ���
							 $im = imagecreatefromgif($filename);
							 $Extension = "gif";
							 break;
					  case 3: // png�� ���
							 $im = imagecreatefrompng($filename);
							 $Extension = "png";
							 break;
					  default:
							 break;
			   }

			   $IsTrueColor = @imageistruecolor($im);

			   return $im;
		}




		function GDImageResize($src_file, $dst_file, $width = "", $height = "", $type = "", $quality = 85)
		{
			   global $IsTrueColor, $Extension;
		//		echo $src_file;
			   $im = $this->GDImageLoad($src_file);

			   if( !$im ) return false;

			   if( !$width ) $width = imagesx($im);
			   if( !$height ) $height = imagesy($im);

			   if( $IsTrueColor && $type != "gif" ) $im2 = imagecreatetruecolor($width, $height);
			   else $im2 = imagecreate($width, $height);

			   if( !$type ) $type = $Extension;

			   imagecopyresampled($im2, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));

			   if( $type == "gif" ) {
					  imagegif($im2, $dst_file);
			   }
			   else if( $type == "jpg" || $type == "jpeg" ) {
					  imagejpeg($im2, $dst_file, $quality);
			   }
			   else if( $type == "png" ) {
					  imagepng($im2, $dst_file);
			   }

			   imagedestroy($im);
			   imagedestroy($im2);

			   return true;
		}





	// ���ε��� ���� ó��(�ӽ� ���丮���� ���� ���丮�� �ű��)
	function upload_process($timestamp,$main,$ym_dir = false) {
		$this->connect();
		if($ym_dir === false) $ym_dir = date('Ym');
		if(!$this->ftp->chdir($this->file_dir.'/'.$ym_dir)) {
			if(!$this->ftp->chdir($this->file_dir)) {
				$this->ftp->chdir($this->root_dir.'/hosts/'.$this->oid);
				$this->ftp->mkdir($this->sect);
				$this->ftp->chdir($this->file_dir);
			}
			
			
			

			$this->ftp->mkdir($ym_dir);
		}
		$DB = &WebApp::singleton('DB');
		$sql = 'SELECT MAX(NUM_SERIAL) FROM '.TAB_FILES.'
				WHERE '.
					'NUM_OID='.$this->oid.' AND '.
					'STR_SECT=\''.$this->sect.'\' AND '.
					'STR_CODE=\''.$this->code.'\' AND '.
					'NUM_MAIN='.$main;

				
		$serial = $DB->sqlFetchOne($sql) + 1;
		$source_dir = $this->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID'].'/'.$timestamp;
		$this->ftp->chdir($source_dir);

		if($upfile_list = $this->ftp->getList($source_dir)) {

			foreach($upfile_list as $item) {
				$ext = strtolower(array_pop(explode('.',$item['filename'])));
		        $refile = $ym_dir.'/'.$this->code.'.'.$main.'.'.$serial.'.'.$timestamp.'.'.$ext;
				$target_path = $this->file_dir.'/'.$refile;

        if($this->ftp->rename($item['filename'],$target_path)) {
					$filesize = ftp_size($this->ftp->conn,$target_path);

					$sql = 'INSERT INTO '.TAB_FILES.' ( '.
								'NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,'.
								'STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE,DT_DATE'.
							') VALUES ('.
								$this->oid.',\''.$this->sect.'\',\''.$this->code.'\','.$main.','.$serial.','.
								'\''.$item['filename'].'\',\''.$refile.'\',\''.$ext.'\',0,'.$filesize.',SYSDATE'.
							')';
				
					$DB->query($sql);
					$DB->commit();

					$file_list[] = array(
						'num_main'=>$main,
						'num_serial'=>$serial,
						'str_upfile'=>$item['filename'],
						'str_refile'=>$refile,
						'str_ftype'=>$ext,
						'num_size'=>$filesize
					);


					//2008-04-17 ���� �̹��� üũ 
					if($ext == "jpg" || $ext == "gif" || $ext == "png"){
	

					$size=GetImageSize($target_path); 
				
								
					if($size[0] > 800) {
					//2008-04-17 ���� ���Ѻ��� �ٲ��
					if(!$this->ftp->chmod($this->file_dir."/".date("Ym"),"777")){
					echo '<script>alert("���Ѽ��� ����");</script>';
				
					}

					//2008-04-17 ���� 800 ���� ũ�� GD�� �ٿ�~!!!
					if(!$this->GDImageResize($target_path , $target_path."_800" , "800", "600")){
					echo '<script>alert("�̹��� ����� ���̴µ� �����߽��ϴ�.");</script>';
					}else{
					$this->ftp->delete($target_path);
					$this->ftp->rename($target_path."_800", $target_path);
					}
					
								
				}

					

					}

					if(!$this->thumb_target && eregi('(jpe?g|gif|png)',$ext)) $this->thumb_target = $refile;
					$serial++;
				}
			}
		}
		$this->rm_tmp_dir($timestamp);
		return $file_list;
	
	}


//2008-05-10 ���� �ӽ÷� ���ε� ó���Ѵ�.
	function upload_process_tmp($timestamp,$main,$ym_dir = false) {
		$this->connect();
		if($ym_dir === false) $ym_dir = date('Ym');
		if(!$this->ftp->chdir($this->file_dir.'/'.$ym_dir)) {
			if(!$this->ftp->chdir($this->file_dir)) {
				$this->ftp->chdir($this->root_dir.'/hosts/'.$this->oid);
				$this->ftp->mkdir($this->sect);
				$this->ftp->chdir($this->file_dir);
			}
			
			$this->ftp->mkdir($ym_dir);
		}
		$DB = &WebApp::singleton('DB');
		$sql = 'SELECT MAX(NUM_SERIAL) FROM '.TAB_FILES.'
				WHERE '.
					'NUM_OID='.$this->oid.' AND '.
					'STR_SECT=\''.$this->sect.'\' AND '.
					'STR_CODE=\''.$this->code.'\' AND '.
					'NUM_MAIN='.$main;

				
		$serial = $DB->sqlFetchOne($sql) + 1;
		if(!$serial) $serial  = 1;
		$source_dir = $this->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID'].'/'.$timestamp;
		$this->ftp->chdir($source_dir);

		if($upfile_list = $this->ftp->getList($source_dir)) {

			foreach($upfile_list as $item) {
				$ext = strtolower(array_pop(explode('.',$item['filename'])));
		        $refile = $ym_dir.'/'.$this->code.'.'.$main.'.'.$serial.'.'.$timestamp.mktime().'.'.$ext;
				$target_path = $this->file_dir.'/'.$refile;

        if($this->ftp->rename($item['filename'],$target_path)) {
					$filesize = ftp_size($this->ftp->conn,$target_path);


					$file_list[] = array(
						'num_main'=>$main,
						'num_serial'=>$serial,
						'str_upfile'=>$item['filename'],
						'str_refile'=>$refile,
						'str_url'=> $this->get_real_url($refile),
						'str_ftype'=>$ext,
						'num_size'=>$filesize
					);
					



					//2008-04-17 ���� �̹��� üũ 
					if($ext == "jpg" || $ext == "gif" || $ext == "png"){
					
					$sql = 'INSERT INTO '.TAB_FILES.' ( '.
						'NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,'.
						'STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE,DT_DATE'.
					') VALUES ('.
						$this->oid.',\''.$this->sect.'\',\''.$this->code.'\','.$main.','.$serial.','.
						'\''.$item['filename'].'\',\''.$refile.'\',\''.$ext.'\',0,'.$filesize.',SYSDATE'.
					')';
		
					$DB->query($sql);
					$DB->commit();

					$normal_gallery=GetImageSize($target_path); 
				
		
					$bbs_width = 1000;
					$bbs_height = 1000;
							
					$ratio1 = $bbs_width/$normal_gallery[0]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ��� 
					$ratio2 = $bbs_height/$normal_gallery[1]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ��� 

					if($ratio1 >= 1 && $ratio2 >= 1 )
					{
					  $img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ��� 
					  $img_h = $normal_gallery[1]; 
					}
					elseif($ratio1 > $ratio2)
					{
					   $img_w = $normal_gallery[0]*$ratio2; // �������� ���ο� ���ο� ������ ���� ����
					   $img_h = $normal_gallery[1]*$ratio2; // ���� ���� ���� ���� 
					}
					  elseif($ratio1 <= $ratio2)
					{
					   $img_w = $normal_gallery[0]*$ratio1; // �������� ���ο� ���ο� ������ ���� ����
					   $img_h = $normal_gallery[1]*$ratio1; // ���� ���� ���� ���� 
					}
					  else
					{
					  $img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ��� 
					  $img_h = $normal_gallery[1]; 
					}
								
													



					if($normal_gallery[0] > 800) {
					

					
					//2008-04-17 ���� ���Ѻ��� �ٲ��
					if(!$this->ftp->chmod($this->file_dir."/".date("Ym"),"777")){
					echo '<script>alert("���Ѽ��� ����");</script>';
				
					}

					//2008-04-17 ���� 800 ���� ũ�� GD�� �ٿ�~!!!
					if(!$this->GDImageResize($target_path , $target_path."_800" , $img_w, $img_h)){
					echo '<script>alert("�̹��� ����� ���̴µ� �����߽��ϴ�.");</script>';
					}else{
					$this->ftp->delete($target_path);
					$this->ftp->rename($target_path."_800", $target_path);
					}
					
								
				}

					


					}else{
					


					$sql = 'INSERT INTO '.TAB_FILES.' ( '.
						'NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,'.
						'STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE,DT_DATE'.
					') VALUES ('.
						$this->oid.',\''.$this->sect.'\',\''.$this->code.'\','.$main.','.$serial.','.
						'\''.$item['filename'].'\',\''.$refile.'\',\''.$ext.'\',0,'.$filesize.',SYSDATE'.
					')';
		
					$DB->query($sql);
					$DB->commit();

					}

			


					

					if(!$this->thumb_target && eregi('(jpe?g|gif|png)',$ext)) $this->thumb_target = $refile;
					$serial++;
				}
			}
		}
		$this->rm_tmp_dir($timestamp);
		//return $sql;
		return $file_list;
	
	}





	// html �� ���ε� ������ ���Եƴ��� ã�Ƴ���.
	function find_upload($content,$main = -1,$del_main = -2) {
		$prev_files = $_POST['included_files_in_content'] ? explode('|',$_POST['included_files_in_content']) : array();
		$file_list = $this->find_files($content);
		if($file_list) {
			$DB = &WebApp::singleton('DB');
			$sql = 'SELECT MAX(NUM_SERIAL) FROM '.TAB_FILES.'
					WHERE '.
						'NUM_OID='.$this->oid.' AND '.
						'STR_SECT=\''.$this->sect.'\' AND '.
						'STR_CODE=\''.$this->code.'\' AND '.
						'NUM_MAIN='.$main;
			$serial = $DB->sqlFetchOne($sql) + 1;
			foreach($file_list as $file) {
				if(!$this->thumb_target && eregi("(.)+\\.(jp(e){0,1}g$|gif$|png$)",$file)) $this->thumb_target = $file;
				if(in_array($file,$prev_files)) continue;
				$sql = 'UPDATE '.TAB_FILES.' SET '.
							'NUM_MAIN='.$main.','.
							'NUM_SERIAL='.$serial.
						' WHERE '.
							'NUM_OID='.$this->oid.' AND '.
							'STR_SECT=\''.$this->sect.'\' AND '.
							'STR_CODE=\''.$this->code.'\' AND '.
							'STR_REFILE=\''.$file.'\'';
				$DB->query($sql);
				$DB->commit();
				$serial++;
			}
		}
		if(!$DB) $DB = &WebApp::singleton('DB');
		foreach($prev_files as $prev_file) {
			if(in_array($prev_file,$file_list)) continue;
			$this->delete($prev_file);
			$sql = 'DELETE FROM '.TAB_FILES.' WHERE '.
					'NUM_OID='.$this->oid.' AND '.
					'STR_SECT=\''.$this->sect.'\' AND '.
					'STR_CODE=\''.$this->code.'\' AND '.
					'STR_REFILE=\''.$prev_file.'\'';
			$DB->query($sql);
			$DB->commit();
		}
		$this->delete_trash($del_main);
		return $file_list;
	}

	// html���� �̹��������� ã�� �����Ѵ�.
	function delete_as_html($content) {
		$file_list = $this->find_files($content);
		if($file_list) {
			$DB = &WebApp::singleton('DB');
			foreach($file_list as $file) {
				$sql = 'DELETE FROM '.TAB_FILES.'
						WHERE
							NUM_OID='.$this->oid.' AND
							STR_SECT=\''.$this->sect.'\' AND
							STR_CODE=\''.$this->code.'\' AND
							STR_REFILE=\''.$file.'\'';
				if($DB->query($sql) && $this->delete($file)) $DB->commit();
			}
		}
	}

	// ����� ����� ��û
	function make_thumb($filename, $width = 100) {
		if(!$width) $width = 100;
		WebApp::import('HTTP');
		$HTTP = HTTP::Connection('http://'.$this->host.'/index.php');
		$HTTP->setVar('act','makethumb');
		$HTTP->setVar('oid',$this->oid);
		$HTTP->setVar('sect',$this->sect);
		$HTTP->setVar('code',$this->code);
		$HTTP->setVar('filename',$filename);
		$HTTP->setVar('width',$width);
		$HTTP_RET = $HTTP->get();
		return trim($HTTP_RET->body);
	}

	// ����� ����
	function del_thumb($filenames, $width = 100) {
		if(!$filenames) return;
		if(!$width) $width = 100;
		$this->connect();
		if(!is_array($filenames)) $filenames = array($filenames);
		foreach($filenames as $filename) {
			$_filename = explode('.',$filename);
			$ext = array_pop($_filename);
			$thumbname = implode('.',$_filename).'.thumb'.$width.'.'.$ext;
			$this->delete($thumbname);
		}
	}

	// ����� URL
	function get_thumb_url($filename, $width = 100) {
		if(!$width) $width = 100;
		return 'http://'.$this->host.'/thumb/'.$this->oid.'/'.
				$this->sect.'/'.$width.'/'.$filename;
	}

	// ���ϻ���(�ش� ID�� ������� �� DB ����)
	function delete_as_main($main) {
		$DB = &WebApp::singleton('DB');
		$sql_where = ' WHERE '.
			'NUM_OID='.$this->oid.' AND '.
			'STR_SECT=\''.$this->sect.'\' AND '.
			'STR_CODE=\''.$this->code.'\' AND '.
			'NUM_MAIN='.$main;
		$sql = 'SELECT STR_REFILE
				FROM '.TAB_FILES.' '.$sql_where;
		if($data = $DB->sqlFetchAll($sql)) {
			foreach($data as $row) $this->delete($row['str_refile']);
			$sql = 'DELETE FROM '.TAB_FILES.' '.$sql_where;
			$DB->query($sql);
			$DB->commit();
		}
	}

	// editor�� ���� ���������ϻ���(num_main=-2 �� ������ 1�ð� ���� ���� ����)
	function delete_trash($main = -2, $timestamp = false) {
		if(!$timestamp) $timestamp = date('U') - 3600;
		$date = date('Y-m-d H:i:s',$timestamp);
		$DB = &WebApp::singleton('DB');
		$sql_where = ' WHERE '.
			'NUM_OID='.$this->oid.' AND '.
			'STR_SECT=\''.$this->sect.'\' AND '.
			'STR_CODE=\''.$this->code.'\' AND '.
			'NUM_MAIN='.$main.' AND '.
			'DT_DATE<TO_DATE(\''.$date.'\',\'YYYY-MM-DD HH24:MI:SS\')';
		$sql = 'SELECT STR_REFILE
				FROM '.TAB_FILES.' '.$sql_where;
		if($data = $DB->sqlFetchAll($sql)) {
			$sql = 'DELETE FROM '.TAB_FILES.' '.$sql_where;
			$DB->query($sql);
			$DB->commit();
			foreach($data as $row) $this->delete($row['str_refile']);
		}
	}

	// ���ϻ���(�ش� CODE�� ������� �� DB ����)
	function delete_as_code($sect = false, $code = false) {
		if(!$sect) $sect = $this->sect;
		if(!$code) $code = $this->code;
        $this->set_code($sect,$code);
		$DB = &WebApp::singleton('DB');
		$sql_where = ' WHERE '.
			'NUM_OID='.$this->oid.' AND '.
			'STR_SECT=\''.$sect.'\' AND '.
			'STR_CODE=\''.$code.'\'';
		$sql = 'SELECT STR_REFILE
				FROM '.TAB_FILES.' '.$sql_where;
		if($data = $DB->sqlFetchAll($sql)) {
			foreach($data as $row) $this->delete($row['str_refile']);
			$sql = 'DELETE FROM '.TAB_FILES.' '.$sql_where;
			$DB->query($sql);
			$DB->commit();
		}
	}
	
	// ÷������ ���� ��������
	function get_files_info($main) {
		$DB = &WebApp::singleton('DB');
		$sql = 'SELECT STR_CODE,NUM_SERIAL,STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE,NUM_TA '.
				'FROM '.TAB_FILES.' '.
				'WHERE '.
					'NUM_OID='.$this->oid.' AND '.
					'STR_SECT=\''.$this->sect.'\' AND '.
					'STR_CODE=\''.$this->code.'\' AND '.
					'NUM_MAIN='.$main;

//echo $sql;

		if($data = $DB->sqlFetchAll($sql)) {
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			
				if($data[$i]['num_ta']) {
					

				//2008-03-07 ���� Ÿ����Ʈ ÷������ ���������� ó��
				$data[$i]['file_url'] = 'http://'.$_SERVER[HTTP_HOST].'/data/hosts/'.$this->oid.'/'.$data[$i]['num_ta']."/".$data[$i]['str_refile'];
                
				$data[$i]['real_url'] = 
				'http://'.$_SERVER[HTTP_HOST].'/data/hosts/'.$this->oid.'/'.$data[$i]['num_ta']."/".$data[$i]['str_refile'];
				$total_size += $data[$i]['num_size'];


				}else{
				
				$data[$i]['file_url'] = 'http://'.$this->host.'/download/'.$this->oid.'/'.$this->sect.'/'.$this->code.
										'/'.$main.'/'.$data[$i]['num_serial'].'/'.$data[$i]['str_upfile'];
                
				$data[$i]['real_url'] = $this->get_real_url($data[$i]['str_refile']);
				$total_size += $data[$i]['num_size'];
				
				}
			
			}
			$data['total_size'] = $total_size;
		}
		return $data;
		//return $sql;
	}



	function get_files_info22($main) {
		$DB = &WebApp::singleton('DB');
		$sql = 'SELECT STR_CODE,NUM_SERIAL,STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE '.
				'FROM BOOKMART.BS_FILES '.
				'WHERE '.
					'NUM_OID=1 AND '.
					'STR_SECT=\'book\' AND '.
					'STR_CODE=\'book\' AND '.
					'NUM_MAIN='.$main;
		//echo $sql;
		if($data = $DB->sqlFetchAll($sql)) {
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
				$data[$i]['file_url'] = 'http://'.$this->host.'/download/'.$this->oid.'/'.$this->sect.'/'.$this->code.
										'/'.$main.'/'.$data[$i]['num_serial'].'/'.$data[$i]['str_upfile'];
				$total_size += $data[$i]['num_size'];
			}
			$data['total_size'] = $total_size;
		}
		return $data;
	}

	// ������ ���� URL
	function get_real_url($refile) {
		return 'http://'.$this->host.'/hosts/'.$this->oid.'/'.$this->sect.'/'.$refile;
	}

	// ���ϻ���(���ϸ� ����)
	function delete($filename) {
		if(!$filename) return;
		$this->connect();
		return $this->ftp->delete($this->file_dir.'/'.$filename);
	}

	// hosts/$oid ���� ����
	function make_host($oid) {
		$this->connect();
		$this->ftp->chdir($this->root_dir.'/hosts');
		return $this->ftp->mkdir($oid);
	}

	// (��Ͻ��� ��)�ӽ� ���丮�� ���ϰ� ���丮 ��� ����
	function rm_tmp_files($timestamp,$main = -2) {
		$this->connect();
		$source_dir = $this->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID'].'/'.$timestamp;
		$this->ftp->chdir($source_dir);
		if($upfile_list = $this->ftp->getList($source_dir)) {
			foreach($upfile_list as $item) {
				$source_path = $source_dir.'/'.$item['filename'];
				$this->ftp->delete($source_path);
			}
			$this->rm_tmp_dir($timestamp);
		}
		$this->delete_trash($main);
	}

	// �ӽõ��丮 ����
	function rm_tmp_dir($timestamp) {
		$this->connect();
		$this->ftp->chdir($this->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID']);
		$this->ftp->rmdir($timestamp);
		$this->ftp->chdir($this->root_dir.'/tmp_upload');
		$this->ftp->rmdir($_COOKIE['PHPSESSID']);
	}

	// FTP ���� �ݱ�
	function close() {
		if($this->ftp) $this->ftp->close();
		$this->ftp = false;
	}







}
?>