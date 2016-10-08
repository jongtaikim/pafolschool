<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/list.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: �Խ��� ��Ϻ���
*****************************************************************
* 
*/

if($mcode) {
	if(!$_SESSION[CAFE_ADMIN]) $PERMCAFE->apply('party',$pcode.'.'.$mcode,'l',$cafe_mtype);	
}

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid($_OID);

if($board_type == 'memo'){
	$sql = "select str_passwd from TAB_MEMBER where num_oid = '$_OID' and str_id = '".$_SESSION['USERID']."'";
	$str_passwd_r = $DB -> sqlFetchOne($sql);

	$tpl->assign(array(
	'NAME' => $_SESSION['NAME'],
	'PASSWD' => $str_passwd_r,
	'EMAIL' => $_SESSION['E_MAIL'],
	));

	//2007-10-28 �α��ν� ���� ������ �ֱ� ����
	if($admin){
		$tpl->assign(array(
		'NAME' => "������",
		'PASSWD' => "0000",
		'EMAIL' => "000@0000.000",
		));
	}


}

if($board_type == 'gallery') $listnum = 12;
else $listnum = 10;

$page = $_REQUEST['page'];
if (!$page) $page = 1;
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

if(!$total) $total = 0;


if($mcode){
	$que = " AND num_mcode=$mcode";
	$order = "order by num_group desc";
}else{
	if($mode == "ja") {
		$que2 = "and num_file > 0";
		$DOC_TITLE = $DOC_TITLE."(÷������ �ۺ���)";
	}

	if($mode == "hit") {
		$order = "order by num_hit desc";
		$DOC_TITLE = $DOC_TITLE."(����Ʈ �ۺ���)";
	}else{
		$order = "order by dt_date desc";
	}
}

//��ü��������
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
$tpl->assign(array('LIST_gong'=>$data2));



if($mcode){
	//��������
	$sql = "
	SELECT
		/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
		num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, num_pcode,
		str_title, str_email, num_hit, num_file, num_comment, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb, num_input_pass, rownum AS rnum
	FROM
		$ARTICLE_TABLE
	WHERE
		num_oid=$_OID AND num_pcode=$pcode  and  num_notice = 1 $que
	";
	$data3 = $DB->sqlFetchAll($sql);
	@array_walk($data3,'cb_format_list');
	$tpl->assign(array('LIST_g'=>$data3));
}

$total = $DB->sqlFetchOne("SELECT 
/*+ INDEX_DESC ($ARTICLE_TABLE IDX_TAB_PARTY_BOARD_LIST) */
COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode and  num_notice = 0 $que $que2 $whereadd");

//�Խñ�
$sql = "
SELECT
*
FROM
(SELECT
/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
num_pcode,num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak, str_text,
str_title, str_email, num_hit, num_file, num_comment, num_input_pass,  dt_date, TO_CHAR(dt_date,'YYYY-MM-DD HH:II:SS') dt_date2, str_category, str_thumb,num_rank, rownum AS rnum,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_nick,str_mov, str_view
FROM
$ARTICLE_TABLE
WHERE
num_oid=$oid AND num_pcode =$pcode $que  $listPsql    $whereadd $ddrder
)
WHERE
rnum > $seek  AND rnum <= $offset
";




$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');
$URL->delVar('id','num');

$tpl->define("CONTENT", "html/party/board/skin/".$board_skin."/list_".$board_type.".htm");

if ($data) $tpl->assign("LIST",&$data);
$tpl->assign(array(
'LIST2'=> $data2,
'listnum' => $listnum,
'mode'=>$mode,
'total'=>$total,
'page'=>$page,
'key'=>$key,
'search'=>$search,
'delcommlink' => "/party.board.del_comment"
));

function cb_format_list(&$arr,$key,$param) {
	global $_OID,$total,$seek,$listnum, $page, $_conf,$search,$URL,$FH, $v, $board_type;
	global $DB, $COMMENT_TABLE, $COMMENT_PRIMARY_INDEX, $COMMENT_TABLE,$board_skin;
	static $num;

	$arr['num'] = $total-($listnum * ($page-1));
	$arr['title'] = cut_str($arr['str_title'], 50);
	$arr['title2'] = cut_str($arr['str_title'], 8);
	if($arr['num_notice'] == 0) $arr['content'] = $arr['str_text']->load();
	
	$arr['dt_date'] = substr($arr['dt_date2'],0,10);
	if ($arr['str_thumb']) $arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);
	

	//2007-10-27 ���� �ָ��� �����̹��� ���� ���߱�
	if($arr['str_thumb']) $f_img =  _DOC_ROOT."/hosts/".HOST."/".$FH->sect."/".$arr['str_thumb']."_100";
	


	$normal_gallery=GetImageSize($f_img);

	$bbs_width = 110;
	$bbs_height = 110;

	$ratio1 = $bbs_width/$normal_gallery[0]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ��� 
	$ratio2 = $bbs_height/$normal_gallery[1]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ��� 

	if($ratio1 >= 1 && $ratio2 >= 1 ){
		$img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ��� 
		$img_h = $normal_gallery[1]; 
	}elseif($ratio1 > $ratio2){
		$img_w = $normal_gallery[0]*$ratio2; // �������� ���ο� ���ο� ������ ���� ����
		$img_h = $normal_gallery[1]*$ratio2; // ���� ���� ���� ���� 
	}elseif($ratio1 <= $ratio2){
		$img_w = $normal_gallery[0]*$ratio1; // �������� ���ο� ���ο� ������ ���� ����
		$img_h = $normal_gallery[1]*$ratio1; // ���� ���� ���� ���� 
	}else{
		$img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ��� 
		$img_h = $normal_gallery[1]; 
	}

	$arr['img_w'] = $img_w;
	$arr['img_h'] = $img_h;



	if ($arr['num_comment'] > 0) $arr['cmt'] = $arr['num_comment'];
	else $arr['cmt'] = '';
	// ÷�������� ������� ����Ʈ���� ǥ������� �� ��쿡���� ó��
	if ($arr['num_file'] > 0) $arr['file'] = '��������';
	$arr['bgcolor'] = ($num % 2) ? $colors['even'] : $colors['odd'];
	$arr['indent'] = str_repeat("��",$arr['num_depth']);
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
	
	//����Ÿ�� memo�ΰ�� ����� ���������.
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
