<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2008-06-09
* 작성자: 김종태
* 설  명: 게시판 RSS
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);


//==-- Functions --==//
function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}

$nnum = 0;
function cb_format_list(&$arr,$key,$param,$FH,$mcode) {
	global $oid,$total,$seek,$listnum, $titlelen, $colors,$dataformat,$search,$search,$URL,$FH, $nnum, $DB, $_OID,$mcode;
	static $num;
	$nnum++;
	$arr['nnum'] = $nnum;
	$arr['num'] = $total - $seek - $num;

	if($arr['str_text']) $arr['str_text'] =$arr['str_text']->load();

	if(!$arr['str_category']) $arr['str_category'] = "일반";

	if(!$arr['num_notice']) {
	$arr['title'] = "<b>[".$arr['str_category']."]</b>&nbsp;".cut_str($arr['str_title'], 50);
	$arr['title2'] = "<b>[".$arr['str_category']."]</b>&nbsp;".cut_str($arr['str_title'], 12);
	}else{
	$arr['title'] = cut_str($arr['str_title'], 50);
	$arr['title2'] = cut_str($arr['str_title'], 12);
	
	}


	$sql = "select str_ftype  from tab_files where num_oid = '$_OID' and str_sect = 'menu' and str_code = '".$mcode."' 
		and num_main ='".$arr['num_serial']."'";
	$arr[ftype] = $DB -> sqlFetchOne($sql);

if ($arr['num_file'] > 0) {

	$FH = &WebApp::singleton('FileHost','menu',$mcode);
	$files = $FH->get_files_info($arr['num_serial']);
	$total_size = array_pop($files);
	$arr[file_list] = $files;
	//print_r($files);
}
    

$arr['is_recent'] = date('U') - strtotime($arr['dt_date']) < 241920;

	if ($arr['str_thumb']) $arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);

	if(strstr($arr['str_thumb'],"_100")) {
		$arr['thumb_url']= $arr['str_thumb'];
	}


		$f_img =   $arr['thumb_url'];

$normal_gallery=GetImageSize($f_img);


$bbs_width = 80;
$bbs_height = 60;
		
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
		

 
$arr['content'] = $FH->set_content($arr['str_text']);		

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
	} else {
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
	
}


header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");



//RSS용 제목구하기 2008-08-22종태
$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '$mcode'";
$board_title = $DB -> sqlFetchOne($sql);
$tpl->assign(array(
'board_title'=>$board_title,
'HOST_NAME' =>_ONAME,
'HOST' =>HOST,
));




$listnum = 15;

$total = $DB->sqlFetchOne("SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_mcode=$mcode and str_rss = 'Y' $whereadd");
if(!$total) $total = 0;
$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;



$sql = "
	SELECT
		*
	FROM
		(SELECT
			/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
			 num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text, str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,str_category, str_thumb,num_rank, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10
		FROM
			$ARTICLE_TABLE
		WHERE
			num_oid=$oid  AND num_mcode=$mcode   $whereadd $ddrder
		)
	WHERE
		rnum > $seek  AND rnum <= $offset
      
";

//echo $sql;

$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');
$URL->delVar('id','num');


$tpl->setLayout('blank');
$tpl->define("CONTENT", WebApp::getTemplate("board/rss.tpl"));

$tpl->assign(array(
	'LIST'=>$data,
	'env'=>$env,
	'mcode'=>$mcode,
	'listnum'=>$listnum,
	'total'=>$total,
	'page'=>$page,
    'key'=>$key,
    'search'=>$search
));
	
echo "<"."?xml version='1.0' encoding='euc-kr'?".">
";



?>
