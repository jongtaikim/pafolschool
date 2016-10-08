<?
//2008-03-07 종태
//제로보드용 공지사항 가져오기 모듈
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


$curl = new curl_class();


$curl->url="http://www.ulleung.ms.kr/board/readFile.asp?filename=2_IMG_0908.jpg";
$res = $curl->curl_run();
echo $res;
exit;

$DB = &WebApp::singleton('DB');

$_sect_ = "main";
$_code_ = 'news.'.$code;
$FH = &WebApp::singleton('FileHost',$_sect_,$_code_);
$id = $_REQUEST['id'];

//$mcode = "181111";


//$bbs_id = "notice";


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

if(!is_dir(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id)) {
	

$FTP->mkdir(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id);
$FTP->chmod(_DOC_ROOT."/data/hosts/".$_OID."/".$bbs_id,777);
}

$FTP->close();

for($ii=1; $ii<500; $ii++) {
	
//////////////////////////////////////////////////////////////////////////////////////////////

$curl->url="http://www.kwiin.es.kr/news/news_01.asp?mode=content&dbname=".$bbs_id."&num=".$ii;
$res = $curl->curl_login();


$subject = explode("<strong> : ",$res);
$subject = explode("</strong></td>",$subject[1]);
$subject = $subject[0];	

if($subject){

$date = explode('<span class="Tahoma8"><font color=gray>',$res);
$date = explode('</font></span>&nbsp; </td>',$date[1]);
$date = $date[0];	


$hit = explode('<td width="26%"  class=sepa>',$res);
$hit = explode('</td>',$hit[2]);
$hit = $hit[0];	

$content = explode('<td style="padding:5 5 5 5;word-break:break-all;" valign="top" height="200"> ',$res);
$content = explode('</td>',$content[1]);
$content = $content[0];	
$content = str_replace("'","`",$content );

$file1 = explode('첨부파일 : </strong><a href="',$res);
$file1 = explode('">',$file1[1]);
$file1 = $file1[0];	
$file1_name = explode("filename=",$file1);
$file1_name = explode("&",$file1_name[1]);	
$file1_name = $file1_name[0];

	if($file1) {
		

				///////////////////////////////////////////
				$file1_exp = explode(".",$file1_name);
				$file1_exp = strtolower($file1_exp[count($file1_exp)-1]);

				$url = "http://kwiin.es.kr/".$file1;
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

$file2 = explode("filenum=2'>",$res);
$file2 = explode(' ',$file2[1]);
$file2 = $file2[0];	


if($file2) {
		

				///////////////////////////////////////////
				$url2 = "http://indugwon.es.kr/bbs/data/".$bbs_id."/".$file2;
				$ch = curl_init($url2);
				$tmp_file = "./data/hosts/".$_OID."/".$bbs_id."/".$file2;

				$fp = fopen($tmp_file, "w");

				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fclose($fp);

				$file2_exp = explode(".",$file2);
				$file2_exp = $file2_exp[1];
				
				///////////////////////////////////////////////////

	}

 echo $subject." / ".$date." / ".$hit." / ".$file1_name."<br>";


//////////////////////////////////////////////////////////////////////////////////////////////
if($run == "Y") {
	




$content = $FH->get_content($content);
list($str_text1,$str_text2,$str_text3) = content_split($content);

$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID AND STR_CODE='$code'";
			$id = $DB->sqlFetchOne($sql) + 1;

	$sql = 
				"INSERT INTO ".TAB_MAIN_BOARD." (".
					"NUM_OID,STR_CODE,NUM_SERIAL,STR_TITLE,STR_TEXT1,STR_TEXT2,STR_TEXT3,CHR_HTML,DT_DATE,NUM_HIT".	
				") VALUES (".
					$_OID.",".
					"'".$code."',".
					$id.",".
					"'".strip_tags($subject)."',".
					"'".$str_text1."',".
					"'".$str_text2."',".
					"'".$str_text3."',".
					"'Y',".
					"TO_DATE('".$date."','YYYY-MM-DD'),".
					$hit.
				")";



//echo $sql."<br>";

			if($DB->query($sql)){
			echo "저장<br>";
			$DB->commit();


	
	$sql = "select MAX(NUM_SERIAL)  from TAB_FILES where num_oid = '$_OID' and str_sect= '$_sect_' and str_code = '$_code_' and num_main = '$id' ";
	$f_max = $DB -> sqlFetchOne($sql) + 1;

	$sql = "INSERT INTO TAB_FILES ( 
					NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,
					STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_TA
					) VALUES (
					'$_OID','$_sect_','$_code_','$id','$f_max','$file1_name','$file1_r','$file1_exp','$bbs_id'
					)";

	$DB->query($sql);
	$DB->commit();



/*
	$f_max = $f_max + 1;

	$sql = "INSERT INTO TAB_FILES ( 
					NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,
					STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_TA
					) VALUES (
					'$_OID','$_sect_','$_code_','$id','$f_max','$file2','$file2','$file2_exp','$bbs_id'
					)";

	$DB->query($sql);
	$DB->commit();
*/


			}else{
			echo "실패<br>";
			}


unset($num_file);
}
}
}


function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}

?>