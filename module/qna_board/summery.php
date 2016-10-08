<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/summery.php
* 작성일: 2004-07-12
* 작성자: 이범민
* 설  명: Customize 최근 목록 보여주기
*****************************************************************
* 
	Request Vars
		$code
		$listnum
*/

$tpl = &WebApp::singleton('Display');

// {{{ Functions
if(!function_exists('cb_format_board_list')) {
	function cb_format_board_list(&$arr) {
		$FH = &WebApp::singleton('FileHost');
		$arr['link'] = '/?act=board.read&code='.$arr['num_mcode'].'&id='.$arr['num_serial'];
		$arr['title'] = $arr['str_title'];
		if ($arr['num_depth']) $arr['title'] = 'Re: '.$arr['title'];
		$arr['date'] = $arr['dt_date'];
		if (date('U') - strtotime($arr['date']) <= 86400) $arr['icon'] = '<img src="/image/temp/A/icon10.gif" width="25" height="8" align="absmiddle">';
		else $arr['icon'] = '';
		$FH->set_code('menu',$arr['num_mcode']);
		if($arr['str_thumb']) $arr['thumb_url'] = $FH->get_thumb_url($arr['str_thumb']);
		else $data[$i]['thumb_url'] = "/image/noimage.gif";
	}
}
// }}}

$designtype = WebApp::getConf('design.type');
$_OID = WebApp::getConf('oid');
$DB = &WebApp::singleton('DB');

$sql = "
	SELECT
		/*+ INDEX_DESC({$ARTICLE_TABLE} IDX_{$ARTICLE_TABLE}_ALL) */
		num_mcode, num_depth, num_serial, str_title, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date
	FROM
		{$ARTICLE_TABLE}
	WHERE
		num_oid=$_OID AND chr_type='B' AND rownum<=$listnum
";
$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_board_list');
$tpl->define('_SUMMERY',$param['template']);
$tpl->assign('LIST_'.$code,&$data);
$tpl->print_('_SUMMERY');
?>
