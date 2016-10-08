<?



# Name : FileUpload Class 
/* 
[����] �ʿ��� �κи� ��� ���� ��. 
$file = new FileUpload("datafile"); // datafile�� form������ �̸� 
$file->Path = "./data/$id/"; 
$file->file_mkdir(); 
if(!$file->FileSizeChk("1024000")) echo ("���� ���ε�� �ְ� ".GetFileSize($setup[max_upload_size])." ���� �����մϴ�");
if(!$file->FileChk("image")) echo (" ���ĸ� �����մϴ�."); 
if(!$file->Ext("jpg;gif;png")) echo ("jpg, gif, png Ȯ���ڸ� �����մϴ�."); 
if($file->Ext("php;phtml;html;htm")) echo ("���ε尡 ������ �ʴ� Ȯ�����Դϴ�."); 
$file->file_rename(); 
if(!$file->upload()) echo ("���ε� ����!"); 
mysql_query("INSERT INTO TABLE VALUES ('$file->Name')"); 
*/ 


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
        Function FileUpload($name) { // Ŭ���� �ʱ�ȭ 
                $this->Name = $_FILES[$name]["name"]; 
                $this->Tmp  = $_FILES[$name]["tmp_name"]; 
                $this->Size = $_FILES[$name]["size"]; 
                $this->Type = $_FILES[$name]["type"]; 


        } 
        Function file_mkdir () { // ���丮 ���� 
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
        Function file_rename ($nummm) { // ���ϸ� �ڵ� �ο�  
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName="logo".$nummm.".".$file_ext; // �����Ͽ� ������ ȭ�ϸ�
				
				if(file_exists($this->Path.$this->SaveName)) { // �ߺ������� ������;;
						$Tmp_SaveName = explode(".", $this->SaveName); 
						//$Tmp_SaveName[0] .= "_1"; 
						$this->SaveName = implode(".", $Tmp_SaveName); 
				} 
        } 





        Function NewName ($newName) { // ���ϸ� ���� �ο� 
                $nTmp = explode(".", $this->Name); 
                $this->Name = $newName . "." . $nTmp[sizeof($nTmp)-1]; 
        } 
        Function FileSizeChk ($size) { // mime type üũ - ���� �ҿ� ���� �� -_-; 
                if (!$this->Name or !$this->Size) return false; 
                if($this->Size > $size) return false; 
                return true; 
        } 

        Function FileChk ($convert_heightpe) { // mime type üũ - ���� �ҿ� ���� �� -_-; 
                if (!$this->Name or !$this->Type) return false; 
                $fType = explode("/", $this->Type); 
                if($fType[0] != $convert_heightpe) return false; 
                return true; 
        } 
        Function Ext ($allowed) { // ��� Ȯ���� 
                $allow = explode(",", $allowed); 
                $fTmp = explode(".", strtolower($this->Name)); 
                return in_array($fTmp[sizeof($fTmp)-1], $allow); 
        } 

        Function upload () { // ���� ���ε� 
                if (!is_uploaded_file($this->Tmp) or ($this->Size == 0)) return false; 
                return move_uploaded_file($this->Tmp, $this->Path . $this->SaveName); 
        } 



		function Resize_Image($convert_width="78",$convert_height="56",$resize_dir="") { 
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $resize_dir;
			$file = $this->SaveName;
			//$temp_pnm_image1 = $this->SaveName.$this->SaveName."1.pnm";	 // ���� ���ϸ� 
			//$temp_pnm_image2 = $this->SaveName.$this->SaveName."2.pnm";   // �ι�° �������ϸ� 
			$ext = explode(".", strtolower($file)); // ������ Ȯ���ڸ� �����Ѵ�. .���� ������ �Ǹ��������� ������ 
			$ext = $ext[count($ext)-1];  // 
			//if($ext == 'jpg' || $ext == 'jpeg') exec("djpeg -pnm $dir/$file > /tmp/$temp_pnm_image1"); // djpeg �� pnm ���� �����. djpeg�� ������ netpbm�� jpegtopnm �� �̿��ص��� 
			//elseif($ext == 'gif') exec("giftopnm $dir/$file > /tmp/$temp_pnm_image1"); // netpbm �� giftopnm �� �̿��� pnm ���Ϸ� �ٲ��ش�. 
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
<title> ������ </title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" type="text/css" href="/css/admin.css">
</head>
<script language="JavaScript">
<!--
var ifrContentsTimer;
function resizeRetry() { //�̹������� �ε��ð��� �ɸ��� �͵��� �ε����� �ٽ� �ѹ� ��������
        if(document.body.readyState == "complete") { 
            clearInterval(ifrContentsTimer); 
        }else { 
            resizeFrame(); 
        } 
} 
function resizeFrame(){  //�������� �ε��Ǹ� �ٷ� ��������..
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
					<th width = 200>�ΰ�<?=($a*2)+1?></th>	<th width = 200>�ΰ�<?=($a*2)+2?></th>
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
	<td align=center><input type="submit" value = "��������"  ></td>
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
				$file = new FileUpload("upfile".$a); // datafile�� form������ �̸� 
				$file->Path = "./hosts/".HOST."/";  // �������� /�� �ٿ�����
				//$file->file_mkdir(); 

				if(!$file->Ext("gif"))  {
					echo "<script>alert('".$a." - gif ���ϸ� �����մϴ�.');   history.go(-1); </script>";
					exit;
				}
				$file->file_rename($a); 
				if(!$file->upload()){
					echo "<script>alert('".$a." - ���ε忡 ���� �߽��ϴ�.');   history.go(-1); </script>";
					exit;
				}
				$file->upload();
				//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �϶� ���� ���� ������� ������

			}
		}


		echo '<script>alert("�����߽��ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms_logo/setup'\">";

	break;

}