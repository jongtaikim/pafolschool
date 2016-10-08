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
$search = $_REQUEST['search'];
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


$sql = "select  str_category from TAB_BOARD_CATEGORY where num_oid = $_OID  and num_mcode = $mcode";

$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {
	$sql = "select count(*) from TAB_BOARD where num_oid = $_OID and num_mcode=$mcode and str_category = '".$row[$ii][str_category]."' ";
	$row[$ii][counter] = $DB -> sqlFetchOne($sql);

}


$tpl->assign(array('cate_LIST'=>$row));

$glen = strlen($group);
$glen_max = $glen -1;
$group =  substr($group, 0,$glen_max);

$tpl->assign(array('GROUP'=>$group));


if($_conf[chr_listtype] =="D" ){
	if($_SESSION[ADMIN]  || $_SESSION[ADMIN_sub]){
	$listPsql = "";
	}else{
	$listPsql = "and str_view = 'Y'";
	}
}


$sql = "
SELECT
*
FROM
(SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,str_category, str_thumb,num_rank, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov, str_view
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND num_mcode=$mcode  AND  num_notice=0  $listPsql    $whereadd $ddrder
)
WHERE
rnum > $seek  AND rnum <= $offset

";
$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');

$sql2 = "
SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov,str_category
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND  num_notice=1  and num_mcode=$mcode    $whereadd $ddrder
";
$data222 = $DB->sqlFetchAll($sql2);
@array_walk($data222,'cb_format_list');

//2008-02-26 종태 전체공지사항

//$_mcode = substr($mcode,0,2);


$sql = "
SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,str_category, str_thumb, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND num_notice=2  $whereadd $ddrder 
";
$data_gong = $DB->sqlFetchAll($sql);
@array_walk($data_gong,'cb_format_list');

$URL->delVar('id','num');



$tpl->define("CONTENT", WebApp::getTemplate("tong_board/skin/A_board/list.htm"));


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
'search'=>$search
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
	global $oid,$total,$seek,$listnum, $titlelen, $colors,$dataformat,$search,$search,$URL,$FH, $nnum, $DB, $_OID,$mcode,$_conf;
	static $num;
	$nnum++;
	

	if(strtotime($arr['dt_date']) > 1236058040) $arr['str_nick'] = $arr['str_name'];

	$arr['str_title'] = strip_tags($arr['str_title']);

	$arr['nnum'] = $nnum;
	$arr['num'] = $total - $seek - $num;

	if($arr['str_category']) {
	$len =42;
	}else{
	$len =44;
	}

	if($arr['num_notice']>0) {
	$len =36;
	}
	

	$arr['title'] = cut_str($arr['str_title'], $len);
	$arr['title2'] = cut_str($arr['str_title'], 18);

/*
	if($arr['str_category']) {
	$arr['title']= "[".$arr['str_category']."] ".$arr['title'];
	}else{
	$arr['title']= "[일반] ".$arr['title'];
	}
*/
	/*if($arr['num_rank']) {
	$arr['title'] = $arr['title']." <img src = '/image/rebtn.gif' align=absmiddle> <font style= 'color:#993333;font-size:11px'>(".$arr['num_rank'].")</font>";
	$arr['title2'] = $arr['title2']." <img src = '/image/rebtn.gif'> <font style= 'color:#993333;font-size:11px'>(".$arr['num_rank'].")</font>";
	}*/

	

	/*
	2008-05-06 종태
	파일목록을 가져올꺼에여~
	*/
	$sql = "select str_ftype  from tab_files where num_oid = '$_OID' and str_sect = 'menu' and str_code = '".$mcode."'
	and num_main ='".$arr['num_serial']."'";
	$arr[str_ftype] = $DB -> sqlFetchOne($sql);

	

	$arr['is_recent'] = date('U') - strtotime($arr['dt_date']) < 241920;

	if ($arr['str_thumb']) $arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);
	if(!$arr['thumb_url']){

		$s = $arr['str_text']; 
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		$arr['thumb_url'] = $tmp_img_list[0];
		$arr['thumb_url'] = str_replace("%FILE_HOST%",$FH->host,$arr['thumb_url']);
		$arr['thumb_url'] = str_replace("http://".$_SERVER[HTTP_HOST],"",$arr['thumb_url']);
		$arr['thumb_url'] = trim($arr['thumb_url']);	
	}
	


	$normal_gallery=GetImageSize(_DOC_ROOT."/".$arr['thumb_url']); 

	
	$bbs_width = 100;
	$bbs_height = 75;

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



	if ($arr['num_comment'] > 0) $arr['cmt'] = $arr['num_comment'];
	else $arr['cmt'] = '';

	// 첨부파일이 있을경우 리스트에서 표현해줘야 할 경우에대한 처신
	if ($arr['num_file'] > 0) $arr['file'] = '파일있음';
	$arr['bgcolor'] = ($num % 2) ? $colors['even'] : $colors['odd'];
	$arr['indent'] = str_repeat("　",$arr['num_depth']);
	$arr['date'] = $arr['dt_date'];
	$arr['hit'] = $arr['num_hit'];
	if ($arr['email']) {
		$arr['name'] = "<a href='mailto:".$arr['str_email']."'>".$arr['str_name']."</a>";
	}else {
		$arr['name'] = $arr['str_name'];
	}
	


	
	
	$arr['str_text'] =  str_replace("&nbsp;","",$arr['str_text']->load());;
	$arr['str_text'] =  strip_tags($arr['str_text']);
	$arr['str_text'] = cut_str($arr['str_text'], 300);



	$arr['readlink'] = $URL->setVar(array(
	'act' => '.read',
	'id'  => $arr['num_serial'],
	'num' => $arr['num']
	));

	$num++;
	if ($search) $arr['title'] = str_replace($search,'<font color="red">'.$search.'</font>',$arr['title']);


}

?>
