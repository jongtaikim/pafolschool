<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	
	case "GET":

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("edit_media.htm"));

	break;
	case "POST":

		if($attachfile) {

			if(!$sess_id){
				$sess_dom = str_replace("www.","",$_SERVER[HTTP_HOST]);
				$sess_id =  md5(uniqid(rand()));
				setcookie("sess_id",$sess_id,0,"/",$sess_dom,0);
			}

			$FH = &WebApp::singleton('FileHost');
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

			$file = new FileUpload("attachfile"); // datafile은 form에서의 이름 

			$filepath = "/hosts/".HOST."/board_tmp/".date("Ymd")."/".$sess_id."/";
			//$filepath = "/data/hosts/".$_OID."/board_tmp/20081104/".$sess_id."/";
			$file->Path = _DOC_ROOT.$filepath;  

			if(!$file->Ext("wmv"))  {
				echo '<script>alert("WMV (인터넷 스트리밍 동영상) 파일만 가능합니다.");   history.go(-1); </script>';
				exit;
			 }
			
			$new_filename = mktime().mt_rand();
			$file->file_rename($new_filename); 

			if(!$file->file_mkdir()){
				echo '<script>alert("디렉토리 생성에 실패 했습니다.");   history.go(-1); </script>';
				exit;
			}


			if(!$file->FileSizeChk((20*1024*1024))){
				echo '<script>alert("파일용량이 너무 큽니다. 20MB 이상 이미지는 업로드 하실 수 없습니다.");   history.go(-1); </script>';
				exit;
			}

			if(!$file->upload()){
				echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
				exit;
			}else{
				chmod($file->Path . $file->SaveName, 0777); 
			}

			//$file->Resize_Image("1024","768",$file->Path); // 이미지일때 가로 세로 사이즈로 컨버팅
			$FTP->close();
		}

		$normal_gallery=getimagesize(_DOC_ROOT."/".$filepath."/".$file->SaveName); 
?>

<!-- 2008-11-05 종태 이미지 리턴하기 -->
<script type="text/javascript" language="javascript"> 
 var url = encodeURIComponent('<?=$filepath?><?=$file->SaveName?>');
parent.pasteHTMLDemo('<p><img class="ext_embed_wmv" style="width: 320px; height: 280px;" longdesc="'+url+'" src="img/blank.gif" alt="" /></p>', '<?=$ifrmObjId?>'); 
parent.closewPop(2)
</script> 
	

<?

		break;
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
        Function FileUpload($name) { // 클래스 초기화 
                $this->Name = $_FILES[$name]["name"]; 
                $this->Tmp  = $_FILES[$name]["tmp_name"]; 
                $this->Size = $_FILES[$name]["size"]; 
                $this->Type = $_FILES[$name]["type"]; 

        } 

        Function file_mkdir () { // 디렉토리 생성 
			if (!$this->Path){
				return false;
			}else{
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
				return $this->Path;
			}
        } 
        Function file_rename ($nummm) { // 파일명 자동 부여  
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





        Function NewName ($newName) { // 파일명 수동 부여 
                $nTmp = explode(".", $this->Name); 
                $this->Name = $newName . "." . $nTmp[sizeof($nTmp)-1]; 
        } 
        Function FileSizeChk ($size) { // mime type 체크 - 별로 소용 없을 듯 -_-; 
                if (!$this->Name or !$this->Size) return false; 
                if($this->Size > $size) return false; 
                return true; 
        } 

        Function FileChk ($convert_heightpe) { // mime type 체크 - 별로 소용 없을 듯 -_-; 
                if (!$this->Name or !$this->Type) return false; 
                $fType = explode("/", $this->Type); 
                if($fType[0] != $convert_heightpe) return false; 
                return true; 
        } 
        Function Ext ($allowed) { // 허용 확장자 
                $allow = explode(",", $allowed); 
                $fTmp = explode(".", strtolower($this->Name)); 
                return in_array($fTmp[sizeof($fTmp)-1], $allow); 
        } 

        Function upload () { // 파일 업로드 
                if (!is_uploaded_file($this->Tmp) or ($this->Size == 0)) return false; 
                return move_uploaded_file($this->Tmp, $this->Path . $this->SaveName);
        } 



	function Resize_Image($convert_width="78",$convert_height="56",$resize_dir="") { 
			global $mcode,$serial, $DB,$FH,$FTP;
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $this->Path; 
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

	




			GDImageResize($dir."/".$file, $tdir."/".$file, $img_w, $img_h);
	}
} 
?>