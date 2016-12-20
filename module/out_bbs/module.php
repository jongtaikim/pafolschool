<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-06-25
* 작성자: 김종태
* 설  명: 최근게시물  모듈
*****************************************************************
* 
*/

$code = $param['code'];
//echo $num;

$DB = &WebApp::singleton('DB');

if($bbs_title) {
$conf['title'] = substr($bbs_title,0,strlen($bbs_title)-1);	
}else{
$conf['title'] = substr($conf['bbs_title'],0,strlen($conf['bbs_title'])-1);
}

if($type_t) {
$conf['type'] = substr($type_t,0,strlen($type_t)-1);
}else{
$conf['type'] = substr($conf['type'],0,strlen($conf['type'])-1);	
}


if($bbs_code) {
$conf['mcode'] = substr($bbs_code,0,strlen($bbs_code)-1);	
}else{
$conf['mcode'] = substr($conf['bbs_code'],0,strlen($conf['bbs_code'])-1);	
}


if($listnum_t) {
$conf['listnum'] = substr($listnum_t,0,strlen($listnum_t)-1);	
}else{
$conf['listnum'] = substr($conf['listnum'],0,strlen($conf['listnum'])-1);	
}

if(!$conf[skin]) 	$conf[skin] ="type01";

$tpl->assign($conf);
$tpl->assign($conf_main);


if($conf['len'] > 0) $len = $conf['len']; else $len = 28;
if($conf[text_len] > 0) $text_len = $conf[text_len]; else $text_len = 28;

for($ii=0; $ii<count($objList); $ii++) {
	if($objList[$ii][name] == $conf[skin]){
		$len  = $objList[$ii][B_len];
		$len2  = $objList[$ii][G_len];
		$len3  = $objList[$ii][W_len];
		//$len_text  = $objList[$ii][len_text];
	$tpl->assign($objList[$ii]);
	}
}



if(!$len) $len = 30;
if(!$len2) $len2 = 10;
if(!$len3) $len3 = 40;
if(!$len_text) $len_text = 100;


$array_bbs_code = explode(",",$conf['bbs_code']);
$array_bbs_title = explode(",",$conf['bbs_title']);
$array_type = explode(",",$conf['type']);
$array_listnum = explode(",",$conf['listnum']);




if($mou_name =="new_bbs")  {
	$array_bbs_code[0] = "10";
	$array_bbs_code[1] = "1010";

}



if(!$r_layout){
$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc.'._LAYOUT_R.'.'.$mou_name.'.htm';
}else{
$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc.'.$r_layout.'.'.$mou_name.'.htm';
}



include _DOC_ROOT.'/object/out_bbs/config.inc';
$tpl->assign($main_data);

$del="y";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {

//if (!is_file($cache_file)) {
	// 선택적으로 최근게시물 가져오도록 수정(2004-08-30)
 
//가로값대비 글씨 짜를 기준을 정함 2009-08-27 종태
$sql = "select str_width,str_height from TAB_ATTACH_CONFIG where num_oid = "._OID." and STR_LAYOUT='"._LAYOUT_R."' and num_css = '"._CSS."' and str_name='".$mou_name."' ";
$sizeD = $DB -> sqlFetch($sql);

if($sizeD[str_width] < 300){
$len = 22;
}

for($i=0; $i<count($array_bbs_code)-1; $i++) {
	
if($array_bbs_code[$i]) {
	

if(!$array_listnum[$i]) $array_listnum[$i] = 5;

if($mou_name !="new_bbs") $sqlp = " and num_mcode = ".$array_bbs_code[$i]."  ";

$sql = "

 select 
   str_title,
    str_name,
    num_mcode,
    num_notice,
    str_thumb,
	num_depth,
	num_serial,
	num_input_pass,
	num_comment,
	str_text,
	str_file_url1,
	str_file_url2,
	str_tmp1,
	str_tmp2,
	str_tmp3,
	str_tmp4,
	str_tmp5,
	str_tmp6,
	str_tmp7,
	str_tmp8,
	str_tmp9,
	str_tmp10,
    dt_date,
	dt_date as dt_date2,
	str_category
from

TAB_BOARD

where 
num_oid = "._OID." $sqlp



order by   num_group desc

limit 0, ".$array_listnum[$i]."

";


	// 여기서 5는 게시물수. 타잎별로 다르다면 설정파일에 추가해야 한다.
	$data = $DB->sqlFetchAll($sql);


for($ii=0; $ii<count($data); $ii++) {
	
		if(!$conf[text_len]) $conf[text_len] = "100";
		//if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = 'Re: '.$data[$ii]['str_title'];
		if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = $data[$ii]['str_title'];
		$data[$ii]['str_title_o'] = $data[$ii]['str_title'];
	
		$data[$ii]['str_title1'] = Display::text_cut($data[$ii]['str_title'],"40","..");		
		$data[$ii]['str_title11'] = Display::text_cut($data[$ii]['str_title'],"38","..");		

		$data[$ii]['str_title2'] = Display::text_cut($data[$ii]['str_title'],16,"..");
		$data[$ii]['str_title3'] = Display::text_cut($data[$ii]['str_title'],$len3,"..");		


		if(!$ime_text1 ) $ime_text1 = $data[$ii]['str_text'];
		

		if($data[$ii]['str_text1']) $data[$ii]['str_text1'] = str_replace("&nbsp;","",$data[$ii]['str_text']);

		$data[$ii]['str_text1'] = Display::text_cut(strip_tags($data[$ii]['str_text']),$len_text,"");
		

		$data[$ii]['link'] = 'board/'.$data[$ii]['num_mcode'].'/'.$data[$ii]['num_serial'];
		$data[$ii]['dt_date'] = date("Y-m-d",$data[$ii]['dt_date']);
		$a = explode("-",$data[$ii]['dt_date']);
	
		$data[$ii]['dt_date1']= $a[0];
		
		$data[$ii]['dt_date2']= $a[1];
		$data[$ii]['dt_date3']= $a[2];


		
        $data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < (86400*7);

if($array_type[$i] !="recentBoard"){
  
		$FH = &WebApp::singleton('FileHost');
        $FH->set_code('menu',$data[$ii]['num_mcode']);
        
		
			if ($data[$ii]['str_thumb']) $data[$ii]['thumb_url']= $FH->get_thumb_url($data[$ii]['str_thumb']);
			

			if(!is_file(_DOC_ROOT."/".$data[$ii]['thumb_url'])){

				if( $data[$ii]['str_text']) $s = $data[$ii]['str_text']; 
				$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
				$tmp_img_list = $m[1];
		
				$data[$ii]['thumb_url'] = $tmp_img_list[0];
			
				$data[$ii]['thumb_url'] = str_replace("%FILE_HOST%",$_SERVER[HTTP_HOST],$data[$ii]['thumb_url']);
				$data[$ii]['thumb_url'] = str_replace("http://".$_SERVER[HTTP_HOST],"",$data[$ii]['thumb_url']);
				$data[$ii]['thumb_url'] = trim($data[$ii]['thumb_url']);	
				if(!is_file( _DOC_ROOT.$data[$ii]['thumb_url']."_100")){
				//$FH->GDImageResize(_DOC_ROOT.$data[$ii]['thumb_url'] , _DOC_ROOT.$data[$ii]['thumb_url']."_100" , "100", "75");
				}
				$data[$ii]['thumb_url'] = $data[$ii]['thumb_url']."_100";

			}
			


			if(!is_file(_DOC_ROOT."/".$data[$ii]['thumb_url'])){
			$sql = "select str_refile  from tab_files where num_oid = "._OID." and str_sect = 'menu' and str_code = '".$array_bbs_code[$i]."'
			and num_main ='".$data[$ii]['num_serial']."' and str_ftype in ('jpg','gif','png')";
			$tmpSubimg = $DB -> sqlFetchOne($sql);
			$data[$ii]['thumb_url']= $FH->get_thumb_url($tmpSubimg);

			
				if(!is_file( _DOC_ROOT.$data[$ii]['thumb_url'])){
			
				$FH->GDImageResize(_DOC_ROOT.$data[$ii]['thumb_url'] , _DOC_ROOT.$data[$ii]['thumb_url'] , "100", "75");
				}
			

			}
		
		
		if(!is_file(_DOC_ROOT."/".$data[$ii]['thumb_url'])){
			//$data[$ii]['thumb_url'] = "/image/noimg.gif";
			$data[$ii]['thumb_url'] = "/image/noimg.gif";
		}

		$normal_gallery=GetImageSize(_DOC_ROOT.$data[$ii]['thumb_url'] ); 
		
		//$data[$ii]['thumb_url'] =  str_replace("//","/",$data[$ii]['thumb_url']);
		//echo $data[$ii]['thumb_url']."<br><br>";
		
		$bbs_width = $conf[img_w];
		$bbs_height = $conf[img_h];
				
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
					

		$data[$ii][img_w] = $img_w;
		$data[$ii][img_h] = $img_h;
		}
}

		$tdate[$i][tab_data] = $data;
		$tdate[$i][max_data] = count($data);
		
		$tdate[$i][tab_title] = $array_bbs_title[$i];
		
		if($mou_name=="new_bbs"){
			$tdate[$i][tab_code] = $data[0]['num_mcode'] ;
		}else{
			$tdate[$i][tab_code] = $array_bbs_code[$i];
		}
		$tdate[$i][tab_type] = $array_type[$i];



	}
				
}





$tpl->assign('LIST_lsat',$tdate);
$tpl->assign(array('total_bbs'=>$i,'mou_name'=>$mou_name));
$make = "y";
} else {
    $content =  file_get_contents($cache_file);
}

?>
