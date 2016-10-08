<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/list.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 게시판 목록보기
*****************************************************************
* 
*/

if($mcode) {
	if(!$_SESSION[CAFE_ADMIN]) $PERMCAFE->apply('party',$pcode.'.'.$mcode,'l',$cafe_mtype);	
}

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid($_OID);

$listnum = 12;
$page = $_REQUEST['page'];
if (!$page) $page = 1;
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "AND a.$key LIKE '%$search%'";
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

if(!$total) $total = 0;

//먼저 갤러리형태의 게시판을 갖고오자
$sql = "select num_mcode from TAB_PARTY_BOARD_CONFIG where num_oid=$_OID and num_pcode=$pcode and str_skin='gallery'";
$row = $DB -> sqlFetchAll($sql);
for($a=0 ; $a<sizeof($row) ; $a++){
	if($row[$a][num_mcode]) $tabmcode[] .= $row[$a][num_mcode];
}
if(sizeof($tabmcode)>0) $tables = implode(",",$tabmcode);

$total = $DB->sqlFetchOne("
		SELECT count(*) FROM $ARTICLE_TABLE
		WHERE
			num_oid=$_OID AND 
			num_pcode=$pcode and 
			num_notice = 0 and 
			num_mcode in (".$tables.")
			$whereadd
");

//전체공지사항
$sql = "
SELECT
	/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
	num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, num_pcode,
	str_title, str_email, num_hit, num_file, num_comment, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb, num_input_pass, rownum AS rnum
FROM
	$ARTICLE_TABLE
WHERE
	num_oid=$_OID AND num_pcode=$pcode  and  num_notice = 2
";
$data2 = $DB->sqlFetchAll($sql);
@array_walk($data2,'cb_format_list');

//게시글
$sql = "
select a.* from (
	select ROWNUM as RNUM, b.* from (

		SELECT
			num_pcode, num_mcode, num_serial, num_notice, str_user, str_name, 
			str_title, num_hit, num_comment, dt_date, TO_CHAR(dt_date,'YYYY-MM-DD HH:II:SS') dt_date2, num_input_pass, str_thumb
			FROM
			$ARTICLE_TABLE
		WHERE
			num_oid=$_OID AND 
			num_pcode=$pcode and 
			num_notice = 0 and 
			num_mcode in (".$tables.")
			$whereadd
		order by dt_date desc

	)b)a
where a.RNUM > $seek AND a.RNUM <= $offset";

$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');

$URL->delVar('id','num');

$tpl->define("CONTENT", "html/party/board/skin/".$board_skin."/list_gallery.htm");

if ($data) $tpl->assign("LIST",&$data);
$tpl->assign(array(
'LIST2'=> $data2,
'listnum' => $listnum,
'mode'=>$mode,
'total'=>$total,
'page'=>$page,
'key'=>$key,
'search'=>$search
));


function cb_format_list(&$arr,$key,$param) {
	global $_OID,$total,$seek,$listnum, $page, $_conf,$search,$URL,$FH, $v, $board_type;
	global $DB, $COMMENT_TABLE, $COMMENT_PRIMARY_INDEX, $COMMENT_TABLE,$board_skin;
	static $num;

	$arr['num'] = $total-($listnum * ($page-1));
	$arr['title'] = cut_str($arr['str_title'], 50);
	$arr['title2'] = cut_str($arr['str_title'], 8);

	
	$arr['dt_date'] = substr($arr['dt_date2'],0,10);
	if ($arr['str_thumb']) $arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);
	

	//2007-10-27 종태 겔리러 사진이미지 비율 맞추기
	if($arr['str_thumb']) $f_img =  _DOC_ROOT."/hosts/".HOST."/".$FH->sect."/".$arr['str_thumb']."_100";
	


	$normal_gallery=GetImageSize($f_img);

	$bbs_width = 110;
	$bbs_height = 110;

	$ratio1 = $bbs_width/$normal_gallery[0]; // 게시판 가로크기에 대한 이미지 가로 비율 계산 
	$ratio2 = $bbs_height/$normal_gallery[1]; // 게시판 세로크기에 대한 이미지 세로 비율 계산 

	if($ratio1 >= 1 && $ratio2 >= 1 ){
		$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력 
		$img_h = $normal_gallery[1]; 
	}elseif($ratio1 > $ratio2){
		$img_w = $normal_gallery[0]*$ratio2; // 포스터의 가로와 세로에 동일한 비율 적용
		$img_h = $normal_gallery[1]*$ratio2; // 높이 넓이 비율 적용 
	}elseif($ratio1 <= $ratio2){
		$img_w = $normal_gallery[0]*$ratio1; // 포스터의 가로와 세로에 동일한 비율 적용
		$img_h = $normal_gallery[1]*$ratio1; // 높이 넓이 비율 적용 
	}else{
		$img_w = $normal_gallery[0]; // 지정된 크기보다 작을경우 원래 싸이즈데로 출력 
		$img_h = $normal_gallery[1]; 
	}

	$arr['img_w'] = $img_w;
	$arr['img_h'] = $img_h;



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

	$arr['is_recent'] = date('U') - strtotime($arr['dt_date']) < 241920;

	$arr['readlink'] = $URL->setVar(
		array(
		'act' => '.read',
		'mcode'  => $arr['num_mcode'],
		'id'  => $arr['num_serial'],
		'num' => $arr['num']
		)
	);
	
	//보드타입 memo인경우 댓글을 보여줘야함.
	if (($arr['num_comment']>0) && ($board_type == 'memo')) {
		$sql = "SELECT /*+ INDEX ($COMMENT_TABLE $COMMENT_PRIMARY_INDEX) */
		num_main, num_serial, str_user, str_name AS name, str_comment, TO_CHAR(dt_date,'YYYY-MM-DD HH24:MI') dt_date
		FROM
		$COMMENT_TABLE
		WHERE
		num_oid=$_OID AND num_pcode=".$arr[num_pcode]." AND num_mcode=".$arr[num_mcode]." AND num_main=".$arr[num_serial]."
		";
		$arr['comment'] = $DB->sqlFetchAll($sql);
	}

	$num++;
	if ($search) $arr['title'] = str_replace($search,'<font color="red">'.$search.'</font>',$arr['title']);
}
?>
