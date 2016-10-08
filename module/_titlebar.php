<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/_titlebar.php
* 작성일: 2004-10-16
* 작성자: 거친마루
* 설  명: 타이틀바 붙이기
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
$DB = &WebApp::singleton('DB');

if($param[cate]){
	$code = $param[cate];
}else{
	$code = $param[mcode];
}



$sql = "select * from ".TAB_MENU." where num_oid = "._OID." and num_cate = '".$code."' ";

$titles =$DB -> sqlFetch($sql);
$tpl->assign(array('menu_data'=>$titles));



	
	if(is_file(_DOC_ROOT."/hosts/".HOST."/title/".$param[mcode].".gif")){
		$titles[title_img] = "/hosts/".HOST."/title/".$param[mcode].".gif";
	}else{
		//$titles[title_img] = "./images/titlebar_ngs.gif";
	}
if(!$GLOBALS['DOC_TITLE']) $GLOBALS['DOC_TITLE']  = "str:".$titles[str_title];
if(!$GLOBALS['DOC_TITLE2']) $GLOBALS['DOC_TITLE2']  = "str:".$titles[str_title2];
	
list($title_type,$title_value) = explode(':',$GLOBALS['DOC_TITLE'],2);
list($title_type2,$title_value2) = explode(':',$GLOBALS['DOC_TITLE2'],2);


if(!function_exists('text_array')) {
function text_array($text){

 if(!$text) return;
$text_array =  content_split($text,2);
$len = 0;
$text_a = array();
for($ii=0; $ii<count($text_array); $ii++) {
	if(strlen($text_array[$ii]) == 2 && ord($text_array[$ii]) < 127) {
	$a = content_split($text_array[$ii],1);

	$text_a[$len] = $a[0];
	$len = $len + 1;	
	
	$text_a[$len] = $a[1];
	$len = $len + 1;

	}else{
	$text_a[$len] = $text_array[$ii];
	$len = $len + 1;
	}
}
return $text_a;
}
}
if(!function_exists('content_split')) {
function content_split($str,$len = 2) {
	if(strstr($str,'#')) {
	$str = str_replace("#","",$str);
	}
	
	$ret = array();
	while ($str) {
		$i = $len - 1;
		while(ord($str{$i}) > 127) {$i--;}  // 한글이 아닐때까지 찾는다.
		while($i < ($len - 2)) { $i += 2; } // 최대길이까지 2씩 더한다
		$ret[] = substr($str,0,$i+1);
		$str = substr($str,$i+1);
	}
	return $ret;
}
}

//$titles[str_title] = str_replace(" ","",$titles[str_title]);

$text_array =  text_array($titles[str_title]);	

	for($ii=0; $ii<count($text_array); $ii++) {
		if($text_array[$ii] == " "){
		
		$ww_r[$ii] = 10;

		}else if($text_array[$ii] == "/"){
		
		$ww_r[$ii] = 10;

		}else if(ord($text_array[$ii]) > 127) { //한글
		
		$ww_r[$ii] = 22.8;
		
		}else if(ord($text_array[$ii]) < 57) { //숫자
	
		$ww_r[$ii] = 22;

		}else if(ord($text_array[$ii]) < 45) { //특수
	
		$ww_r[$ii] = 10;
	
		}else{ //영어

		$ww_r[$ii] = 17 ;
		
		}
	
	}

 $text_cate[$param[cate]]['title1'] = array_sum($ww_r);

if($titles[str_title] == "ECO-Design"){
	 $text_cate[$param[cate]]['title1'] = "139";
}

if($titles[str_title] == "ECO-Design"){
	 $text_cate[$param[cate]]['title1'] = "139";
}

if($titles[str_title] == "Alumni게시판"){
	 $text_cate[$param[cate]]['title1'] = "139";
}

if($titles[str_title] == "에코시안Poll"){
	 $text_cate[$param[cate]]['title1'] = "129";
}

if($titles[str_title] == "GMS(녹색경영)"){
	 $text_cate[$param[cate]]['title1'] = "159";
}
if($titles[str_title] == "수료증/자료발급"){
	 $text_cate[$param[cate]]['title1'] = "169";
}





if($text_cate[$param[cate]]['title1']){
	$title_text_len = $text_cate[$param[cate]]['title1'];
}else{
	$title_text_len = WebApp::strlens($title_value);

}

if($text_cate[$param[cate]]['title2']) {
	$title_text2_len = $text_cate[$param[cate]]['title2'];
}else{
	$title_text2_len = WebApp::strlens($title_value2);
}




switch ($title_type) {
	case 'image':
		$tpl->define('#TITLE','<img src="'.$title_value.'">');
		break;
	case 'html': case 'file':
		$tpl->define('!TITLE',WebApp::mapPath($title_value));
		break;
	case 'str':
	
		$tpl->assign(array(
		'title_text'=>$title_value,
		'title_text2'=>$title_value2,
		'title_text_len'=>$title_text_len,
		'title_text2_len'=>$title_text2_len,
		'title_img'=>$titles[title_img],
		));	
		$template = $param['template'];
		$tpl->define('titlebar_W_',$template);
		$content = $tpl->fetch('titlebar_W_');
		echo $content ;
		
		break;
	case 'raw': default:
		$tpl->define('#TITLE',$title_value);
		break;
}
?>
