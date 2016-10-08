<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/main.php
* 작성일: 2008-12-23
* 작성자: 김종태
* 설  명: 
mode : recent(최시글), hot(인기글), notice1(게시판공지), notice2(전체공지)
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');

$mcode = $param['code'];
$mode = $param['mode'];
$bskin = $param['bskin'];
$btype = $param['btype'];
$mtype = $param['mtype'];
$listnum = $param['listnum'];
$len = $param['len'];
if(!$param['len']) $len = 65;

if(!$listnum) $listnum=5;

$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid(_OID);

if($mcode) $addsql1 = " and num_mcode=$mcode";

switch($mode){
	case "recent":
		$addsql2 = "";
		$ordersql = " order by dt_date desc";
		break;
	case "hot":
		$addsql2 = " and num_notice=0";
		$ordersql = " order by num_hit desc";
		break;
	case "notice1":
		$addsql2 = " and num_notice=1";
		$ordersql = " order by dt_date desc";
		break;
	case "notice2":
		$addsql2 = " and num_notice=2";
		$ordersql = " order by dt_date desc";
		break;
}

$sql = "
select a.* from (
	select ROWNUM as RNUM, b.* from (

		SELECT
			num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, 
			str_title, str_email, num_hit, num_file, num_comment, dt_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date2, str_thumb, num_input_pass
		FROM
			TAB_PARTY_BOARD
		WHERE
			num_oid="._OID." AND num_pcode=$pcode $addsql1 $addsql2 $ordersql

	)b)a
where a.RNUM >=0 AND a.RNUM <= $listnum";

$data = $DB->sqlFetchAll($sql);
for($ii=0; $ii<count($data); $ii++) {

	$data[$ii]['title'] = cut_str($data[$ii]['str_title'], $len,"..");
	$data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;
	if ($data[$ii]['num_comment'] > 0) $data[$ii]['cmt'] = $data[$ii]['num_comment'];
	else $data[$ii]['cmt'] = '';

	if ($data[$ii]['str_thumb']) $data[$ii]['str_thumb']= $FH->get_thumb_url($data[$ii]['str_thumb']);

	$data[$ii]['readlink'] = $URL->setVar(
		array(
		'act' => '/party.board.read?pcode='.$data[$ii]['num_pcode'].'&mcode='.$data[$ii]['num_mcode'].'&id='.$data[$ii]['num_serial'],
	
		)
	);
}


//$template = "/html/party/board/skin/".$bskin."/list_main.htm";
//$tpl->define("BBSlist",$template);
$tpl->define("BBSlist",$param['template']);

$tpl->assign(array("mcode"=>$mcode, "pcode"=>$pcode, "mode"=>$mode, 'bskin'=>$bskin, 'btype'=>$btype));
$tpl->assign(array('Boardlist'=>$data));
$content = $tpl->fetch("BBSlist");
echo $content ;


?>