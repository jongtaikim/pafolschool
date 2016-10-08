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
$mou_name =  $param['mou_name'];

$conf['title'] = substr($conf['bbs_title'],0,strlen($conf['bbs_title'])-1);
$conf['mcode'] = substr($conf['bbs_code'],0,strlen($conf['bbs_code'])-1);
$tpl->assign($conf);
$tpl->assign($conf_main);


$array_bbs_code = explode(",",$conf['bbs_code']);
$array_bbs_title = explode(",",$conf['bbs_title']);
	
if(!$conf['listnum']) $listnum= "5"; else  $listnum = $conf['listnum'];
if($conf['len'] > 0) $len = $conf['len']; else $len = 28;
if($conf[text_len] > 0) $text_len = $conf[text_len]; else $text_len = 28;

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc.'._LAYOUT_R.'.'.$mou_name.'.htm';




if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {

//if (!is_file($cache_file)) {
	// 선택적으로 최근게시물 가져오도록 수정(2004-08-30)
 
	

$tpl->assign($main_data);


for($i=0; $i<count($array_bbs_code)-1; $i++) {
	



$sql = "


select a.* from (
         select ROWNUM as RNUM, b.* from (

 select 
   str_title,
    str_name,
    num_mcode,
    str_thumb,
	num_depth,
	num_serial,
	num_input_pass,
	num_comment,
	str_text1,
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
    TO_CHAR(dt_date,'YYYY-MM-DD') as dt_date,
	dt_date as dt_date2,
	str_category
from

tab_board

where 
num_oid = "._OID." and
num_mcode = ".$array_bbs_code[$i]."  


order by   num_serial desc


)b)a
                where a.RNUM >= 0 and a.RNUM <= $listnum


";





	// 여기서 5는 게시물수. 타잎별로 다르다면 설정파일에 추가해야 한다.
	$data = $DB->sqlFetchAll($sql);




for($ii=0; $ii<count($data); $ii++) {
	
		if(!$conf[text_len]) $conf[text_len] = "120";
		//if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = 'Re: '.$data[$ii]['str_title'];
		if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = $data[$ii]['str_title'];
		$data[$ii]['str_title'] = Display::text_cut($data[$ii]['str_title'],$len,"..");		



		$ime_text1 = $data[$ii]['str_text1'];

		$data[$ii]['str_text1'] = str_replace("&nbsp;","",$data[$ii]['str_text1']);
		$data[$ii]['str_text2'] = Display::text_cut(strip_tags($data[$ii]['str_text1']),340,"..");		
		$data[$ii]['str_text1'] = Display::text_cut(strip_tags($data[$ii]['str_text1']),$text_len,"..");
		

		$data[$ii]['link'] = 'board.read?mcode='.$data[$ii]['num_mcode'].'&id='.$data[$ii]['num_serial'];
	
		$a = explode("-",$data[$ii]['dt_date']);
	
		$data[$ii]['dt_date1']= $a[0];
		
		$data[$ii]['dt_date2']= $a[1];
		$data[$ii]['dt_date3']= $a[2];


		
        $data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;

        $FH = &WebApp::singleton('FileHost');
        $FH->set_code('menu',$data[$ii]['num_mcode']);
        

		if($data[$ii]['str_file_url1'] || $data[$ii]['str_file_url2'] ) {
		
		if($data[$ii]['str_file_url1']) {
		$normal_gallery=GetImageSize(_DOC_ROOT."/hosts/".$_SERVER[HTTP_HOST]."/".$data[$ii]['str_file_url1']); 
		$data[$ii]['thumb_url'] = "/hosts/".$_SERVER[HTTP_HOST]."/".$data[$ii]['str_file_url1'];
		}

		if($data[$ii]['str_file_url2']) {
		$normal_gallery=GetImageSize(_DOC_ROOT."/hosts/".$_SERVER[HTTP_HOST]."/".$data[$ii]['str_file_url2']); 
		$data[$ii]['thumb_url'] = "/hosts/".$_SERVER[HTTP_HOST]."/".$data[$ii]['str_file_url2'];
		}




		}else{

		if($data[$ii]['str_thumb']){
			
		$data[$ii]['thumb_url'] = $FH->get_thumb_url($data[$ii]['str_thumb']);
		$normal_gallery=GetImageSize("/www1/isch_file/hosts/"._OID."/menu/".$data[$ii]['str_thumb']); 
		
		}else{
       


		$s = $ime_text1;
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		

		$data[$ii]['thumb_url'] = $tmp_img_list[0];
		$data[$ii]['thumb_url'] = str_replace("%FILE_HOST%","isch_file.hkedu2.co.kr/",$data[$ii]['thumb_url']);
		$data[$ii]['thumb_url'] = str_replace("http://".$_SERVER[HTTP_HOST],"",$data[$ii]['thumb_url']);
		$data[$ii]['thumb_url'] = trim($data[$ii]['thumb_url']);

		$normal_gallery=GetImageSize(_DOC_ROOT."/".$data[$ii]['thumb_url']); 






		}
		}

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

		$tdate[$i][tab_data] = $data;
		$tdate[$i][tab_title] = $array_bbs_title[$i];
		$tdate[$i][tab_code] = $array_bbs_code[$i];

				
		}





$tpl->assign('LIST_lsat',$tdate);

$tpl->assign(array('total_bbs'=>$i,'mou_name'=>$mou_name));
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->put_string($content,$cache_file);
} else {

    $content =  file_get_contents($cache_file);
}

?>
