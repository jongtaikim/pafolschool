<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2005-03-16
* 작성자: 거친마루
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

$listnum = $_conf['option']['listnum'];
$navmum = $_conf['option']['navnum'];

$titlelen = $_conf['option']['listlen'];
$colors = $_conf['colors'];
$dateformat = "Y-m-d";

$page = $_REQUEST['page'];
if (!$page) $page = 1;
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

$total = $DB->sqlFetchOne("SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode $whereadd");
if(!$total) $total = 0;
$sql = "
	SELECT
		*
	FROM
		(SELECT
			/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
			num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
			str_title, str_email, num_hit, num_file, num_comment, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb, rownum AS rnum
		FROM
			$ARTICLE_TABLE
		WHERE
			num_oid=$oid AND num_mcode=$mcode $ddrder
		)
	WHERE
		rnum > $seek  AND rnum <= $offset
        $whereadd
";
echo "<!-- $sql -->";

$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_list');

$URL->delVar('id','num');
$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/list.htm"));
if ($data) $tpl->assign("LIST",&$data);
$tpl->assign(array(
	'env'=>$env,
	'mcode'=>$mcode,
	'total'=>$total,
	'page'=>$page,
    'key'=>$key,
    'search'=>$search
));

//==-- Functions --==//
function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}

$nnum = 0;
function cb_format_list(&$arr,$key,$param) {
	global $oid,$total,$seek,$listnum, $titlelen, $colors,$dataformat,$search,$search,$URL,$FH, $nnum;
	static $num;
	$nnum++;
	$arr['nnum'] = $nnum;
	$arr['num'] = $total - $seek - $num;
	$arr['title'] = cut_str($arr['str_title'], 50);
	if ($arr['str_thumb']) $arr['thumb_url']= $FH->get_thumb_url($arr['str_thumb']);

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
	if ($search) $arr['title'] = str_replace($search,'<font color="red">'.$search.'</font>',$arr['title']);
}
?>
