<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-03
* 작성자: 김종태
* 설   명: 파일업로드용 클래스
*****************************************************************
* 
*/


//파일 용량 채근 관련 함수
if(!function_exists('OIDUploadFileSize')) {
function OIDUploadFileSize($num_up_size=0){
	global $_OID, $DB;

	//업로드 디스크 가능용량 체크, 최대 업로드 사이즈 체크
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

	//수치가 없는경우는 200기가로 세팅 무한대
	//if(!$num_disk) $num_disk=2*1024*1024*1024;
	if(!$num_disk) $num_disk=20*1024*1024*1024;
	//수치가 없는경우 50mb로 제한
	if(!$num_upload_size) $num_upload_size=20*1024*1024;
	
	//현재 사용중인 디스크용량체크
	$sql = "select sum(num_size) from TAB_FILES where num_oid = $_OID";
	$db_num_size = $DB -> sqlFetchOne($sql);
	
	//현재 남은 디스크용량 체크
	$use_size = $num_disk-$db_num_size;

	if($use_size>1){
		//디스크 사용공간이 아직 남아있음.
		if($use_size < $num_upload_size){
			//1. 남은공간이 최대업로드 사이즈보다 작으면 남은공간만큼만 maxsize로 잡아줌.
			$maxfilesize = $use_size;
		}else{
			//2. 남은공간이 최대 업로드 사이즈보다 크므로 최대업로드사이즈까지 업로드 가능
			$maxfilesize = $num_upload_size;
		}

	}else{
		//디스크 사용공간이 꽉찾음. 1바이트로 세팅
		$maxfilesize = 1;
	}
	
	//설정된 디스크사용량, 설정된 최대업로드사이즈, 사용중인디스크사용량, 남은디스크사용량, 업로드가능한파일사이즈
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
              case 2: // JPEG일경우
                     $im = imagecreatefromjpeg($filename);
                     $Extension = "jpg";
                     break;
              case 1: // GIF일 경우
                     $im = imagecreatefromgif($filename);
                     $Extension = "gif";
                     break;
              case 3: // png일 경우
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
        function FileUpload($name) { // 클래스 초기화 
                $this->Name = $_FILES[$name]["name"]; 
                $this->Tmp  = $_FILES[$name]["tmp_name"]; 
                $this->Size = $_FILES[$name]["size"]; 
                $this->Type = $_FILES[$name]["type"]; 

				} 
        function file_mkdir () { // 디렉토리 생성 
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
        function file_rename ($nummm) { // 파일명 자동 부여  
				global $pcode,$mcode,$serial, $DB,$FH,$FTP,$_OID;

				//1010.1.2.1234229057.jpg
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				
				if($pcode) $num_pcode = $pcode."_"; else $num_pcode ="";
			
				$this->SaveName= $num_pcode.$mcode.".".$serial.".".$nummm.".".$file_ext; // 변경하여 저장할 화일명
				$this->SaveName_100= $num_pcode.$mcode.".".$serial.".".$nummm.".".$file_ext."_100"; // 변경하여 저장할 화일명

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
				

				

				if(!file_exists($this->Path.$this->SaveName)) { // 중복파일이 없을때;;

						
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





        function file_rename2_tmp ($nummm) { // 파일명 자동 부여  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName=$nummm.".gif"; // 변경하여 저장할 화일명
				
				if(file_exists($this->Path.$this->SaveName)) { // 중복파일이 있을때;;
						$Tmp_SaveName = explode(".", $this->SaveName); 
						//$Tmp_SaveName[0] .= "_1"; 
						$this->SaveName = implode(".", $Tmp_SaveName); 
				} 
        } 

	        function file_renameExp ($nummm) { // 파일명 자동 부여  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName=$nummm.".".$file_ext; // 변경하여 저장할 화일명
				
				if(file_exists($this->Path.$this->SaveName)) { // 중복파일이 있을때;;
						$Tmp_SaveName = explode(".", $this->SaveName); 
						//$Tmp_SaveName[0] .= "_1"; 
						$this->SaveName = implode(".", $Tmp_SaveName); 
				} 
        } 
	
        function NewName ($newName) { // 파일명 수동 부여 
                $nTmp = explode(".", $this->Name); 
                $this->Name = $newName . "." . $nTmp[sizeof($nTmp)-1]; 
        } 
        function FileSizeChk ($size) { // mime type 체크 - 별로 소용 없을 듯 -_-; 
                if (!$this->Name or !$this->Size) return false; 
                if($this->Size > $size) return false; 
                return true; 
        } 

        function FileChk ($convert_heightpe) { // mime type 체크 - 별로 소용 없을 듯 -_-; 
                if (!$this->Name or !$this->Type) return false; 
                $fType = explode("/", $this->Type); 
                if($fType[0] != $convert_heightpe) return false; 
                return true; 
        } 
        function Ext ($allowed) { // 허용 확장자 
                $allow = explode(",", $allowed); 
                $fTmp = explode(".", strtolower($this->Name)); 
                return in_array($fTmp[sizeof($fTmp)-1], $allow); 
        } 

        function upload () { // 파일 업로드 
                if (!is_uploaded_file($this->Tmp) or ($this->Size == 0)) return false; 
				return move_uploaded_file($this->Tmp, $this->Path . $this->SaveName);
				
        } 



		function Resize_Image($convert_width="78",$convert_height="56",$resize_dir="") { 
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $resize_dir;
			$file = $this->SaveName;
			
			$ext = explode(".", strtolower($file)); // 파일의 확장자를 감별한다. .으로 구분후 맨마지막것을 가져옴 
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
			
			$ext = explode(".", strtolower($file)); // 파일의 확장자를 감별한다. .으로 구분후 맨마지막것을 가져옴 
			$ext = $ext[count($ext)-1];  // 
			 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 


			$normal_gallery=GetImageSize($dir.$file); 

			
			if($convert_width) $bbs_width = $convert_width; else $bbs_width =100;
			if($convert_height) $bbs_height = $convert_height; else $bbs_height =75;


			$ratio1 = $bbs_width/$normal_gallery[0]; // 게시판 가로크기에 대한 이미지 가로 비율 계산
			$ratio2 = $bbs_height/$normal_gallery[1]; // 게시판 세로크기에 대한 이미지 세로 비율 계산

			if($ratio1 >= 1 && $ratio2 >= 1 )
			{
				$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력
				$img_h = $normal_gallery[1];
			}
			elseif($ratio1 > $ratio2)
			{
				$img_w = $normal_gallery[0]*$ratio2; // 포스터의 가로와 세로에 동일한 비율 적용
				$img_h = $normal_gallery[1]*$ratio2; // 높이 넓이 비율 적용
			}
			elseif($ratio1 <= $ratio2)
			{
				$img_w = $normal_gallery[0]*$ratio1; // 포스터의 가로와 세로에 동일한 비율 적용
				$img_h = $normal_gallery[1]*$ratio1; // 높이 넓이 비율 적용
			}
			else
			{
				$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력
				$img_h = $normal_gallery[1];
			}

	

			
			$_SESSION['get_thumb_filename'] = date('Ym')."/".$file;



			GDImageResize($dir."/".$file, $tdir."/".$file_, $img_w, $img_h);
			  
			  //섬네일을 등록
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
			
			$ext = explode(".", strtolower($file)); // 파일의 확장자를 감별한다. .으로 구분후 맨마지막것을 가져옴 
			$ext = $ext[count($ext)-1];  // 
			 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 


			$normal_gallery=GetImageSize($dir.$file); 

			
			if($convert_width) $bbs_width = $convert_width; else $bbs_width =100;
			if($convert_height) $bbs_height = $convert_height; else $bbs_height =75;


			$ratio1 = $bbs_width/$normal_gallery[0]; // 게시판 가로크기에 대한 이미지 가로 비율 계산
			$ratio2 = $bbs_height/$normal_gallery[1]; // 게시판 세로크기에 대한 이미지 세로 비율 계산

			if($ratio1 >= 1 && $ratio2 >= 1 )
			{
				$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력
				$img_h = $normal_gallery[1];
			}
			elseif($ratio1 > $ratio2)
			{
				$img_w = $normal_gallery[0]*$ratio2; // 포스터의 가로와 세로에 동일한 비율 적용
				$img_h = $normal_gallery[1]*$ratio2; // 높이 넓이 비율 적용
			}
			elseif($ratio1 <= $ratio2)
			{
				$img_w = $normal_gallery[0]*$ratio1; // 포스터의 가로와 세로에 동일한 비율 적용
				$img_h = $normal_gallery[1]*$ratio1; // 높이 넓이 비율 적용
			}
			else
			{
				$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력
				$img_h = $normal_gallery[1];
			}

	

			
			
			GDImageResize($dir."/".$file, $dir."/".$file."_".$convert_width, $img_w, $img_h);
			  
			  //섬네일을 등록
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



		function uploadFile($num){ //2009-07-02 종태 신규 파일 업로드
		global $DB,$FH,$pcode,$mcode,$serial,$id,$uploadSize,$_conf;
			$tmpf = "upfile".$num;
			list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize($_conf[num_up_size]);
			
						
			$file = new FileUpload("upfile".$num); // datafile은 form에서의 이름 
			if($file->Size > 0) {
		
				$file->Path = $FH->file_dir."/".date("Ym")."/";  // 마지막에 /꼭 붙여야함
				
				if(!$file->Ext("zip,arj,rar,gz,tgz,ace,Z,exe,pdf,doc,docx,hwp,xls,xlsx,ppt,pptx,bmp,jpg,jpeg,png,gif,txt,mp3,mp4,ogg,aiff,avi,mpg,mpeg,mov,rm,swf,flv,wmv,wma,ra,html,htm,alz,dat,ios,psd,xps")) {
				
				echo '<script>alert("'.$file->Name.' 은 업로드가 허용되지 않는 파일입니다.");</script>';
				$fno = "y";
				 }


				if(!$file->FileSizeChk($maxfilesize)){
				echo '<script>alert("'.$file->Name.' 이 1회 업로드 용량을 초과하여 업로드에 실패하였습니다.\n\n현재 1회업로드는 '.byte_convert($maxfilesize).'을 넘을 수 없습니다.");</script>';
				$fno = "y";
				}else{
			
				if($use_size > $file->Size ) {
				if($fno !="y"){
				$file->file_rename($num); 
				$file->upload();
				$file->Resize_Imagethumb("100","100",$file->Path.$file->SaveName);	
				}

				}else{
				echo '<script>alert("디스크 용량이 부족하여 '.$num.'번 파일 업로드를 할 수 없습니다.");</script>';
				}
				}
			}
		}

?>