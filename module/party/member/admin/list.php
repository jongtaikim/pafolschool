<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-02
* 작성자: 이현민
* 설   명: 카페기본설정
*****************************************************************
* 
*/

switch($REQUEST_METHOD) {
	case "GET":

		$listnum = 10;
		$page = $_REQUEST['page'];
		if (!$page) $page = 1;
		$search_key = $_REQUEST['search_key'];
		$search_value = $_REQUEST['search_value'];
		if ($search_key && $search_value) $whereadd = "AND b.$search_key LIKE '%$search_value%'";
		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;

		if(!$total) $total = 0;
		
		$total = $DB->sqlFetchOne("select count(*) from TAB_PARTY_MEMBER where num_oid=$_OID and num_pcode=$pcode $whereadd");
		
		$sql = "
		select a.* from (
		select ROWNUM as RNUM, b.* from (

			select 
				a.str_id, a.str_mtype, a.str_date, a.num_board, a.num_comment, a.num_login, 
				a.str_text1, a.str_text2, a.str_text3, a.str_text4, a.str_text5,
				b.str_name, b.str_nick 
			from TAB_PARTY_MEMBER a, TAB_MEMBER b 
			where a.num_oid=$_OID and a.num_pcode=$pcode and a.num_oid=b.num_oid and a.str_id=b.str_id  $whereadd
			order by a.str_date desc

		)b)a
		where a.RNUM >  $seek and a.RNUM <= $offset ";

		$row = $DB -> sqlFetchAll($sql);
		
		$mem_types = WebApp::get('member',array('key'=>'member_types'));

		for($ii=0; $ii<count($row); $ii++) {
			$row[$ii][mtype] = WebApp::get('party.member',array('key'=>'member_types'));

			$sql = "select num_auth, chr_mtype from TAB_MEMBER where num_oid = $_OID and str_id = '".$row[$ii][str_id]."' ";
			$mmtupe = $DB -> sqlFetch($sql);
		
			$row[$ii][num_auth] = $mmtupe[num_auth];
			$row[$ii][chr_mtype] = $mem_types[$mmtupe[chr_mtype]];
			
		
		
		}
		
		$tpl->assign(array(
			'LIST'=>$row,
			'search_key'=>$search_key,
			'search_value'=>$search_value,
			'page'=>$page,
			'total'=>$total,
			'listnum'=>$listnum,
		));

		//카페멤버등급
		//$_cafe_mtypes = WebApp::get('party.member',array('key'=>'member_types'));
	

		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/member/admin/list.htm');
	break;

	case "POST":

	break;
}

function list_format(&$arr) {
	global $URL;
	$arr['str_title'] = cut_str($arr['str_title'], 30);
}
?>