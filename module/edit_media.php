<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
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

			$file = new FileUpload("attachfile"); // datafile�� form������ �̸� 

			$filepath = "/hosts/".HOST."/board_tmp/".date("Ymd")."/".$sess_id."/";
			//$filepath = "/data/hosts/".$_OID."/board_tmp/20081104/".$sess_id."/";
			$file->Path = _DOC_ROOT.$filepath;  

			if(!$file->Ext("wmv"))  {
				echo '<script>alert("WMV (���ͳ� ��Ʈ���� ������) ���ϸ� �����մϴ�.");   history.go(-1); </script>';
				exit;
			 }
			
			$new_filename = mktime().mt_rand();
			$file->file_rename($new_filename); 

			if(!$file->file_mkdir()){
				echo '<script>alert("���丮 ������ ���� �߽��ϴ�.");   history.go(-1); </script>';
				exit;
			}


			if(!$file->FileSizeChk((20*1024*1024))){
				echo '<script>alert("���Ͽ뷮�� �ʹ� Ů�ϴ�. 20MB �̻� �̹����� ���ε� �Ͻ� �� �����ϴ�.");   history.go(-1); </script>';
				exit;
			}

			if(!$file->upload()){
				echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   history.go(-1); </script>';
				exit;
			}else{
				chmod($file->Path . $file->SaveName, 0777); 
			}

			//$file->Resize_Image("1024","768",$file->Path); // �̹����϶� ���� ���� ������� ������
			$FTP->close();
		}

		$normal_gallery=getimagesize(_DOC_ROOT."/".$filepath."/".$file->SaveName); 
?>

<!-- 2008-11-05 ���� �̹��� �����ϱ� -->
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
        Function file_rename ($nummm) { // ���ϸ� �ڵ� �ο�  
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
			global $mcode,$serial, $DB,$FH,$FTP;
			if(!$this->Ext("jpg,gif,png,jpeg")) return false;
			$dir = $this->Path;
			$tdir= $this->Path; 
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

	




			GDImageResize($dir."/".$file, $tdir."/".$file, $img_w, $img_h);
	}
} 
?>