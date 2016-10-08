<?



# Name : FileUpload Class 
/* 
[예제] 필요한 부분만 골라서 쓰면 됨. 
$file = new FileUpload("datafile"); // datafile은 form에서의 이름 
$file->Path = "./data/$id/"; 
$file->file_mkdir(); 
if(!$file->FileSizeChk("1024000")) echo ("파일 업로드는 최고 ".GetFileSize($setup[max_upload_size])." 까지 가능합니다");
if(!$file->FileChk("image")) echo (" 형식만 가능합니다."); 
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
				$this->SaveName="logo".$nummm.".".$file_ext; // 변경하여 저장할 화일명
				
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



		} 
} 



switch ($REQUEST_METHOD) {
	case "GET":

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> 관리자 </title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" type="text/css" href="/css/admin.css">
</head>
<script language="JavaScript">
<!--
var ifrContentsTimer;
function resizeRetry() { //이미지같이 로딩시간이 걸리는 것들이 로딩된후 다시 한번 리사이즈
        if(document.body.readyState == "complete") { 
            clearInterval(ifrContentsTimer); 
        }else { 
            resizeFrame(); 
        } 
} 
function resizeFrame(){  //페이지가 로딩되면 바로 리사이즈..
        var h = parseInt(document.body.scrollHeight);
         var w = parseInt(document.body.scrollWidth); 


document.getElementById('loding').style.left =  10;
document.getElementById('loding').style.top = 80;

} 
//-->
</script>

<body style="margin:0" bgcolor="#FFFFFF"  >

<div style="vertical-align:top;overflow:auto;height:500px;">
<table width="100%"  border="0" cellpadding="0" cellspacing="0"  align = center>
<form name="aaaf"  method="post" enctype='multipart/form-data'>
<tr>
	<td valign=top>

		<table width = "100%" class="table01">
		<tbody>
		<?
			for($a=0 ; $a<5 ; $a++){
		?>
				<tr  align="center">
					<th width = 200>로고<?=($a*2)+1?></th>	<th width = 200>로고<?=($a*2)+2?></th>
				</tr>
				<tr>
					<td   align="center">
						<img src = "/hosts/<?=$HOST?>/logo<?=($a*2)+1?>.gif" onerror = "this.src='/b.gif' " >
						<input type="file" name="upfile<?=($a*2)+1?>" style="width:200px;" >
					</td>

					<td   align="center">
						<img src = "/hosts/<?=$HOST?>/logo<?=($a*2)+2?>.gif" onerror = "this.src='/b.gif' " >
						<input type="file" name="upfile<?=($a*2)+2?>" style="width:200px;" >
					</td>
				</tr>
		<? } ?>

		</table>

	</td>
</tr>
<tr>
	<td align=center><input type="submit" value = "정보저장"  ></td>
</tr>
</form>
</table>
</div>
</html>

<?

	break;
	case "POST":

		$FH = &WebApp::singleton('FileHost');
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->chmod(_DOC_ROOT.'/hosts/'.HOST.'/',777);

		for($a=1 ; $a<=10 ; $a++){

			if(${upfile.$a}) {
				$file = new FileUpload("upfile".$a); // datafile은 form에서의 이름 
				$file->Path = "./hosts/".HOST."/";  // 마지막에 /꼭 붙여야함
				//$file->file_mkdir(); 

				if(!$file->Ext("gif"))  {
					echo "<script>alert('".$a." - gif 파일만 가능합니다.');   history.go(-1); </script>";
					exit;
				}
				$file->file_rename($a); 
				if(!$file->upload()){
					echo "<script>alert('".$a." - 업로드에 실패 했습니다.');   history.go(-1); </script>";
					exit;
				}
				$file->upload();
				//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 일때 가로 세로 사이즈로 컨버팅

			}
		}


		echo '<script>alert("저장했습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms_logo/setup'\">";

	break;

}