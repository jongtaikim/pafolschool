<?



# Name : FileUpload Class 
/* 
[예제] 필요한 부분만 골라서 쓰면 됨. 
$file = new FileUpload("datafile"); // datafile은 form에서의 이름 
$file->Path = "./data/$id/"; 
$file->file_mkdir(); 
if(!$file->FileSizeChk("1024000")) echo ("파일 업로드는 최고 ".GetFileSize($setup[max_upload_size])." 까지 가능합니다");
if(!$file->FileChk("image")) echo ("이미지 형식만 가능합니다."); 
if(!$file->Ext("jpg;gif;png")) echo ("jpg, gif, png 확장자만 가능합니다."); 
if($file->Ext("php;phtml;html;htm")) echo ("업로드가 허용되지 않는 확장자입니다."); 
$file->file_rename(); 
if(!$file->upload()) echo ("업로드 실패!"); 
mysql_query("INSERT INTO TABLE VALUES ('$file->Name')"); 
*/ 


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
        Function file_rename ($nummm) { // 파일명 자동 부여  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName="homimg".$nummm.".".$file_ext; // 변경하여 저장할 화일명
				
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
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $resize_dir;
			$file = $this->SaveName;
			//$temp_pnm_image1 = $this->SaveName.$this->SaveName."1.pnm";	 // 템프 파일명 
			//$temp_pnm_image2 = $this->SaveName.$this->SaveName."2.pnm";   // 두번째 템프파일명 
			$ext = explode(".", strtolower($file)); // 파일의 확장자를 감별한다. .으로 구분후 맨마지막것을 가져옴 
			$ext = $ext[count($ext)-1];  // 
			//if($ext == 'jpg' || $ext == 'jpeg') exec("djpeg -pnm $dir/$file > /tmp/$temp_pnm_image1"); // djpeg 로 pnm 으로 만든다. djpeg가 없으면 netpbm의 jpegtopnm 을 이용해도됨 
			//elseif($ext == 'gif') exec("giftopnm $dir/$file > /tmp/$temp_pnm_image1"); // netpbm 의 giftopnm 을 이용해 pnm 파일로 바꿔준다. 
			$size=GetImageSize($dir.$file); 

			$original_width = $size[0]; 
			$original_height = $size[1]; 
			GDImageResize($dir."/".$file, $tdir."/".$file, $convert_width, $convert_height);

//	GDImageResize1(원본이미지 경로, 저장할 이미지 경로, 가로값, 세로값);
/*
			if($original_width > $convert_width || $original_height > $convert_height) { // 타겟보다 이미지가 클경우에만 변환! 왜냐면 작은 이미지의 경우 크기가 늘어나므로.. 
				$xper = $original_width/$convert_width; // 가로의 비율 
				$yper = $original_height/$convert_height; // 세로의 비율 

				$chkper = $xper-$yper; // 체크 비율 
				if($chkper > 0 ) { // 가로비율이 커서 가로를 자를경우 
					$s = $original_height/$convert_height; 
					$fx  = intval($convert_width*$s); 
					$px  = intval(($original_width-$fx)/2); 
					$py = 0; 
					exec("pnmcut $px $py $fx $original_height /tmp/$temp_pnm_image1 > /tmp/$temp_pnm_image2"); 
					exec("pnmscale -xsize $convert_width /tmp/$temp_pnm_image2 | cjpeg -quality 95 -outfile $tdir/$file"); 
				}
				elseif($chkper < 0) { // 세로비율이 커서 가로를 자를경우 
					$s = $original_width/$convert_width; 
					$fy  = intval($convert_height*$s); 
					$px = 0; 
					$py  = intval(($original_height-$fy)/2); 
					exec("pnmcut $px $py $original_width $fy /tmp/$temp_pnm_image1 > /tmp/$temp_pnm_image2"); 
					exec("pnmscale -ysize $convert_height /tmp/$temp_pnm_image2 | cjpeg -quality 95 -outfile $tdir/$file"); 
				}
				else { 
					exec("pnmscale -xsize $convert_width /tmp/$temp_pnm_image1 | cjpeg -quality 95 -outfile $tdir/$file"); 
				} 
			} 
			else {
					exec("pnmscale -xsize $original_width /tmp/$temp_pnm_image1 | cjpeg -quality 95 -outfile $tdir/$file"); 
			}
			@exec("convert -sharpen 1 -gamma 0.8 $tdir/$file $tdir/$file"); 
			@unlink("/tmp/$temp_pnm_image1"); 
			@unlink("/tmp/$temp_pnm_image2"); 
			// return $imgname; 

*/


		} 
} 



switch ($REQUEST_METHOD) {
	case "GET":

?>

<link rel="stylesheet" type="text/css" href="/css/admin.css">

<form name="aaaf"  method="post" enctype='multipart/form-data'>
<TABLE width = 100%>
<TR>

	<TD><input type="file" name="upfile1" style="width:100%;"  class=button onchange = "this.form.submit();"></TD>
	
</TR>
</TABLE>


</form>

<?

	break;
	case "POST":
echo '<link rel="stylesheet" type="text/css" href="/css/admin.css">';
echo "업로드중...";
$FH = &WebApp::singleton('FileHost');

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

$FTP->mkdir($FH->file_dir);
$FTP->chmod($FH->file_dir,777);
$FTP->mkdir($FH->file_dir."/board_img/");
$FTP->chmod($FH->file_dir."/board_img/",777);

if($upfile1) {
$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
$file->Path = $FH->file_dir."/board_img/";  // 마지막에 /꼭 붙여야함

//$file->file_mkdir(); 
if(!$file->Ext("swf"))  {
echo '<script>alert("swf 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$mk = mktime();

$file->file_rename($mk); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}
$file->upload();
//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 이미지일때 가로 세로 사이즈로 컨버팅


}


$size = GetImageSize("http://isch_file.hkedu2.co.kr/hosts/".$_OID."/menu/board_img/".$file->SaveName);

echo $size[0]." / ".$size[1];

echo "<script>
parent.insss('http://isch_file.hkedu2.co.kr/hosts/".$_OID."/menu/board_img/".$file->SaveName."','".$size[0]."','".$size[1]."');	
parent.generatePreview();
parent.generatePreview('width');
parent.generatePreview('height');
history.go(-1);
</script>";



	break;

}
?>