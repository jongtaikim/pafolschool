<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-03
* �ۼ���: ������
* ��   ��: ���Ͼ��ε�� Ŭ����
*****************************************************************
* 
*/


//���� �뷮 ä�� ���� �Լ�
if(!function_exists('OIDUploadFileSize')) {
function OIDUploadFileSize($num_up_size=0){
	global $_OID, $DB;

	//���ε� ��ũ ���ɿ뷮 üũ, �ִ� ���ε� ������ üũ
	$sql = "select num_disk, num_upload_size from TAB_ORGAN where num_oid = $_OID";

	$row2 = $DB -> sqlFetch($sql);

	$num_disk = $row2['num_disk'];
	$num_upload_size = $row2['num_upload_size'];

	$sql = "select num_size from TAB_UPLOAD_DATE where num_oid = $_OID and  num_date > ".mktime()."";
	$num_upload_size_ = $DB -> sqlFetchOne($sql);

	if($num_upload_size_ > 0  ){
		if($num_upload_size_ >=$num_up_size){
			$num_upload_size = $num_upload_size_;
		}
	}

	if($num_up_size >0 && ($_SESSION[CHR_MTYPE] == "t" || $_SESSION[CHR_MTYPE] == "a")) {
		$num_upload_size = $num_up_size ;
	}

	//��ġ�� ���°��� 200�Ⱑ�� ���� ���Ѵ�
	//if(!$num_disk) $num_disk=2*1024*1024*1024;
	if(!$num_disk) $num_disk=20*1024*1024*1024;
	//��ġ�� ���°�� 50mb�� ����
	if(!$num_upload_size) $num_upload_size=20*1024*1024;
	
	//���� ������� ��ũ�뷮üũ
	$sql = "select sum(num_size) from TAB_FILES where num_oid = $_OID";
	$db_num_size = $DB -> sqlFetchOne($sql);
	
	//���� ���� ��ũ�뷮 üũ
	$use_size = $num_disk-$db_num_size;

	if($use_size>1){
		//��ũ �������� ���� ��������.
		if($use_size < $num_upload_size){
			//1. ���������� �ִ���ε� ������� ������ ����������ŭ�� maxsize�� �����.
			$maxfilesize = $use_size;
		}else{
			//2. ���������� �ִ� ���ε� ������� ũ�Ƿ� �ִ���ε��������� ���ε� ����
			$maxfilesize = $num_upload_size;
		}

	}else{
		//��ũ �������� ��ã��. 1����Ʈ�� ����
		$maxfilesize = 1;
	}
	
	//������ ��ũ��뷮, ������ �ִ���ε������, ������ε�ũ��뷮, ������ũ��뷮, ���ε尡�������ϻ�����
	return array($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize);
}
}


if(!function_exists('byte_convert')) {
function byte_convert($bytes){
	$symbol = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	$exp = 0;
	$converted_value = 0;
	if( $bytes > 0 ){
		$exp = floor( log($bytes)/log(1024) );
		$converted_value = ( $bytes/pow(1024,floor($exp)) );
	}

	return sprintf( '%.2f'.$symbol[$exp], $converted_value );
	//return sprintf( '%d'.$symbol[$exp], $converted_value );
}
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
       $im = GDImageLoad($src_file);


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


$IsTrueColor = false;
$Extension = "";
class FileUpload { 
        var $Path; 
        var $Name; 
        var $Tmp; 
        var $Size; 
        var $convert_heightpe; 
		var $SaveName;
		var $SaveName_100;
        function FileUpload($name) { // Ŭ���� �ʱ�ȭ 
                $this->Name = $_FILES[$name]["name"]; 
                $this->Tmp  = $_FILES[$name]["tmp_name"]; 
                $this->Size = $_FILES[$name]["size"]; 
                $this->Type = $_FILES[$name]["type"]; 

				} 
        function file_mkdir () { // ���丮 ���� 
			if (!$this->Path) return false; 
				$path = explode("/",$this->Path);
				for($i=0;$i<count($path);$i++) {
					for($j=0;$j<=$i;$j++) {
						$path_dir .= $path[$j]."/";
					}
					if(eregi("org",$path_dir)) {
						$path_con_dir = str_replace("org","con",$path_dir);
						if (!file_exists($path_con_dir)) { 
							mkdir($path_con_dir,0707); 
							chmod($path_con_dir, 0777); 
						} 
					}
					if (!file_exists($path_dir)) { 
						mkdir($path_dir,0707); 
						chmod($path_dir, 0777); 
					} 
					$path_dir=$path_con_dir="";
				}

        } 
        function file_rename ($nummm) { // ���ϸ� �ڵ� �ο�  
				global $pcode,$mcode,$serial, $DB,$FH,$FTP,$_OID;

				//1010.1.2.1234229057.jpg
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				
				if($pcode) $num_pcode = $pcode."_"; else $num_pcode ="";
			
				$this->SaveName= $num_pcode.$mcode.".".$serial.".".$nummm.".".$file_ext; // �����Ͽ� ������ ȭ�ϸ�
				$this->SaveName_100= $num_pcode.$mcode.".".$serial.".".$nummm.".".$file_ext."_100"; // �����Ͽ� ������ ȭ�ϸ�

				$refile = date("Ym")."/".$this->SaveName;
				 $sql = "delete from TAB_FILES where num_oid= ".$FH->oid." and str_sect = '".$FH->sect."' and str_code = '".$FH->code."' and num_main ='".$serial."' and num_serial = '".$nummm."' ";
				 $DB->query($sql);
				 $DB->commit();
				

				
				$sql = 'INSERT INTO '.TAB_FILES.' ( '.
								'NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,'.
								'STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_DOWN,NUM_SIZE,DT_DATE'.
							') VALUES ('.
								$FH->oid.',\''.$FH->sect.'\',\''.$FH->code.'\','.$serial.','.$nummm.','.
								'\''.$this->Name.'\',\''.$refile.'\',\''.$file_ext.'\',0,'. $this->Size.','.mktime().''.
							')';
		
				

				$DB->query($sql);
				$DB->commit();
				

				

				if(!file_exists($this->Path.$this->SaveName)) { // �ߺ������� ������;;

						
						switch ($FH->sect) {
							case "menu":
														
							if ($DB->query("
							UPDATE
								TAB_BOARD
							SET
								num_file= num_file + 1
							WHERE
								num_oid = ".$FH->oid." and num_mcode=$mcode AND num_serial=$serial"
							)) $DB->commit();
							
							 break;
							case "party":
							$code_t = explode(".",$FH->code);
							if ($DB->query("
							UPDATE
								TAB_PARTY_BOARD
							SET
								num_file= num_file + 1
							WHERE
								num_oid = ".$FH->oid." and num_pcode = ".$code_t[0]." num_mcode=".$code_t[1]." AND num_serial=$serial"
							)) $DB->commit();
							break;
							}
						
						
						
							
				} 
        } 





        function file_rename2_tmp ($nummm) { // ���ϸ� �ڵ� �ο�  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName=$nummm.".gif"; // �����Ͽ� ������ ȭ�ϸ�
				
				if(file_exists($this->Path.$this->SaveName)) { // �ߺ������� ������;;
						$Tmp_SaveName = explode(".", $this->SaveName); 
						//$Tmp_SaveName[0] .= "_1"; 
						$this->SaveName = implode(".", $Tmp_SaveName); 
				} 
        } 

	        function file_renameExp ($nummm) { // ���ϸ� �ڵ� �ο�  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName=$nummm.".".$file_ext; // �����Ͽ� ������ ȭ�ϸ�
				
				if(file_exists($this->Path.$this->SaveName)) { // �ߺ������� ������;;
						$Tmp_SaveName = explode(".", $this->SaveName); 
						//$Tmp_SaveName[0] .= "_1"; 
						$this->SaveName = implode(".", $Tmp_SaveName); 
				} 
        } 
	
        function NewName ($newName) { // ���ϸ� ���� �ο� 
                $nTmp = explode(".", $this->Name); 
                $this->Name = $newName . "." . $nTmp[sizeof($nTmp)-1]; 
        } 
        function FileSizeChk ($size) { // mime type üũ - ���� �ҿ� ���� �� -_-; 
                if (!$this->Name or !$this->Size) return false; 
                if($this->Size > $size) return false; 
                return true; 
        } 

        function FileChk ($convert_heightpe) { // mime type üũ - ���� �ҿ� ���� �� -_-; 
                if (!$this->Name or !$this->Type) return false; 
                $fType = explode("/", $this->Type); 
                if($fType[0] != $convert_heightpe) return false; 
                return true; 
        } 
        function Ext ($allowed) { // ��� Ȯ���� 
                $allow = explode(",", $allowed); 
                $fTmp = explode(".", strtolower($this->Name)); 
                return in_array($fTmp[sizeof($fTmp)-1], $allow); 
        } 

        function upload () { // ���� ���ε� 
                if (!is_uploaded_file($this->Tmp) or ($this->Size == 0)) return false; 
				return move_uploaded_file($this->Tmp, $this->Path . $this->SaveName);
				
        } 



		function Resize_Image($convert_width="78",$convert_height="56",$resize_dir="") { 
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $resize_dir;
			$file = $this->SaveName;
			
			$ext = explode(".", strtolower($file)); // ������ Ȯ���ڸ� �����Ѵ�. .���� ������ �Ǹ��������� ������ 
			$ext = $ext[count($ext)-1];  // 
			 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 
			GDImageResize($dir."/".$file, $tdir."/".$file, $convert_width, $convert_height);

		} 

		function Resize_Imagethumb($convert_width="78",$convert_height="56",$resize_dir="") { 
			global $mcode,$serial, $DB,$FH,$FTP;
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $this->Path; 
			$file_ = $this->SaveName_100;
			$file = $this->SaveName;
			
			$ext = explode(".", strtolower($file)); // ������ Ȯ���ڸ� �����Ѵ�. .���� ������ �Ǹ��������� ������ 
			$ext = $ext[count($ext)-1];  // 
			 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 


			$normal_gallery=GetImageSize($dir.$file); 

			
			if($convert_width) $bbs_width = $convert_width; else $bbs_width =100;
			if($convert_height) $bbs_height = $convert_height; else $bbs_height =75;


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

	

			
			$_SESSION['get_thumb_filename'] = date('Ym')."/".$file;



			GDImageResize($dir."/".$file, $tdir."/".$file_, $img_w, $img_h);
			  
			  //�������� ���
			  /*$sql = "
                UPDATE
                    TAB_BOARD
                SET
                    str_thumb='".date("Ym")."/".$file."'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial";
		
			  if ($DB->query($sql)) $DB->commit();
			*/
		}



		function Resize_sum($convert_width="78",$convert_height="56") { 
			global $mcode,$serial, $DB,$FH,$FTP;
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			
			$file = $this->SaveName;
			
			$ext = explode(".", strtolower($file)); // ������ Ȯ���ڸ� �����Ѵ�. .���� ������ �Ǹ��������� ������ 
			$ext = $ext[count($ext)-1];  // 
			 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 


			$normal_gallery=GetImageSize($dir.$file); 

			
			if($convert_width) $bbs_width = $convert_width; else $bbs_width =100;
			if($convert_height) $bbs_height = $convert_height; else $bbs_height =75;


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

	

			
			
			GDImageResize($dir."/".$file, $dir."/".$file."_".$convert_width, $img_w, $img_h);
			  
			  //�������� ���
			  /*$sql = "
                UPDATE
                    TAB_BOARD
                SET
                    str_thumb='".date("Ym")."/".$file."'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial";
		
			  if ($DB->query($sql)) $DB->commit();
			*/
		}
} 



		function uploadFile($num){ //2009-07-02 ���� �ű� ���� ���ε�
		global $DB,$FH,$pcode,$mcode,$serial,$id,$uploadSize,$_conf;
			$tmpf = "upfile".$num;
			list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize($_conf[num_up_size]);
			
						
			$file = new FileUpload("upfile".$num); // datafile�� form������ �̸� 
			if($file->Size > 0) {
		
				$file->Path = $FH->file_dir."/".date("Ym")."/";  // �������� /�� �ٿ�����
				
				if(!$file->Ext("zip,arj,rar,gz,tgz,ace,Z,exe,pdf,doc,docx,hwp,xls,xlsx,ppt,pptx,bmp,jpg,jpeg,png,gif,txt,mp3,mp4,ogg,aiff,avi,mpg,mpeg,mov,rm,swf,flv,wmv,wma,ra,html,htm,alz,dat,ios,psd,xps")) {
				
				echo '<script>alert("'.$file->Name.' �� ���ε尡 ������ �ʴ� �����Դϴ�.");</script>';
				$fno = "y";
				 }


				if(!$file->FileSizeChk($maxfilesize)){
				echo '<script>alert("'.$file->Name.' �� 1ȸ ���ε� �뷮�� �ʰ��Ͽ� ���ε忡 �����Ͽ����ϴ�.\n\n���� 1ȸ���ε�� '.byte_convert($maxfilesize).'�� ���� �� �����ϴ�.");</script>';
				$fno = "y";
				}else{
			
				if($use_size > $file->Size ) {
				if($fno !="y"){
				$file->file_rename($num); 
				$file->upload();
				$file->Resize_Imagethumb("100","100",$file->Path.$file->SaveName);	
				}

				}else{
				echo '<script>alert("��ũ �뷮�� �����Ͽ� '.$num.'�� ���� ���ε带 �� �� �����ϴ�.");</script>';
				}
				}
			}
		}

?>