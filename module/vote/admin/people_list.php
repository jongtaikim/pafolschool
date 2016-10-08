<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일:2009-08-10
* 작성자: 김종태
* 설   명: 유권자 관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

		$code = $_REQUEST['code'];
		if(!$page = $_REQUEST['page']) $page = 1;

		if(!$listnum)$listnum = 20;
		$sql = "SELECT COUNT(*) FROM ".TAB_VOTE_PEOPLE." WHERE NUM_OID=$_OID ";


		$total = $DB->sqlFetchOne($sql);
		if(!$total) $total = 0;


		$page = $_REQUEST['page'];
		if (!$page) $page = 1;

		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;

		$sql = "
		select a.* from (
				 select ROWNUM as RNUM, b.* from (


			SELECT * FROM ".TAB_VOTE_PEOPLE." WHERE NUM_OID=$_OID


		)b)a
						where a.RNUM >=  $seek and a.RNUM <= $offset ";

		//echo  $sql;


		$data = $DB->sqlFetchAll($sql);
		array_walk($data,'del_jumin');

		$tpl->assign(array(
		'title'=>$title,
		'LIST'=>$data,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
		'itemPerPage'=>$itemPerPage
		));






	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/people_list.htm"));
	
	 break;
	case "POST":




	 		switch($mode) {
			case "sel" :	//선택삭제
				for( $i=0; $i < sizeof($basecode); $i++ ){
					$tmp_info = explode("#", $basecode[$i]);
					$WHERE = "num_oid="._OID." AND str_grade='".$tmp_info[0]."' AND str_class='".$tmp_info[1]."' AND str_jumin = '".$tmp_info[2]."' ";
					$DB->query("DELETE FROM tab_vote_people WHERE ".$WHERE);
					
					$DB->commit();
				
				}				
				break;
			case "all" :	//전체삭제

				$DB->query("DELETE FROM tab_vote_people WHERE num_oid="._OID."");
				$DB->commit();
				
				break;
			}


		WebApp::redirect('/vote.admin.people_list?page='.$page);
		break;
		}




	function del_jumin(&$arr) {
		
		$arr['del_jumin'] = $arr['str_grade']."#".$arr['str_class']."#".$arr['str_jumin'];
	}
?>