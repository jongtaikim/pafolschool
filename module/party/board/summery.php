<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/summery.php
* 작성일: 2006-05-11
* 작성자: 이범민
* 설  명: 최근게시물 목록 보여주기
*****************************************************************
* 
	Request Vars
        $param = array(
            'pcode' =>
		    'listnum' =>
*/
if(!$pcode = $param['pcode']) $pcode = $_REQUEST['pcode'];
$listnum = $param['listnum'] ? $param['listnum'] : 5;

// {{{ Functions
if(!function_exists('cb_format_board_list')) {
	function cb_format_board_list(&$arr) {
        static $css_num;
		$arr['link'] = 'party.board.read?pcode='.$arr['num_pcode'].'&mcode='.$arr['num_mcode'].'&id='.$arr['num_serial'];
		$arr['title'] = $arr['str_title'];
		if ($arr['num_depth']) $arr['title'] = 'Re: '.$arr['title'];
		$arr['date'] = $arr['dt_date'];
        $arr['is_recent'] = (date('U') - strtotime($arr['dt_date'])) < 241920;
        $arr['css'] = ++$css_num%2;

		if($arr['str_thumb']) {
            $FH = &WebApp::singleton('FileHost');
    		$FH->set_code('party',$arr['num_pcode'].'.'.$arr['num_mcode']);
            $arr['thumb_url'] = $FH->get_thumb_url($arr['str_thumb']);
        }
		else $data[$i]['thumb_url'] = "/image/noimage.gif";
	}
}
// }}}
$DB = &WebApp::singleton('DB');
$sql = "
    SELECT
        *
    FROM
        (SELECT /*+ INDEX_DESC (A $ARTICLE_ALL_INDEX) */
            A.num_pcode,
            A.num_mcode,
            A.num_depth,
            A.num_serial,
            A.str_title,
            TO_CHAR(A.dt_date,'YYYY-MM-DD') dt_date
        FROM
            ".$CONFIG_TABLE." B,
            ".$ARTICLE_TABLE." A
        WHERE
            B.num_oid="._OID." AND
            B.num_pcode=$pcode AND
            B.chr_listtype='B' AND
            B.chr_recent='Y' AND
            A.num_oid="._OID." AND
            A.num_pcode=$pcode AND
            A.chr_type='B' AND
            A.dt_date <= SYSDATE and
            A.num_mcode=B.num_mcode 
        ORDER BY A.dt_date DESC)
    WHERE 
        ROWNUM<=$listnum";

$data = $DB->sqlFetchAll($sql);
@array_walk($data,'cb_format_board_list');
$tpl = &WebApp::singleton('Display');
$tpl->define('_SUMMERY',$param['template']);
$tpl->assign('LIST',&$data);
$tpl->print_('_SUMMERY');
?>
