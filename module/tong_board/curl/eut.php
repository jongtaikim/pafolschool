<?
set_time_limit(0);
@header("pragma: no-cache");
@header("Cache-Control: no-store, no-cache, must-revalidate"); 
class curl_class 
{
	var $cookie;
	var $url;
	var $post;
	var $referer;
	var $headers;
	var $curl_error;
	function curl_login()
	{
		$ch = curl_init();
		//echo $this-> cookie."<br>";
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);	
		if( !empty( $this->referer ) ) {
			curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		}
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();      // prevent any output
		$res = curl_exec ($ch); // execute the curl command
		if (!$res) { 
			$this->curl_error = curl_error($ch); 
		}
		ob_end_clean();  // stop preventing output
		curl_close($ch);
		$this->post = '';
		return $res;
	}

	function curl_login_02()
	{
		$ch = curl_init();
		//echo $this-> cookie."<br>";
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);  


		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);	
		if( !empty( $this->referer ) ) {
			curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		}
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();      // prevent any output
		$res = curl_exec ($ch); // execute the curl command
		if (!$res) { 
			$this->curl_error = curl_error($ch); 
		}
		ob_end_clean();  // stop preventing output
		curl_close($ch);
		$this->post = '';
		return $res;
	}


function myculr_login() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL,$this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this-> cookie); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this-> cookie); 

		$res = curl_exec ($ch); // execute the curl command
		if (!$res) { 
			$this->curl_error = curl_error($ch); 
		}
		ob_end_clean();  // stop preventing output
		curl_close($ch);
		$this->post = '';
		return $res;
}

	function curl_run2()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_HEADER, 0);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
	
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}

	
	function curl_run()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}

	function curl_loc()
	{
		$ch = curl_init();
		if( !empty( $this->headers ) ) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->headers );
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post );
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}


function curl_loc2()
	{
		$ch = curl_init();
		if( !empty( $this->headers ) ) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->headers );
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 2);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post );
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}



	function curl_agent()
	{
		$ch = curl_init();
		if( !empty( $this->headers ) ) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->headers );
		}
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post );
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}



function curl_login_ok()
	
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this-> cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();      // prevent any output
		$res = curl_exec ($ch); // execute the curl command
		ob_end_clean();  // stop preventing output
		curl_close($ch);
		$this->post = '';
		return $res;
	}

	function curl_run_ok()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}

}



function resizeimg($url)
{

$f_img = $url;

			$normal_gallery=GetImageSize($f_img);


			$bbs_width = 600;
			$bbs_height = 600;
					
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
			
			$this_size = $img_w."|".$img_h;
			$this_size = explode("|",$this_size);
				
			return $this_size;
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





$curl = new curl_class();


$DB = &WebApp::singleton("DB");

//$mcode = "181111";
$bbs_id = $code;


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

if(!is_dir(_DOC_ROOT."/data/hosts/".$_OID)) {
$FTP->mkdir(_DOC_ROOT."/data/hosts/".$_OID);
$FTP->chmod(_DOC_ROOT."/data/hosts/".$_OID,777);
}
if(!is_dir(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id)) {
$FTP->mkdir(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id);
$FTP->chmod(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id,777);
}

$FTP->close();



 $sql = "delete from tab_board where num_oid = $_OID and num_mcode = '$mcode'";
 $DB->query($sql);
 $DB->commit();

 $sql = "delete from tab_files Where num_oid = $_OID and str_code = '$mcode'";
 $DB->query($sql);
 $DB->commit();

for($ii=1; $ii<150; $ii++) {
	
//////////////////////////////////////////////////////////////////////////////////////////////
$curl->url="http://kumok.ms.kr/?act=board.read&code=".$code."&num=".$ii."&id=".$ii;


$res = $curl->curl_login();

$res = explode('<td><b><span style="padding-left:5px; color:#000000" >글읽기</span></b>',$res);
$res = explode('<td width="12%" align="center" bgcolor="F8F8F8">다음글</td>',$res[1]);
$res = $res[0];



$subject = explode('<td colspan="3">',$res);
$subject = explode("</td>",$subject[1]);
$subject = $subject[0];	

if($subject){

$date = explode('<td width="38%">',$res);
$date = explode('</td>',$date[2]);
$date = $date[0];	


$name = explode('<td width="38%">',$res);
$name = explode('</td>',$name[1]);
$name = $name[0];	

$content = explode('<div id="tmpContentsArea">',$res);
$content = explode('</div>',$content[1]);
$content = $content[0];	
$content = str_replace("'","`",$content );

$file1 = explode('<a href="',$res);
$file1 = explode('">',$file1[1]);
$file1 = $file1[0];	

$file1_name = explode('<a href="',$res);

$file1_name = explode('align="absmiddle">',$file1_name[1]);
$file1_name = explode("</a>",$file1_name[1]);	
$file1_name = $file1_name[0];

	if($file1) {
		

				///////////////////////////////////////////
				$file1_exp = explode(".",$file1_name);
				$file1_exp = strtolower($file1_exp[count($file1_exp)-1]);

				$url = $file1;
				$ch = curl_init($url);
				
				
				$mk = mktime();
				
				$file1_r = $mk.".".$file1_exp;

				$tmp_file = "./data/hosts/".$_OID."/".$bbs_id."/".$file1_r;

				$fp = fopen($tmp_file, "w");

				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
				


				
				///////////////////////////////////////////////////

	}

$file2 = explode('<a href="',$res);
$file2 = explode('">',$file2[2]);
$file2 = $file2[0];	
$file2_name = explode('<a href="',$res);

$file2_name = explode('align="absmiddle">',$file2_name[1]);
$file2_name = explode("</a>",$file2_name[1]);	
$file2_name = $file2_name[0];

	if($file2) {
		

				///////////////////////////////////////////
				$file2_exp = explode(".",$file2_name);
				$file2_exp = strtolower($file2_exp[count($file2_exp)-1]);

				$url = $file2;
				$ch = curl_init($url);
				
				
				$mk = mktime();
				
				$file2_r = $mk.".".$file2_exp;

				$tmp_file = "./data/hosts/".$_OID."/".$bbs_id."/".$file2_r;

				$fp = fopen($tmp_file, "w");

				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
				


				
				///////////////////////////////////////////////////

	}

$hit = 0;
echo $subject." /".$date." / ".$hit."/".$name."/".$file1_name.".".$file1_exp."<TEXTAREA >".$content."</TEXTAREA><br>";


//////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////
if($run == "Y") {
$_sect_ = "menu";
$_code_ = $mcode;
$FH = &WebApp::singleton('FileHost',$_sect_,$_code_);


$FH->set_oid($oid);



$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
					max(num_serial) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				 num_oid = '$_OID' and  num_mcode=$mcode 
		");

	if (!$serial) $serial = 1;


	$group = $DB->sqlFetchOne("
			SELECT
				max(num_group) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				$que num_mcode=$mcode
		");
		
		
		if (!$group) $group = 1;
		$depth = 0;
		$step = 0;


		$num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$user = "admin";
		$name = $name;
		$title = $subject;
		$pass = "0000";
		$email = "000@0000.000";
		$upfiles = "";


		$str_text = $content;
		
		if(!$str_text) $str_text = "&nbsp;";
		
		
		if($file1) {
			$num_file = $num_file +1;
		
		}else{
		$num_file = $num_file + 0;
		}

		if($file2) {
			$num_file = $num_file +1;
		}else{
		$num_file = $num_file + 0;
		}
		if(!$num_file) $num_file = 0;

		$str_text = $FH->get_content($str_text);
		list($str1,$str2,$str3,$str4,$str5) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!



		$use_html = "Y";
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');
        $num_hit = $hit;
        $dt_date = $date;


$str_thumb = "/data/hosts/".$_OID."/".$bbs_id."/".$file1_r;

	$sql = 
			"INSERT INTO TAB_BOARD
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text1, str_text2, str_text3, str_text4, str_text5, chr_html, dt_date, str_ip, num_hit, str_hak, num_input_pass,num_file,str_thumb) 
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$str4','$str5','$use_html', TO_DATE('".$date."','YYYY-MM-DD'),'$ip', $num_hit, '$str_hak','$num_input_pass','$num_file','$str_thumb')
			";
//echo "<xmp>";
//echo $sql."<br>";

if($DB->query($sql)){
			echo "저장<br>";
			$DB->commit();



	$sql = "select MAX(NUM_SERIAL)  from TAB_FILES where num_oid = '$_OID' and str_sect= '$_sect_' and str_code = '$_code_' and num_main = '$serial' ";
	$f_max = $DB -> sqlFetchOne($sql) + 1;

	$sql = "INSERT INTO TAB_FILES ( 
					NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,
					STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_TA
					) VALUES (
					'$_OID','$_sect_','$_code_','$serial','$f_max','$file1_name','$file1_r','$file1_exp','$bbs_id'
					)";

	$DB->query($sql);
	$DB->commit();




	$f_max = $f_max + 1;

	$sql = "INSERT INTO TAB_FILES ( 
					NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,
					STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_TA
					) VALUES (
					'$_OID','$_sect_','$_code_','$serial','$f_max','$file2_name','$file2_r','$file2_exp','$bbs_id'
					)";

	$DB->query($sql);
	$DB->commit();



			}else{
			echo "실패<br>";
			}


	unset($num_file);
}
}






}
?>