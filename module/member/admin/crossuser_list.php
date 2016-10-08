<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/admin/crossuser.php
* �ۼ���: 2008-11-28
* �ۼ���: ������
* ��  ��: �ҷ�ȸ��(ID, IP)����
*****************************************************************
* 
*/

switch($REQUEST_METHOD) {
	case "POST":
		
		if($mode == 'new'){
			$serial = $DB->sqlFetchOne("SELECT max(NUM_SERIAL) + 1 FROM TAB_CROSSUSER WHERE NUM_OID = $_OID");
			if (!$serial) $serial = 1;

			$sql = "insert into TAB_CROSSUSER(num_oid, num_serial, str_chk, str_text, str_alert, num_date)
						values($_OID, $serial, '".iconv("utf-8","euc-kr",$str_chk)."', '".iconv("utf-8","euc-kr",$str_text)."', '".iconv("utf-8","euc-kr",$str_alert)."', '".mktime()."')";
			$DB->query($sql);
			$DB->commit();
		}

	break;
}

		if(!$page = $_REQUEST['page']) $page = 1; //��������ȣ
		if(!$listnum)$listnum = 20;  //���������� ���� ��

		if($searchvalue){
			$searchkey = iconv("utf-8","euc-kr",$searchkey);
			$searchvalue = iconv("utf-8","euc-kr",$searchvalue);
			
			if($searchkey) $where = " and str_chk='$searchkey' and str_text like '%$searchvalue%'";
			else $where = " and str_text like '%$searchvalue%'";
		}

		$sql = "SELECT COUNT(*) FROM TAB_CROSSUSER WHERE NUM_OID=$_OID $where";
		$total = $DB->sqlFetchOne($sql);
		if(!$total) $total = 0; // ��ü �ۼ�

		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;
		$fno = $total-($listnum * ($page-1));

		$sql = "
		select a.* from (
				 select ROWNUM as RNUM, b.* from (


		select num_oid, num_serial, str_chk, str_text, str_alert, num_date
		from TAB_CROSSUSER where num_oid = $_OID $where

		order by num_serial desc


		)b)a
						where a.RNUM >  $seek and a.RNUM <= $offset ";

		$data = $DB->sqlFetchAll($sql);

		$tpl->assign(array(
		'listnum'=>$listnum,
		'LIST'=>$data,
		'page'=>$page,
		'total'=>$total,
		'fno'=>$fno,
		'searchkey'=>$searchkey,
		'searchvalue'=>$searchvalue
		));

		$template = "html/member/admin/crossuser_list.htm";

		$tpl->define('CROSSUSER_',$template);
		$content = $tpl->fetch("CROSSUSER_");

		echo $content;
?>
