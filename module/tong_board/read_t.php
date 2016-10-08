<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: read.php
* 설  명: 게시판 글 읽기
* 날  짜: 2008-06-24
* 작성자: 김종태
*****************************************************************
* 
*/
$r_url = "http://".HOST."/".$act."?".$_SERVER[REDIRECT_QUERY_STRING];
$tpl->assign(array('URL'=>$r_url));



$PERM->apply('menu',$mcode,'r');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);

//echo "ARTICLE_TABLE:$ARTICLE_TABLE";exit;
print_r($_SESSION);


$sql = "
	SELECT
		num_mcode AS mcode, num_serial AS serial, num_notice, num_group, str_user, str_name AS name, str_email AS email, str_title, str_text1, str_text2, str_text3, str_text4, str_text5, str_text6, str_text7, str_text8, str_text9, str_text10,
		chr_html AS use_html, TO_CHAR(dt_date,'YYYY-MM-DD') AS reg_date, num_hit AS hit, num_file, str_ip AS remote_addr, num_comment, str_hak, num_input_pass,str_main,str_category,num_rank,str_pass, str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick
	FROM
		$ARTICLE_TABLE
	WHERE
		num_oid={$oid} AND num_mcode={$mcode} AND num_serial={$id}
";




$data = $DB->sqlFetch($sql);

//2008-08-25 종태 회원정본
if($data[str_user]){

$sql = "select 
STR_NAME, 
STR_ID,
NUM_LOGIN_POINT, 
NUM_BOARD_POINT, 
NUM_COMMINT_POINT, 
NUM_REPALY_POINT,CHR_MTYPE from TAB_MEMBER where num_oid = '$_OID' and str_id = '".$data[str_user]."' ";

$member_data = $DB -> sqlFetch($sql);

if(is_file(_DOC_ROOT."/hosts/".HOST."/files/member/".$data[str_user].".gif")) {
	$member_data[mem_img] = "/hosts/".HOST."/files/member/".$data[str_user].".gif_100";
}


$tpl->assign($member_data);


}


//2008-06-25 비밀글 관련 체크부분
if(!$_SESSION['ADMIN']) {
if($user != $data['str_user']) {
	if($data['num_input_pass']) {

		if($data['str_pass'] != $_SESSION['bbs_pass']) {

		echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.pass?mcode=$mcode&id=$id'\">";
		exit;
		}

}
}
}

@_format_data(&$data);

$data['content'] = $FH->set_content($data['content']);

$DB->query("
    UPDATE
        $ARTICLE_TABLE
    SET
        num_hit=num_hit+1
    WHERE
        num_oid=$oid AND num_mcode=$mcode AND num_serial=$id
");


$DB->commit();

if ($data['use_html'] == 'N') html2txt($data['content']);
if ($data['str_email']) $data['name'] = "<a href='mailto:$data[str_email]'>".$data['name']."</a>";


$listalllink = $URL->alterVar(array(key=>'',search=>''));
$env['listall'] = ($_GET['search'] != '');

// {{{ 이전글,다음글 (2004-08-25)
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";


$sql = "
    SELECT
        /*+ INDEX ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
        num_serial,str_title,num_notice,str_category,num_input_pass
    FROM
        $ARTICLE_TABLE
    WHERE
        num_oid={$oid} AND
        num_mcode={$mcode} AND
        ((num_notice>=".$data['num_notice']." AND
        num_group>".$data['num_group'].") OR
        num_notice>".$data['num_notice'].") AND
        rownum=1 {$whereadd}
";



if($next_data = $DB->sqlFetch($sql)) {
	

if($next_data[num_input_pass]) {


	
$nextlink = "<img src = '/html/secret.gif'> <a href='".$URL->setVar(array('act'=>'.read','id'=>$next_data['num_serial']))."'".
                ($next_data['num_notice'] ? ' style="font-weight:bold;">[공지] ' : '>')."<b>[".$next_data['str_category']."]</b>&nbsp;".$next_data['str_title']."</a>";
}else{


	$nextlink = "<a href='".$URL->setVar(array('act'=>'.read','id'=>$next_data['num_serial']))."'".
                ($next_data['num_notice'] ? ' style="font-weight:bold;">[공지] ' : '>')."<b>[".$next_data['str_category']."]</b>&nbsp;".$next_data['str_title']."</a>";
}
} else {
	$nextlink = "<font color='#AAAAAA'>다음글이 없습니다.</font>";
}



$sql = "
    SELECT
        /*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
        num_serial,str_title,num_notice,str_category,num_input_pass
    FROM
        $ARTICLE_TABLE
    WHERE
        num_oid={$oid} AND
        num_mcode={$mcode} AND
        ((num_notice<=".$data['num_notice']." AND
        num_group<".$data['num_group'].") OR 
        num_notice<".$data['num_notice'].") AND
        rownum=1 {$whereadd}
";





if($prev_data = $DB->sqlFetch($sql)) {
if($prev_data[num_input_pass]) {


	$prevlink = "<img src = '/html/secret.gif'> <a href='".$URL->setVar(array('act'=>'.read','id'=>$prev_data['num_serial']))."'".
                ($prev_data['num_notice'] ? ' style="font-weight:bold;">[공지] ' : '>')."<b>[".$prev_data['str_category']."]</b>&nbsp;".$prev_data['str_title']."</a>";

}else{
	
	$prevlink = "<a href='".$URL->setVar(array('act'=>'.read','id'=>$prev_data['num_serial']))."'".
                ($prev_data['num_notice'] ? ' style="font-weight:bold;">[공지] ' : '>')."<b>[".$prev_data['str_category']."]</b>&nbsp;".$prev_data['str_title']."</a>";

}
} else {
	$prevlink = "<font color='#AAAAAA'>이전글이 없습니다.</font>";
}
// }}}



	//	echo "있다";
	$FH = &WebApp::singleton('FileHost','menu',$mcode);
	$files = $FH->get_files_info($id);
	$total_size = array_pop($files);
	$tpl->assign("FILE",&$files);
	
	$tpl->assign(array('FILE_COUNT'=>count($files)));
	
	
//print_r($files);

    // 겔러리 미리보기
  
        $content_front = '';
        foreach($files as $file) {
            if(!ereg('(jpe?g|gif|png|swf)',$file['str_ftype'])) continue;
           
if($file['str_ftype'] =="swf") {
	

$content_front = "

<embed menu='true' width='100%' loop='true' play='true'  src='".$file['file_url']."'></embed>
";


}else{
			
			//2007-10-27 종태 겔리러 사진이미지 비율 맞추기

			$f_img =  $file['file_url'];

$normal_gallery=GetImageSize($f_img);


$bbs_width = 250;
$bbs_height = 250;
		
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
			
		
			
		

			
			$content_front1 .= '<center><a href="'.$file['file_url'].'?nocount=1'.'"  rel="lightbox1">'.
                              '<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
                              'width ='.$img_w.' height = '.$img_h.'" vspace="5" ></a></center><br>';









$bbs_width2 = 600;
$bbs_height2 = 600;
		
$ratio1 = $bbs_width2/$normal_gallery[0]; // 게시판 가로크기에 대한 이미지 가로 비율 계산 
$ratio2 = $bbs_height2/$normal_gallery[1]; // 게시판 세로크기에 대한 이미지 세로 비율 계산 

if($ratio1 >= 1 && $ratio2 >= 1 )
{
  $img_w2 = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력 
  $img_h2 = $normal_gallery[1]; 
}
elseif($ratio1 > $ratio2)
{
   $img_w2 = $normal_gallery[0]*$ratio2; // 포스터의 가로와 세로에 동일한 비율 적용
   $img_h2 = $normal_gallery[1]*$ratio2; // 높이 넓이 비율 적용 
}
  elseif($ratio1 <= $ratio2)
{
   $img_w2 = $normal_gallery[0]*$ratio1; // 포스터의 가로와 세로에 동일한 비율 적용
   $img_h2 = $normal_gallery[1]*$ratio1; // 높이 넓이 비율 적용 
}
  else
{
  $img_w2 = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력 
  $img_h2 = $normal_gallery[1]; 
}
			
		
			

			$content_front2 .= '<center><a href="'.$file['file_url'].'?nocount=1'.'"  rel="lightbox1">'.
                              '<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
                              'width ='.$img_w2.' height = '.$img_h2.'"  vspace="5" ></a></center><br>';


			
}
        }
        
$tpl->assign(array('img_list'=>$content_front1,'img_list2'=>$content_front2));
    
    
if(strstr($content_front2,"/data/hosts/")) {
$data[content] = $content_front2.$data[content];
}



// {{{ 나도한마디
if ($env['use_comment']) {
	if ($data['num_comment'] > 0) {
	

		
		$sql = "SELECT 
		
					num_main, num_serial, str_user, str_name , str_comment, TO_CHAR(dt_date,'YYYY-MM-DD HH24:MI:SS') dt_date,
					str_icon,str_nick,chr_mtype
				FROM
					$COMMENT_TABLE
				WHERE
					num_oid=$oid AND num_mcode=$mcode AND num_main=$id order by num_serial asc
			";
	
		
		$comments = $DB->sqlFetchAll($sql);
		@array_walk($comments,'_format_data');
		$tpl->assign("COMMENT",&$comments);
	}
	$env['comment_write'] = true;//$PERM->check('w');
}
// }}}
$env['show_ip'] = !$env['admin'];




$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/read.htm"));



$tpl->assign(array(
	'id'=>$id,
	'env'=>$env,
	'prevlink'=>$prevlink,
	'nextlink'=>$nextlink,
	'gon' => $gon,
));

$tpl->assign($data);



 include dirname(__FILE__).'/inc_list.php';



// {{{ Functions
function html2txt(&$str) {
	$str = str_replace(array("&","<",">","\n"),array("&amp;","&lt;","&gt;"," <br>\n"),$str);
}

function _format_data(&$arr) {
    $URL = &WebApp::singleton('WebAppURL');
	$arr['name'] = &$arr['name'];
	
	if($arr['num_mcode'] >= 900000) {
		$arr['title'] = strip_tags(&$arr['title']);		
	}else{
		$arr['title'] = "<b>[".$arr['str_category']."]</b>&nbsp;".strip_tags(&$arr['title']);
	}

	
	$arr['content'] = $arr['str_text1'].$arr['str_text2'].$arr['str_text3'].$arr['str_text4'].$arr['str_text5'].$arr['str_text6'].$arr['str_text7'].$arr['str_text8'].$arr['str_text9'].$arr['str_text10'];
    $arr['del_link'] = $URL->getVar(array(
        'act' => '.del_comment',
		'main'=>$arr['num_main'],
        'id' => $arr['num_serial']
    ));
}

function allow_tags(&$str,$allow="b|i|font") {	//특정 태그만 허용
	if (is_array($allow)) $allow = implode("|",$allow);
	$str = preg_replace("/<(\/?)(?!\/|$allow)([^<>]*)?>/i", "&lt;\\1\\2&gt;", $str);
	return $str;
}
// }}}
?>
