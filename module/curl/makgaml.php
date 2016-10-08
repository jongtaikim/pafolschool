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


	
	function curl_run()
	{
		$ch = curl_init();
		

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_REFERER, $this->referer);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
		ob_start();
		$log = curl_exec ($ch);
		ob_end_clean();
		curl_close ($ch);
		return $log;
	}

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
}

function cut2($a,$b){
global $res;

	$res =  str_replace("'","",$res);
	$res =  str_replace('"',"",$res);
	$res =  str_replace('	',"",$res);

	$a =  str_replace("'","",$a);
	$a =  str_replace('"',"",$a);
	$b =  str_replace("'","",$b);
	$b =  str_replace('"',"",$b);




	$tmp = explode($a,$res);
	$tmp = explode($b,$tmp[1]);
	$tmp = $tmp[0];
	return $tmp;
}

function cut3($res,$a,$b){

	$res =  str_replace("'","",$res);
	$res =  str_replace('"',"",$res);
	$res =  str_replace('	',"",$res);

	$a =  str_replace("'","",$a);
	$a =  str_replace('"',"",$a);
	$b =  str_replace("'","",$b);
	$b =  str_replace('"',"",$b);




	$tmp = explode($a,$res);
	$tmp = explode($b,$tmp[1]);
	$tmp = $tmp[0];
	return $tmp;
}

function delHTML($text){
	$text = strip_tags($text);
	//$text = str_replace("&nbsp;","",$text);
	return $text;
}

if($mode && $snum && $enum && $bbs_code){



$curl = new curl_class();



?>
<form method=post action="http://mokgam.now17.co.kr/board_auto" id="sdadFoem"  name="sdadFoem">
<input type="text" name="mcode" value="<?=$_GET[mcode]?>" class="">
<input type="submit" name="" value="될까나?" class=""><br>

<?
$aa = 0;
for($ii=$snum; $ii<=$enum; $ii++) {

if($gall){

$curl->url="http://www.eunhaeng-sh.ms.kr/?_page=".$bbs_code."&_action=view&_view=view&&mode=&sw=&keyword=&pgnum=5&cidx=".$ii."&idx=".$ii."";

$res = $curl->curl_run();

//echo $res; exit;

$title = cut2('><font color=>','</font></td>');
$title = html_entity_decode($title);
if($title){
$name = cut2('<td style=color:; word-break:break-all;>','</td>');
$num_hit = cut2('(조회수:',')');
if(!$num_hit)   $num_hit = 0;
$date = cut2('<font color=>(',' ');

$str_text = cut2('<!-- /첨부파일이 이미지인지 영상인지 음성인지 판단해서 출력 -->','<!-- 첨부파일 관련 스크립트 -->');
$str_text = strip_tags($str_text);

echo $ii;
?>

<input type="text" name="bbs_data[<?=$aa?>][str_name]" value="<?=$name?>" >
<input type="text" name="bbs_data[<?=$aa?>][str_id]" value="wadmin" >
<input type="text" name="bbs_data[<?=$aa?>][dt_date]" value="<?=$date?>" >
<input type="text" name="bbs_data[<?=$aa?>][str_title]" value="<?=$title?>" >
<textarea name="bbs_data[<?=$aa?>][str_text]" rows="" cols=""><?=$str_text?></textarea>
<input type="text" name="bbs_data[<?=$aa?>][num_hit]" value="<?=$num_hit?>" >


<?

$file = cut2('<td style="padding-left:10; color:;">첨부파일</td>','</td>');
$file = explode('<font color=>',$file);

	for($fi=0; $fi<count($file); $fi++) {
		if($fi > 0){
			$file[$fi] = delHTML($file[$fi]);
			$file[$fi] =nl2br($file[$fi]);
			$file[$fi] = str_replace("<br />","",trim($file[$fi]));
			$file[$fi] = str_replace("	","",trim($file[$fi]));
			?>
			 <input type="text" name="bbs_data[<?=$aa?>][files][<?=$fi?>][url]" value="http://www.eunhaeng-sh.ms.kr/up_file/easy_album_<?=$bbs_code?>/<?=$file[$fi]?>" >
			
			<input type="text" name="bbs_data[<?=$aa?>][files][<?=$fi?>][str_refile]" value="<?=$file[$fi]?>" >
			<?

		}

	}


echo "<br>";
flush();

$aa++;
}


}else{




$curl->url="http://www.mokgam.es.kr/netboard/mboard/mboard.asp?exe=view&board_id=".$bbs_code."&group_name=".$bbs_code2."&idx_num=".$ii."";
$res = $curl->curl_login();

//echo $res; exit;

$title = cut2('<td width=14><img src=/images/bbs/bbs_td_01.gif width=14 height=32></td>','<td width=14><img src=/images/bbs/bbs_td_02.gif width=14 height=32></td>');
$title = strip_tags($title);
$title  = str_replace("
","",trim($title));


if($title){
$name = cut2(': <a style=cursor:hand OnClick=user_menu(','/a></td>');
$name = cut3($name,'>','<');

$num_hit = cut2('(조회수:',')');
if(!$num_hit)   $num_hit = 0;


$date = cut2('일자</span>','</td>');

$date = cut3($date,': ',' ');


$str_text = cut2('margin-left:5;>','</p>');

//$str_text= str_replace(" ","",$str_text);
//if(strlen($str_text) > 3) $str_text = "<p></p>";

echo $ii;
?>

<input type="text" name="bbs_data[<?=$aa?>][str_name]" value="<?=$name?>" >
<input type="text" name="bbs_data[<?=$aa?>][str_id]" value="wadmin" >
<input type="text" name="bbs_data[<?=$aa?>][dt_date]" value="<?=$date?>" >
<input type="text" name="bbs_data[<?=$aa?>][str_title]" value="<?=$title?>" >
<textarea name="bbs_data[<?=$aa?>][str_text]" rows="" cols=""><?=$str_text?></textarea>
<input type="text" name="bbs_data[<?=$aa?>][num_hit]" value="<?=$num_hit?>" >


<?

$file = cut2('<td height=25 colspan=6  style=padding:0 0 0 10>','<table align=center cellpadding=0 cellspacing=0 width=100%>');
$file = explode('<a href=filedown.asp',$file);

$iisd = 0;
	for($fi=0; $fi<count($file); $fi++) {
		if($fi > 0){
			$filenum[$fi] = cut3($file[$fi],'down_num=','&');
			echo $filenum[$fi];
			$file[$fi] = delHTML($file[$fi]);
			$file[$fi] =nl2br($file[$fi]);
			$file[$fi] = str_replace("<br />","",trim($file[$fi]));
			
			$file[$fi] = str_replace("	","",trim($file[$fi]));
			$file[$fi] = str_replace("        ","",trim($file[$fi]));
			$file[$fi] = str_replace("
","",trim($file[$fi]));
			
			$file[$fi] = cut3($file[$fi],'>','&nbsp;(');
			
				
			
			?>
			 <input type="text" name="bbs_data[<?=$aa?>][files][<?=$iisd?>][url]" value="http://www.mokgam.es.kr/netboard/mboard/filedown.asp?down_num=<?=$filenum[$fi]?>&board_id=<?=$bbs_code?>&group_name=kpe&file=<?=$fi?>" >
			
			<input type="text" name="bbs_data[<?=$aa?>][files][<?=$iisd?>][str_refile]" value="<?=$file[$fi]?>" >
			<?
		$iisd ++;
		}

	}


echo "<br>";
flush();


$aa++;
}
}

}

echo "</form>";
echo '<script>document.getElementById("sdadFoem").submit();</script>';
	
}else{

?>

<form >
<input type="hidden" name="mode" value="y">
<input type="hidden" name="mcode" value="<?=$_GET[mcode]?>" class="">
게시판아이디<input type="text" name="bbs_code" value="m_" class=""><br>
시작<input type="text" name="snum" value="1" class="">
끝<input type="text" name="enum" value="100" class="">
게시판그룹<input type="text" name="bbs_code2" value="kpe" class=""><br>
<input type="checkbox" name="gall" value="y"> 겔러리?
<input type="submit" name="" value="뽑기" class="">
</form>


<? } ?>