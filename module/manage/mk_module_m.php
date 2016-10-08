<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 
* 설   명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$DOC_TITLE="str:프로젝트 입력/수정";





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
                if (!$this->Name) return false; 
				$save_tmpname=explode(" ",microtime());
				$save_name=sprintf("%d%05d",$save_tmpname[1],$save_tmpname[0]*10000);
				$ext=explode(".",strtolower($this->Name));
				$file_ext=$ext[count($ext)-1];
				$this->SaveName="main.gif"; // 변경하여 저장할 화일명
				
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
	
	$sql = "select * from TAB_PROJECT where num_mcode = ".$mcode."";
	$pro_data = $DB -> sqlFetch($sql);
	$pro_data[num_start_date] = date("Y-m-d",$pro_data[num_start_date]);
	$tpl->assign($pro_data);
	
	
	$sql = "select * from TAB_MEMBER where num_oid = "._AOID."  ";
	$memberlist = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('MEMBERLIST'=>$memberlist));
	

	$sql = "select * from TAB_MEMBER where num_oid = "._AOID." ";
	$memberlist2 = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('MEMBERLIST2'=>$memberlist2));
	$tpl->assign(array('mcode'=>$mcode));

	
	

	$sql = "select str_title,num_mcode from TAB_MENU where num_oid = $_OID and str_type like 'board%' order by num_mcode,num_step asc";	


	$bbs_row = $DB -> sqlFetchAll($sql);
	$a=0;
		for($ii=0; $ii<count($bbs_row); $ii++) {
			if(strlen($bbs_row[$ii][num_mcode])%2 == 0 || strlen($bbs_row[$ii][num_mcode])%4 == 0 || strlen($bbs_row[$ii][num_mcode])%6 == 0 ){
				$bbs_list[$a] = $bbs_row[$ii];

				
				if(strlen($bbs_row[$ii][num_mcode]) == 6) {
				$bbs_list[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_list[$a][num_mcode],0,2)." ");
				$bbs_list[$a][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_list[$a][num_mcode],0,4)." ");
				}

				
				$bbs_list[$a][counter] = "(".$DB -> sqlFetchOne("select count(str_title) from TAB_BOARD where num_oid = $_OID and num_mcode = ".$bbs_list[$a][num_mcode]." ").")";


				$a++;
			}
		}
	$tpl->assign(array('bbs_LIST'=>$bbs_list));



	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("manage/mk_module_m.htm"));
	
	 break;
	case "POST":

	function mkday($date){
	$a = explode("-",$date);
	$mkt = mktime(00, 00, 01, $a[1],  $a[2], $a[0]);
	return $mkt;
	}

	$num_start_date = mkday($num_start_date);


	$FH = &WebApp::singleton('FileHost');

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));



	$FTP->mkdir(_DOC_ROOT."/project/".$mcode);
	$FTP->chmod(_DOC_ROOT."/project/".$mcode,777);

	if($upfile1) {
	$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
	$file->Path = _DOC_ROOT."/project/".$mcode."/";  // 마지막에 /꼭 붙여야함

	//$file->file_mkdir(); 
	if(!$file->Ext("gif,jpg,png"))  {
	echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
	exit;
	 }
	$mk = mktime();

	$file->file_rename($mk); 
	if(!$file->upload()){
	//echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
	//exit;
	}
	$file->upload();
	//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 이미지일때 가로 세로 사이즈로 컨버팅


	}






			switch ($mode) {
			case "add":
	
			$sql = "INSERT INTO ".TAB_PROJECT." (
					NUM_MCODE, 
					STR_TITLE, 
					STR_ST, 
				   STR_INT, 
				   STR_LANG, 
				   STR_IMAGE, 
				   NUM_START_DATE, 
				   STR_PM1, 
				   STR_PM2, 
				   STR_PM3, 
				   STR_DM1, 
				   STR_DM2, 
				   STR_DM3, 
				   NUM_BOARD_MCODE1, 
				   NUM_BOARD_MCODE2, 
				   NUM_BOARD_MCODE3, 
				   NUM_BOARD_MCODE4, 
				   STR_MEMO
					  ) VALUES (
								
					$mcode, 
					'$str_title', 
					'$str_st', 
				   '$str_int', 
				   '$str_lang', 
				   '$str_image', 
				   '$num_start_date', 
				   '$str_pm1', 
				   '$str_pm2', 
				   '$str_pm3', 
				   '$str_dm1', 
				   '$str_dm2', 
				   '$str_dm3', 
				   '$num_board_mcode1', 
				   '$num_board_mcode2', 
				   '$num_board_mcode3', 
				   '$num_board_mcode4', 
				   '$str_memo') ";
			
						if($DB->query($sql)){
						$DB->commit();
						
			
			
				echo '<script>alert("저장되었습니다.");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.mk_module?mcode=$mcode'\">";
				}
			 break;
			case "update":
			 $sql = "UPDATE ".TAB_PROJECT." SET 
			
			                                                                                     
				   str_title =                        	   '$str_title',                    
				   str_st = 							   '$str_st',                      
				   str_int =  							   '$str_int',                     
				   str_lang  =  							   '$str_lang',                   
				   str_image =  						   '$str_image',                
				   num_start_date  =  				   '$num_start_date',        
				   str_pm1  =  							   '$str_pm1',                   
				   str_pm2  =  							   '$str_pm2',                   
				   str_pm3  =  							   '$str_pm3',                   
				   str_dm1  =  							   '$str_dm1',                   
				   str_dm2  =  							   '$str_dm2',                   
				   str_dm3  =  							   '$str_dm3',                   
				   num_board_mcode1 = 		   '$num_board_mcode1', 
				   num_board_mcode2 = 		   '$num_board_mcode2', 
				   num_board_mcode3 = 		   '$num_board_mcode3', 
				   num_board_mcode4 = 		   '$num_board_mcode4', 
				   str_memo = 						   '$str_memo'                 
			
			WHERE num_mcode = $mcode";


			 if($DB->query($sql)){
			 $DB->commit();
			
				echo '<script>alert("수정되었습니다.");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.mk_module?mcode=$mcode'\">";
			 }
			 break;
			}


	 break;
	}

?>