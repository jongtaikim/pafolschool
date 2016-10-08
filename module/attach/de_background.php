<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16 
* 작성자: 김종태
* 설  명 : 네이버리모컨과 비슷한 디자인 라이브러리 알고리즘 잡기
* 참  고 : 이 프로그램을 잘 사용하면 주신의 왕이 부활 할것임..
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
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




if($bgs) {
$dir1= _ROOT."/background/"._OID."/";	
}else{
$dir1= _ROOT."/background/";	
}


$num = 0;
$d1 = opendir($dir1);
while($file = readdir($d1)) {
  if(is_dir($file)) continue;


if(strstr($file,".")) {
if($file !="." ||$file !=".."  ) $bg[$num]['name'] =$file;	

}

	

$num++;
}
closedir($dir1);


if(!$listnum) $listnum = 21;


if(!$page) $num_start = 0; else $num_start = $page * $listnum ;
$num_end =  $num_start + $listnum -1 ;


for($ii=0; $ii<($num / $listnum); $ii++) {
$idx[$ii]['str_link']	= "attach.de_background?layout=".$layout."&bgs=".$bgs."&page=".$ii;
}



$tmp_css1 =  file_get_contents('hosts/'.HOST.'/'.$layout.'_bg.css');
$tmp_css2 =  file_get_contents('hosts/'.HOST.'/'.$layout.'_plus.css');

$tpl->assign(array(
		'bglist'	=> $bg,
		
		'total'=>$num,
		'def'=>$tmp_css1,
		'def2'=>$tmp_css2,
		'num_start'=>$num_start,
		'num_end'=>$num_end,
		'idx'=>$idx,
		'page'=>$page,
		'layout'=>$layout,
		'key'=>$key,
		'bgs'=>$bgs,
		'_OID'=>_OID,

		));

//print_r($_SESSION[mk_ses][tmp_css]);

	
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("attach/de_background.htm"));
	
	 break;


	case "POST":



$FH = &WebApp::singleton('FileHost');
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->chmod(_DOC_ROOT.'/background/',777);
$FTP->mkdir(_DOC_ROOT.'/background/'._OID.'/');
$FTP->chmod(_DOC_ROOT.'/background/'._OID.'/',777);

if($upfile1) {
$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
$file->Path = _DOC_ROOT."/background/"._OID."/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(mktime()); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}



WebApp::moveBack();
exit;
}

	$tmp_css1 =  file_get_contents('hosts/'.HOST.'/'.$layout.'_bg.css');
	
	if($tmp_css1 != $totalcss){
		$FTP->put_string($totalcss,_DOC_ROOT.'/hosts/'.HOST.'/'.$layout.'_bg.css');
	}

	$FTP->put_string($totalcss2,_DOC_ROOT.'/hosts/'.HOST.'/'.$layout.'_plus.css');
	WebApp::moveBack('적용되었습니다.');
	//echo "<script type='text/javascript'>   parent.location.reload();</script>";

	break;
	}

?>
