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
if(_OID == 20252 && $mcode == 18)  {
echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.list_all?mcode=$mcode'\">";
exit;	
}
$PERM->apply('menu',$mcode,'l');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);


$caption_file = "hosts/$HOST/contents/$mcode.board.caption.htm";
if(is_file($caption_file)) $CAPTION = str_replace("\n","<br>\n",file_get_contents($caption_file));

$listnum = $_conf[num_listnum];
if(!$listnum)$listnum = 15;

$navmum = $_conf['num_navnum'];
if($navmum) $navmum = 10;

$titlelen = $_conf[num_titlelen];

$colors = $_conf['colors'];
$dateformat = "Y-m-d";

$key = $_REQUEST['key'];
$search = trim($_REQUEST['search']);
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";



if ($str_category) $whereadd .= "AND str_category = '$str_category'";
$tpl->assign(array('str_category'=>$str_category));

$sql = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid= ".$_OID." and  num_mcode=$mcode and num_notice = '0' $whereadd";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$page = $_REQUEST['page'];
if (!$page) $page = 1;


$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;


//2008-06-24 종태 카테고리 목록

$sql = "select  str_category from TAB_BOARD_CATEGORY 
where 

num_oid = $_OID  and 

num_mcode = $mcode  

";
$row = $DB -> sqlFetchAll($sql);
for($ii=0; $ii<count($row); $ii++) {
	$sql = "select count(*) from TAB_BOARD_BAK where num_oid = $_OID and num_mcode=$mcode and str_category = '".$row[$ii][str_category]."' ";
	$row[$ii][counter] = $DB -> sqlFetchOne($sql);
}

$tpl->assign(array('cate_LIST'=>$row));


$glen = strlen($group);
$glen_max = $glen -1;
$group =  substr($group, 0,$glen_max);

$tpl->assign(array('GROUP'=>$group));


$sql = "
SELECT
*
FROM
(SELECT

num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text1,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,str_category, str_thumb,num_rank, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov, str_view
FROM
TAB_BOARD_BAK
WHERE
num_oid=$oid AND num_mcode=$mcode  AND  num_notice=0     $whereadd order by DT_DATE DESC
)
WHERE
rnum > $seek  AND rnum <= $offset

";



$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');


$sql2 = "
SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text1,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND  num_notice=1  and num_mcode=$mcode    $whereadd $ddrder

";

//echo $sql2;

$data222 = $DB->sqlFetchAll($sql2);
@array_walk($data222,'cb_format_list');




//2008-02-26 종태 전체공지사항

//$_mcode = substr($mcode,0,2);

$sql = "
SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text1,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,str_category, str_thumb, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND num_notice=2   $whereadd $ddrder


";

//echo $sql;

$data_gong = $DB->sqlFetchAll($sql);
@array_walk($data_gong,'cb_format_list');





$URL->delVar('id','num');


$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/list.htm"));


//카테고리링크
$cate_link = "board.admin.categorypop";


$tpl->assign(array(
'LIST'=>$data,
'LIST_g'=>$data222,
'LIST2'=>$data2,
'LIST_gong'=>$data_gong,
'env'=>$env,
'mcode'=>$mcode,
'listnum'=>$listnum,
'total'=>$total,
'page'=>$page,
'key'=>$key,
'search'=>$search,
'cate_link'=>$cate_link,
));

//==-- Functions --==//
function cut_str($str,$len,$tail="..") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
			$str=substr($str,0,$i).$tail;
	}
	return $str;
}

$nnum = 0;
function cb_format_list(&$arr,$key,$param) {
	global $oid,$total,$seek,$listnum, $titlelen, $colors,$dataformat,$search,$search,$URL,$FH, $nnum, $DB, $_OID,$mcode;
	static $num;
	$nnum++;
	$arr['nnum'] = $nnum;
	$arr['num'] = $total - $seek - $num;

	if(!$arr['str_category']) $arr['str_category'] = "일반";

	if(!$arr['num_notice']) {
		$arr['title'] = "<b>[".$arr['str_category']."]</b>&nbsp;".cut_str($arr['str_title'], $titlelen);
		$arr['title2'] = "<b>[".$arr['str_category']."]</b>&nbsp;".cut_str($arr['str_title'], $titlelen);
	}
	else{
		$arr['title'] = cut_str($arr['str_title'], $titlelen);
		$arr['title2'] = cut_str($arr['str_title'], $titlelen);

	}

	$arr['title'] = cut_str($arr['str_title'], $titlelen);
	$arr['title2'] = cut_str($arr['str_title'], $titlelen);


/*if($arr['num_rank']) {
$arr['title'] = $arr['title']." <img src = '/image/rebtn.gif' align=absmiddle> <font style= 'color:#993333;font-size:11px'>(".$arr['num_rank'].")</font>";
$arr['title2'] = $arr['title2']." <img src = '/image/rebtn.gif'> <font style= 'color:#993333;font-size:11px'>(".$arr['num_rank'].")</font>";
	}*/

	$arr['str_text'] =  strip_tags($arr['str_text1']);
	$arr['str_text'] = cut_str($arr['str_text'], 100);


	$sql = "select str_nick,str_name from TAB_MEMBER where num_oid = "._OID." and str_id = '".$arr[str_tmp3]."' ";
	$row = $DB -> sqlFetch($sql);

	$arr[name2] = $row[str_name];
	$arr[str_nick2] = $row[str_nick];


/*
2008-05-06 종태
파일목록을 가져올꺼에여~
	*/

/*	$sql = "select str_ftype  from tab_files where num_oid = '$_OID' and str_sect = 'menu' and str_code = '".$mcode."'
and num_main ='".$arr['num_serial']."'";
$arr[ftype] = $DB -> sqlFetchOne($sql);

if ($arr['num_file'] > 0) {

$FH = &WebApp::singleton('FileHost','menu',$mcode);
$files = $FH->get_files_info($arr['num_serial']);
$total_size = array_pop($files);
$arr[file_list] = $files;
//print_r($files);
}
	*/


	if(!$arr['thumb_url']) {

		$files = $FH->get_files_info($arr['num_serial']);
		$total_size = array_pop($files);
		$arr[file_list] = $files;
		//print_r($arr[file_list]);
		for($ii=0; $ii<count($arr[file_list]); $ii++) {

			if($arr[file_list][$ii][str_ftype] == "jpg" || $arr[file_list][$ii][str_ftype] == "gif" ||$arr[file_list][$ii][str_ftype] == "JPG"  ) {
				$arr['thumb_url'] = $arr[file_list][$ii][real_url];
			}

		}



	}



	$arr['is_recent'] = date('U') - strtotime($arr['dt_date']) < 241920;



	if ($arr['str_thumb'] && !strstr($arr['str_thumb'],"/data/hosts/")) {
		$arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);
	}



	if(strstr($arr['str_thumb'],"_100")) $arr['thumb_url']= $arr['str_thumb'];

		if(!$arr['thumb_url']){
			
		$tmp_text = explode("<IMG",$arr['str_text1']);
		$tmp_text = explode(">",$tmp_text[1]);	

		$tmp_text = explode('src="',$tmp_text[0]);
		$tmp_text = explode('"',$tmp_text[1]);

		$arr['thumb_url'] = $tmp_text[0];
		$arr['thumb_url'] = str_replace("%FILE_HOST%","isch_file.hkedu2.co.kr/",$arr['thumb_url']);
		$arr['thumb_url'] = str_replace("http://".$_SERVER[HTTP_HOST],"",$arr['thumb_url']);
		$arr['thumb_url'] = trim($arr['thumb_url']);

		}



	



	$f_img =   $arr['thumb_url'];
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


	$arr[img_w] = $img_w;
	$arr[img_h] = $img_h;

	if(!$arr[img_w]) {
		$arr[img_w] = "100";
	}
	if(!$arr[img_h]) {
		$arr[img_h] = "100";
	}




	if ($arr['num_comment'] > 0) $arr['cmt'] = $arr['num_comment'];
	else $arr['cmt'] = '';
	// 첨부파일이 있을경우 리스트에서 표현해줘야 할 경우에대한 처신
	if ($arr['num_file'] > 0) $arr['file'] = '파일있음';
	$arr['bgcolor'] = ($num % 2) ? $colors['even'] : $colors['odd'];
	$arr['indent'] = str_repeat("　",$arr['num_depth']);
	$arr['date'] = &$arr['dt_date'];
	$arr['hit'] = $arr['num_hit'];
	if ($arr['email']) {
		$arr['name'] = "<a href='mailto:".$arr['str_email']."'>".$arr['str_name']."</a>";
	}
	else {
		$arr['name'] = $arr['str_name'];
	}

	$arr['readlink'] = $URL->setVar(
	array(
	'act' => '.read',
	'id'  => $arr['num_serial'],
	'num' => $arr['num']
	)
	);
	$num++;
	if ($search) $arr['title'] = str_replace($search,'<font color="red">'.$search.'</font>',$arr['title']);
}



function callMovImg($id){
	global $DB;
	$sql = "select

	STR_IMAGE_NAME,
	STR_IMAGE_PATH

	from EZFLV.TB_CONTENT where STR_CONTENT_ID='$id'";

	$img_data = $DB -> sqlFetch($sql);

	$r_url = "http://121.78.86.50/upload/file";
	$return_data  = $r_url.$img_data['str_image_path'].$img_data['str_image_name'];

	return $return_data;
}

?>
