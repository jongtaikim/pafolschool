<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2008-06-09
* 작성자: 김종태
* 설  명: 게시판 목록보기
*****************************************************************
*
*/
if(!function_exists('cut_str')) {
function cut_str($str,$len,$tail="..") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
			$str=substr($str,0,$i).$tail;
	}
	return $str;
}
}



$mcode = $param['code'];
if($param['listnum']) $listnum = $param['listnum'];
else $listnum = 5;

if($param['titlelen']) $titlelen = $param['titlelen'];
else $titlelen = 30;

$tpl = &WebApp::singleton('Display');
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');

$FH = WebApp::singleton('FileHost','menu',$mcode);
$FH->sect = "menu";
$FH->set_oid(_OID);

if($param[oid] == "no") {
$psqlc = "";	
}else if($param[oid] == "admin") {
$psqlc = " num_oid="._AOID." AND ";
}else{
$psqlc = " num_oid="._OID." AND ";
}


$sql = "select str_title from TAB_MENU where $psqlc  num_mcode =  $mcode";
//echo $sql;
$title = $DB -> sqlFetchOne($sql);
$tpl->assign(array('B_title'=>$title));



$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (


SELECT

		num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_thumb, 
		str_title, str_text1, num_comment, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date2, dt_date,str_tmp1 ,str_tmp2,str_tmp3,str_tmp4,str_tmp5,str_tmp6,str_tmp7,str_tmp8,str_tmp9,str_tmp10,str_nick
	FROM TAB_BOARD
	WHERE $psqlc num_mcode=$mcode  AND num_notice=0
	order by dt_date desc


)b)a
                where a.RNUM >=  0 and a.RNUM <= $listnum ";

//echo $sql;

$data = $DB->sqlFetchAll($sql);

for($a=0 ; $a<sizeof($data) ; $a++){

	$data[$a]['title'] = cut_str($data[$a]['str_title'], $titlelen);
	$data[$a]['str_text1'] = cut_str(strip_tags($data[$a]['str_text1']),200);
	$data[$a]['is_recent'] = date('U') - strtotime($data[$a]['dt_date2']) < 241920;
	$data[$a]['dt_date'] = $data[$a]['dt_date2'];

	if ($data[$a]['num_comment'] > 0) $data[$a]['cmt'] = $data[$a]['num_comment'];
	else $data[$a]['cmt'] = '';

	$data[$a]['readlink'] = "/board.read?mcode=".$mcode."&id=".$data[$a]['num_serial']."&num=".$data[$a]['num_serial'];

	if(!$data[$a]['thumb_url']) {
		$files = $FH->get_files_info($data[$a]['num_serial']);
		$total_size = array_pop($files);
		$data[$a]['file_list'] = $files;
		for($ii=0; $ii<count($data[$a]['file_list']); $ii++) {
			if($data[$a][file_list][$ii][str_ftype] == "jpg" || $data[$a][file_list][$ii][str_ftype] == "gif" ||$data[$a][file_list][$ii][str_ftype] == "JPG"  ) {
				$data[$a]['thumb_url'] = $data[$a][file_list][$ii][real_url];
			}
		}
	}

	if ($data[$a]['str_thumb']) $data[$a]['thumb_url']= $FH->get_thumb_url($data[$a]['str_thumb']);
	if(strstr($data[$a]['str_thumb'],"_100")) $data[$a]['thumb_url']= $data[$a]['str_thumb'];

	if(!$data[$a]['thumb_url']){
		$tmp_text = explode("<IMG",$data[$a]['str_text1']);
		$tmp_text = explode(">",$tmp_text[1]);

		$tmp_text = explode('src="',$tmp_text[0]);
		$tmp_text = explode('"',$tmp_text[1]);

		$data[$a]['thumb_url'] = $tmp_text[0];
		$data[$a]['thumb_url'] = str_replace("%FILE_HOST%","isch_file.hkedu2.co.kr/",$data[$a]['thumb_url']);
		$data[$a]['thumb_url'] = str_replace("http://".$_SERVER[HTTP_HOST],"",$data[$a]['thumb_url']);
		$data[$a]['thumb_url'] = trim($data[$a]['thumb_url']);
	}

	$f_img =   $data[$a]['thumb_url'];
	$normal_gallery=GetImageSize(_DOC_ROOT.$f_img);

	$bbs_width = 100;
	$bbs_height = 100;

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


	$data[$a][img_w] = $img_w;
	$data[$a][img_h] = $img_h;

	if(!$data[$a][img_w]) {
		$data[$a][img_w] = "100";
	}
	if(!$data[$a][img_h]) {
		$data[$a][img_h] = "100";
	}
}
//if($mcode == '112013') print_r($data);
$tpl->assign(array(
'LIST'=>$data,
'mcodes' => $mcode,
));
 
$template = $param['template'];
$tpl->define('BoadlistWA_'.$mcode,$template);
$content = $tpl->fetch("BoadlistWA_".$mcode);

$FH->close();

echo $content;

//==-- Functions --==//

//<wa:applet module="board.list_wa" code="2110" listnum="5" titlelen="20"></wa:applet>
?>
