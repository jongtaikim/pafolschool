<?

$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid(_OID);
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

function getRSS($url,$encode){ 
    
	/*
	$curl = &WebApp::singleton('Curl');
	$curl->url = $url;
	$curl->referer = $url;
	$buffer = $curl->curl_run();
	*/
	$fd = fopen ($url, "r"); 
    while (!feof ($fd)) { 
       		
		if($encode == "UTF-8"){ 
		 $buffer .= iconv("UTF-8","EUC-KR",fgets($fd, 4096)); 
		 }else{
		 $buffer .= fgets($fd, 4096); 
		 }

    } 
    fclose ($fd); 

    return $buffer; 
} 

// 내용만 뽑아내기 
function parseTag($tag,$value){ 
    $value =  explode("</".$tag.">",$value); 
    $value = explode("<".$tag.">",$value[0]);
	
	$value = str_replace("<![CDATA[","",$value[1]);
	$value = str_replace("]]>","",$value);

	/*$value = str_replace("&lt;","<",$value);
	$value = str_replace("&gt;",">",$value);
	$value = str_replace("&quot",'"',$value);*/
	$value = htmlspecialchars_decode($value);
    return $value; 
} 


function htmlspecialchars2($s) {
return(strtr($s, array('&#' => '&#', '&' => '&', '"' => '"', '<' => '<', '>' => '>')));
}

//한글 자르기 
function hstrCut($msg,$cut_size,$end_str = "...") { 
    if( (strlen($msg) > $cut_size) & ($cut_size > 0) ) { 
            $msg = substr($msg,0,$cut_size); 
            $msg = preg_replace("/(([\\x80-\\xFE].)*)[\\x80-\\xFE]?$/","\\1",$msg); 
            $msg .= $end_str; 
    } 
    return $msg; 
} 

// 보여지는 부분 
function RSS_reader($count,$url,$encode = "EUC-KR"){ 
    global $mcode,$DB,$_conf;
	$channel = parseTag("channel",getRSS($url,$encode)); 
    // 인코딩 변환 
  
	
	
    $channel = str_replace("</item>","",$channel); 
    $item = explode("<item>",$channel); 
    // 제목 처리 
    $siteTitle = parseTag("title",$item[0]); 
    $siteLink = parseTag("link",$item[0]); 
    $siteDescription = parseTag("description",$item[0]); 
    
	 
    //제목 출력 
    //$html = "[<a href=\"$siteLink\" target=\"_blank\">$siteTitle</a>]<br />"; 
	
	$ii = 0;

    //각 게시물 제목 처리 
    for($i=1;$i<=$count;$i++){ 
        if(!isset($item["$i"])) break; 
		
		$title[$ii] = parseTag("title",$item[$i]); 
		
		$sql = "
				SELECT
					count(*)
				FROM
					TAB_BOARD
				WHERE
					num_oid = "._OID." and num_mcode=$mcode and str_title = '".$title[$ii]."'
			";
		//echo $sql."<br><Br>";
		$sk_w = $DB->sqlFetchOne($sql);
		if(!$sk_w) $sk_w = 0;
        if($sk_w<1){
			if($_conf[str_rss_cate])	{
				if(strstr( $title[$ii],$_conf[str_rss_cate])){
				$data[$ii][str_title] = $title[$ii];
				$data[$ii][str_text] = parseTag("description",$item[$i])."<br><br><a href='".parseTag("link",$item[$i])."' target='_blank'>출처 : ".parseTag("link",$item[$i])."</a>"; 
				$data[$ii][str_id] = "admin"; 

				$ii++;
			}
			}else{
						
		
				$data[$ii][str_title] = $title[$ii];
				$data[$ii][str_text] = parseTag("description",$item[$i])."<br><br><a href='".parseTag("link",$item[$i])."' target='_blank'>출처 : ".parseTag("link",$item[$i])."</a>"; 
				$data[$ii][str_id] = "admin"; 

				$ii++;
			
			}

		}
    } 
	$_SESSION[rss_update][$mcode] = "y";
	return $data;
	
} 


if($_GET[str_rss_url]) $_conf[str_rss_url] = "http://".$_GET[str_rss_url];
if($_GET[num_rss_count]) $_conf[num_rss_count] = $_GET[num_rss_count];
if($_GET[str_iconv]) $_conf[str_iconv] = $_GET[str_iconv];
if($_GET[str_rss_cate]) $_conf[str_rss_cate] = $_GET[str_rss_cate];



$param = "&str_rss_url=".$_GET[str_rss_url]."&num_rss_count=".$_GET[num_rss_count]."&str_iconv=".$_GET[str_iconv]."&=str_rss_cate".$_GET[str_rss_cate];

if($_conf[str_rss_url] && $_SESSION[ADMIN]){

$data = RSS_reader($_conf[num_rss_count],$_conf[str_rss_url],$_conf[str_iconv]); 



 for($i=0; $i<count($data); $i++) {
				
				$serial = $DB->sqlFetchOne("
				SELECT
				
						max(num_serial) + 1
				FROM
					TAB_BOARD
				WHERE
					 num_oid = '$_OID' and  num_mcode=$mcode 
				");

				if (!$serial) $serial = 1;

				 if($data[$i][str_text]){
				  $str_text =  $data[$i][str_text];
				  if($img_in)$str_text = WebApp::ImgFindUploadUrl($str_text);
				  $str_text = nl2br(addslashes($str_text));
				  flush();
				
				 }else{
				 $str_text = '&nbsp;';
				 }

			//$data[$i][str_title] = addslashes($data[$i][str_title]);
			
			if(!$data[$i][str_pass])  $data[$i][str_pass] = "0000";
		
		



			//$data[$i][str_thumb] = $data[$i][str_thumb];
				$iaa++;
				$prbar =  round(($i/count($bbs_data) ) * 100);
			
		
	
			
			$group = $DB->sqlFetchOne("
				SELECT
					max(num_group) + 1
				FROM
					TAB_BOARD
				WHERE
					$que num_mcode=$mcode
			");
	
			if (!$group) $group = 1;
			$depth = 0;
			$step = 0;
			
		

			$sql2= "INSERT INTO ".TAB_BOARD." (
				num_oid,
				num_mcode,
				num_serial,
				num_group,
				num_step,
				num_depth,
				str_user,
				str_pass,
				str_title,
				str_text,
				dt_date,
				num_hit,
				num_file,
				str_ip,
				num_notice,
				str_thumb,
				str_email,
				str_name
						) VALUES (
				"._OID.",
				". $mcode.",
				". $serial.",
				".  $group.",
				". $depth.",
				". $depth.",
				'".$data[$i][str_id]."',
				'ewut2009',
				'". $data[$i][str_title]."',
				 '$str_text',
				'".date("Y-m-d")."',
				'0',
				'0',
				'".$_SERVER["SERVER_ADDR"]."',
				'0',
				'',
				'',
				'스크랩'
							
				) ";
			
		
				
				if($DB->query($sql2)){
			 	$DB->commit();
				}
				flush();
			
 }

}


if($_GET[str_rss_url] || $rut){
echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.list?mcode=$mcode".$param."'\">";
exit;
}


// WebApp::moveBack();
?>