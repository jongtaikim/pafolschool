<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/_cache.php
* 작성일: 2004-02-23
* 작성자: 거친마루
* 설  명: 게시판 글을 최근 목록으로 저장하기
*****************************************************************
* -*- only call by applet -*-
*/

// {{{ Functions XXX: function_exists 함수로 감싼 function은 호출보다 먼저 정의되어야함
if (!function_exists('cb_format_board_list')) {
	function cb_format_board_list(&$arr) {
		static $css_num;
		$arr['link'] = '/?act=board.read&code='.$arr['num_mcode'].'&id='.$arr['num_serial'];
		$arr['title'] = $arr['str_title'];
		if ($arr['num_depth']) $arr['title'] = 'Re: '.$arr['title'];
		$arr['date'] = $arr['dt_date'];
	/*	if (date('U') - strtotime($arr['date']) <= 86400) $arr['icon'] = '<img src="/image/temp/A/icon10.gif" width="25" height="8" align="absmiddle">'; */
		else $arr['icon'] = '';

		$arr['css'] = ++$css_num%2 ; // 메인페이지에 라인별로 다른 스타일 시트 적용가능하게 0 과 1 반환
	}
}
// }}}

$tpl = &WebApp::singleton('Display');
$template = $param['template'];
if (!$template) $template = WebApp::getTemplate('board/summery.htm');
$designtype = WebApp::getConf('design.type');
$_OID = WebApp::getConf('oid');
$DB = &WebApp::singleton('DB');
$NUMBERS = WebApp::getNumbers();
$num = $NUMBERS['main.board'];

$tpl->caching = true;
if (!$tpl->isCached('main_board',0, $_OID)) {
	// 선택적으로 최근게시물 가져오도록 수정(2004-08-30)
	$sql = "
        SELECT
            num_mcode,
            num_depth,
            num_serial,
            str_title,
            TO_CHAR(DT_DATE,'YYYY-MM-DD') dt_date
        FROM
            (SELECT /*+ INDEX_DESC (A IDX_".$ARTICLE_TABLE."_ALL) */
                A.num_mcode,
                A.num_depth,
                A.num_serial,
                A.str_title,
                A.dt_date
            FROM
                ".$ARTICLE_TABLE."_CONFIG B,
                ".$ARTICLE_TABLE." A
            WHERE
                B.num_oid=$_OID AND
                B.chr_listtype='B' AND
                B.chr_recent='Y' AND
                A.num_oid=$_OID AND
                A.chr_type='B' AND
                A.dt_date <= SYSDATE and
                A.num_mcode=B.num_mcode 
            ORDER BY A.dt_date DESC)
        WHERE 
            ROWNUM<=5
";

	// 여기서 5는 게시물수. 타잎별로 다르다면 설정파일에 추가해야 한다.
	$data = $DB->sqlFetchAll($sql);
	@array_walk($data,'cb_format_board_list');

	$tpl->define('CONTENT', $template);
	$tpl->assign('LIST',&$data);

	$result = $tpl->fetch('CONTENT');
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($result, FTP_ROOT."/hosts/".HOST."/inc.main.board.htm");
}
$tpl->print_('CONTENT');

?>
