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
				$this->SaveName=$nummm.".gif"; // 변경하여 저장할 화일명
				
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

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

switch ($REQUEST_METHOD) {
case "GET":

//		print_r($_SESSION[mk_ses]);
		//$_SESSION[mk_ses][tmp_css];
		//$_SESSION[mk_ses][tmp_css2];



	$sql = "select STR_LAY_ALIGN from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'";

	if(!$css_align = $DB -> sqlFetchOne($sql)) {
		if($layout=="main") {
		$css_align = "LOGO_TOP|TOP_BUTTON|TOP|LEFT|MAIN|RIGHT|FOOT";
		}else{
		$css_align = "LOGO_TOP|TOP_BUTTON|TOP|LEFT|RIGHT|FOOT";
		}
	}

	$css_align = explode("|",$css_align);

	for($ii=0; $ii<count($css_align); $ii++) {

	$css_align_array[$ii]['layout']=$css_align[$ii];
	
		if(is_file(_DOC_ROOT.'/hosts/'.HOST.'/'.$layout."_".$css_align[$ii].".gif")) {
		$css_align_array[$ii]['image'] = $layout."_".$css_align[$ii].".gif";
	}
	}

	



for($ii=0; $ii<count($css_align_array); $ii++) {


$css_align_array[$ii][def] = $_SESSION['mk_ses'][$css_align_array[$ii]['layout']];

if(!$css_align_array[$ii][def]){
$sql = "select str_".$css_align_array[$ii]."_css from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' ";
$css_align_array[$ii][def] = $DB -> sqlFetchOne($sql);
}

}


$css_align_array[$ii+1]['layout'] = "NONE";
	$tpl->assign(array('CSS_ALIGN_manage' =>$css_align_array));

$sql = "select STR_css from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' ";
$css = $DB -> sqlFetchOne($sql);

$def= explode("/*레이아웃영역*/",$css);
$def= explode("/*레이아웃영역끝*/",$def[1]);
$def = $def[0];



if(	$_SESSION[mk_ses][LOGO_TOP] ||	$_SESSION[mk_ses][TOP_BUTTON] ||	$_SESSION[mk_ses][TOP] ||	$_SESSION[mk_ses][LEFT] ||	$_SESSION[mk_ses][MAIN] ||	$_SESSION[mk_ses][RIGHT] ||	$_SESSION[mk_ses][FOOT] ) {
	
	$def = $_SESSION[mk_ses][LOGO_TOP].$_SESSION[mk_ses][TOP_BUTTON].	$_SESSION[mk_ses][TOP].$_SESSION[mk_ses][LEFT].$_SESSION[mk_ses][MAIN].$_SESSION[mk_ses][RIGHT].	$_SESSION[mk_ses][FOOT];
}

$tpl->assign(array(
	
		'layout'=>$layout,
		'key'=>$key,
		'target2'=>$target2,
		'_OID'=>_OID,
		'def'=>$def,

		));
//unset($_SESSION[mk_ses]);
//print_r($_SESSION[mk_ses]);


	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("attach/de_layout.htm"));
	
	 break;


	case "POST":

$FH = &WebApp::singleton('FileHost');
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->chmod(_DOC_ROOT.'/hosts/'.HOST.'/',777);


$DB = &WebApp::singleton('DB');

$sql = "select STR_css from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' ";
$tmp_css = $DB -> sqlFetchOne($sql);



for($ii=0; $ii<count($lay_be); $ii++) {

$name = $$lay_be[$ii];

$name_file = "upfile".$lay_be[$ii];
$name_file_r = $$name_file;

$totalcss .= "#".$lay_be[$ii]."{";
//$totalcss .= "#".$lay_be[$ii]."{border:".$name['border']." ".$name['line']." ".$name['color']."}";

$name[top] = $name[top]+0;
$name[left] = $name[left]+0;
$name[right] = $name[right]+0;
$name[bottom] = $name[bottom]+0;

$totalcss .= "border-top:".$name[top]." ".$name['line']." ".$name['color'].";";
$totalcss .= "border-left:".$name[left]." ".$name['line']." ".$name['color'].";";
$totalcss .= "border-right:".$name[right]." ".$name['line']." ".$name['color'].";";
$totalcss .= "border-bottom:".$name[bottom]." ".$name['line']." ".$name['color'].";";
$totalcss .= "background-repeat:".$name[bgs].";";
$totalcss .= "background-position:".$name[bgs2].";";
$totalcss .= "background-image:url(/hosts/".$_SERVER[HTTP_HOST]."/".$layout."_".$lay_be[$ii].".gif)";

$totalcss .= "}";



if($name_file_r) {
$file = new FileUpload($name_file); // datafile은 form에서의 이름 
$file->Path = _DOC_ROOT.'/hosts/'.HOST.'/';  // 마지막에 /꼭 붙여야함

if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$file->file_rename($layout."_".$lay_be[$ii]); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}

}





}



if(strstr($tmp_css,"/*레이아웃영역*/")) {
$tmp_css = explode("/*레이아웃영역*/",$tmp_css);
$tmp_css = $tmp_css[0];
}

$tmp_css = $tmp_css."/*레이아웃영역*/".$totalcss."/*레이아웃영역끝*/";



$sql = "UPDATE TAB_CSS SET STR_CSS ='".$tmp_css."'WHERE num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'";


 $DB->query($sql);
 $DB->commit();


	$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/'._CSS.'.conf.php');

			for($ii=0; $ii<count($_SESSION[tem_ses]); $ii++) {


if($_SESSION[tem_ses][$ii][skin]) $INI->setVar("skin",$_SESSION[tem_ses][$ii][skin],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][type]) $INI->setVar("type",$_SESSION[tem_ses][$ii][type],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][listnum]) $INI->setVar("listnum",$_SESSION[tem_ses][$ii][listnum],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][col]) $INI->setVar("col",$_SESSION[tem_ses][$ii][col],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][len]) $INI->setVar("len",$_SESSION[tem_ses][$ii][len],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][subject]) $INI->setVar("subject",$_SESSION[tem_ses][$ii][subject],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][img_w]) $INI->setVar("img_w",$_SESSION[tem_ses][$ii][img_w],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][img_h]) $INI->setVar("img_h",$_SESSION[tem_ses][$ii][img_h],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][color1]) $INI->setVar("color1",$_SESSION[tem_ses][$ii][color1],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][color2]) $INI->setVar("color2",$_SESSION[tem_ses][$ii][color2],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][font]) $INI->setVar("font", iconv("utf-8","euc-kr",$_SESSION[tem_ses][$ii][font]),$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][font_size]) $INI->setVar("font_size",$_SESSION[tem_ses][$ii][font_size],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][width]) $INI->setVar("width",$_SESSION[tem_ses][$ii][width],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][height]) $INI->setVar("height",$_SESSION[tem_ses][$ii][height],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][paddingtop] !="") $INI->setVar("paddingtop",$_SESSION[tem_ses][$ii][paddingtop],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][paddingright] !="") $INI->setVar("paddingright",$_SESSION[tem_ses][$ii][paddingright],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][paddingbottom] !="") $INI->setVar("paddingbottom",$_SESSION[tem_ses][$ii][paddingbottom],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][paddingleft] !="") $INI->setVar("paddingleft",$_SESSION[tem_ses][$ii][paddingleft],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
if($_SESSION[tem_ses][$ii][title2]) $INI->setVar("title2", iconv("utf-8","euc-kr",$_SESSION[tem_ses][$ii][title2]),$r_layout."_".$_SESSION[tem_ses][$ii][name]);	



		
			
if($_SESSION[tem_ses][$ii][height]) {
 $sql = "UPDATE tab_attach_config SET str_height  ='".$_SESSION[tem_ses][$ii][height]."' WHERE num_oid = $_OID and str_layout = '$r_layout' and str_name = '".$_SESSION[tem_ses][$ii][name]."' and num_css='".$_CSS2."'";
$DB->query($sql);
$DB->commit();	
}			

if($_SESSION[tem_ses][$ii][width]) {
 $sql = "UPDATE tab_attach_config SET str_width  ='".$_SESSION[tem_ses][$ii][width]."' 
 WHERE num_oid = $_OID and str_layout = '$r_layout' and num_css='".$_CSS2."' and  str_name = '".$_SESSION[tem_ses][$ii][name]."'";
 $DB->query($sql);
 $DB->commit();	
}		

if($_SESSION[tem_ses][$ii][paddingtop] !="") {
 $sql = "UPDATE tab_attach_config SET num_p_top  ='".$_SESSION[tem_ses][$ii][paddingtop]."' 
 WHERE num_oid = $_OID  and num_css='".$_CSS2."' and str_layout = '$r_layout' and str_name = '".$_SESSION[tem_ses][$ii][name]."'";
 $DB->query($sql);
 $DB->commit();	
}		

if($_SESSION[tem_ses][$ii][paddingright] !="") {
 $sql = "UPDATE tab_attach_config SET num_p_right  ='".$_SESSION[tem_ses][$ii][paddingright]."' 
 WHERE num_oid = $_OID and num_css='".$_CSS2."' and  str_layout = '$r_layout' and str_name = '".$_SESSION[tem_ses][$ii][name]."'";
 $DB->query($sql);
 $DB->commit();	
}		

if($_SESSION[tem_ses][$ii][paddingbottom] !="") {
 $sql = "UPDATE tab_attach_config SET num_p_bottom  ='".$_SESSION[tem_ses][$ii][paddingbottom]."' 
 WHERE num_oid = $_OID and num_css='".$_CSS2."' and str_layout = '$r_layout' and str_name = '".$_SESSION[tem_ses][$ii][name]."'";
 $DB->query($sql);
 $DB->commit();	
}		

if($_SESSION[tem_ses][$ii][paddingleft] !="") {
 $sql = "UPDATE tab_attach_config SET num_p_left  ='".$_SESSION[tem_ses][$ii][paddingleft]."' 
 WHERE num_oid = $_OID and num_css='".$_CSS2."' and str_layout = '$r_layout' and str_name = '".$_SESSION[tem_ses][$ii][name]."'";
 $DB->query($sql);
 $DB->commit();	
}		


}		

			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'.$_CSS2.'.conf.php');
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'.$_CSS2.'_TEM.conf.php');

			unset($_SESSION[tem_ses]);
			unset($_SESSION[mk_ses][tmp_css]);
			unset($_SESSION[mk_ses][tmp_css2]);


$_css_file = '/hosts/'.HOST.'/'.$r_layout.'_'.$_CSS2.'_css.htm';
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.$_css_file);
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$r_layout.'_'.$_CSS2.'_align.htm');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$r_layout.'_'.$_CSS2.'_Pcss.htm');

 include _DOC_ROOT.'/module/attach/admin/makelayer.php';
 makelayer2($r_layout);

echo "<meta http-equiv='Refresh' Content=\"0; URL='/attach.de_layout?layout=$layout&target2=$target2'\">";



	break;
	}
unset($_SESSION[mk_ses]);
?>
