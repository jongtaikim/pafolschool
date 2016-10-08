<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 세션 만들기~이~ 세션만들기~~이~
*****************************************************************
* 
*/
//2008-04-17 종태 라이브러리를 위해서

$HOST = $_SERVER['HTTP_HOST'];




  session_save_path("/hosts/$HOST/tmp");
  session_start();



	$max_c = count($_SESSION['tem_ses']);
	if($max_c) {

	for($ii=0; $ii<count($_SESSION['tem_ses']); $ii++) {
		if($_SESSION['tem_ses'][$ii][name]==$mou_name) {
		$max_c  =  $ii;	
		}
	}
	}
	if(!$max_c) $max_c = 0;

	if($type_t) 	$conf['type'] = $type_t;
	if($listnum_t)	$conf['listnum'] = $listnum_t;
	if($col_t) 	$conf['col'] = $col_t;
	if($len_t) 	$conf['len'] = $len_t;
	if($subject_t) $conf['subject'] = $subject_t;
	if($img_w_t) $conf['img_w'] = $img_w_t;
	if($img_h_t) $conf['img_h'] = $img_h_t;

	if($color1_t) $conf['color1'] = $color1_t;
	if($color2_t) $conf['color2'] = $color2_t;
	if($font_t) $conf['font'] = iconv("utf-8","euc-kr",$font_t);
	if($font_size_t) $conf['font_size'] = $font_size_t;
	if($text_len_t) $conf['text_len'] = $text_len_t;
	if($bbs_code) $conf['bbs_code'] = $bbs_code;
	
	if($title2_t) $conf['title2'] = iconv("utf-8","euc-kr",$title2_t); 
	if($bbs_title) $conf['bbs_title'] = iconv("utf-8","euc-kr",$bbs_title); 



	$_SESSION['tem_ses'][$max_c]['name'] = $mou_name;

	$_SESSION['tem_ses'][$max_c]['type'] = $type_t;
	$_SESSION['tem_ses'][$max_c]['listnum'] = $listnum_t;
	$_SESSION['tem_ses'][$max_c]['col'] = $col_t;
	$_SESSION['tem_ses'][$max_c]['len'] = $len_t;
	$_SESSION['tem_ses'][$max_c]['subject'] = $subject_t;

	$_SESSION['tem_ses'][$max_c]['img_w'] = $img_w_t;
	$_SESSION['tem_ses'][$max_c]['img_h'] = $img_h_t;
	$_SESSION['tem_ses'][$max_c]['title2'] = iconv("utf-8","euc-kr",$title2_t);

	$_SESSION['tem_ses'][$max_c]['color1'] = $color1_t;
	$_SESSION['tem_ses'][$max_c]['color2'] = $color2_t;
	$_SESSION['tem_ses'][$max_c]['font'] = $font_t;
	$_SESSION['tem_ses'][$max_c]['font_size'] = $font_size_t;
	$_SESSION['tem_ses'][$max_c]['text_len'] = $text_len_t;

	$_SESSION['tem_ses'][$max_c]['width'] = $width_t;
	$_SESSION['tem_ses'][$max_c]['height'] = $height_t;

	$_SESSION['tem_ses'][$max_c]['bbs_title'] = iconv("utf-8","euc-kr",$bbs_title);
	$_SESSION['tem_ses'][$max_c]['bbs_code'] = iconv("utf-8","euc-kr",$bbs_code);

	if(!$conf[skin]){
		if(strlen(_THEME) == 6) {
		$type_number = substr(strtolower(_THEME),strlen(strtolower(_THEME))-2,strlen(strtolower(_THEME)));	
		}else{
		$type_number = substr(strtolower(_THEME),strlen(strtolower(_THEME))-1,strlen(strtolower(_THEME)));
		}

		if(!$conf[skin]) {
		 if($type_number <10) 	$type_number = "0".$type_number;
		 $conf[skin] = "type".$type_number;
		}

	}
	
	
	if(!$theme && !$_SESSION['tem_ses'][$max_c]['skin']) {
	
		$theme = $conf['skin']; 
	
	}else if($theme && !$_SESSION['tem_ses'][$max_c]['skin']) {

		$_SESSION['tem_ses'][$max_c]['skin'] = $theme;
	
	}else if(!$theme && $_SESSION['tem_ses'][$max_c]['skin']){

		$theme = $_SESSION['tem_ses'][$max_c]['skin'];

	}else if($theme && $_SESSION['tem_ses'][$max_c]['skin']){

		$_SESSION['tem_ses'][$max_c]['skin'] = $theme;
	
	}
	


	$del="y";

	 



?>