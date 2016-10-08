<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2006-03-17
* 작성자: 이범민
* 설  명: 회원목록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');




switch($REQUEST_METHOD) {
	case "GET":
        if(!$page = $_REQUEST['page']) $page = 1;
        if(!$listnum) {
		$listnum = 15;	
        }
        
		$offset = ($page-1) * $listnum;



        $search_key = $_REQUEST['search_key'];
        $search_value = $_REQUEST['search_value'];
        if(isset($search_key) && isset($search_value)) {
            if(substr($search_key,0,3) != "num") {
                $where = "AND $search_key LIKE '%$search_value%' ";
            } else {
                $where = "AND $search_key = $search_value ";
            }
        }
        $search_auth = $_REQUEST['search_auth'];
        if($search_auth != '') $where .= "AND num_auth=$search_auth ";
        $search_mtype = $_REQUEST['search_mtype'];
        if($search_mtype != '') $where .= "AND chr_mtype = '$search_mtype' ";



        $sql = "SELECT COUNT(*) 	FROM TAB_MEMBER_DEL
                    WHERE                       
                     num_oid=$_OID 
                     $where $align";
      
		$total = $DB->sqlFetchOne($sql);
        if(!$total) $total = 0;






$sql = "
select * from (
         select ROWNUM as RNUM, b.* from (


 
SELECT 
	 NUM_OID, 
	 NUM_SERIAL, 
	 STR_ID, 
     STR_TEXT, 
	 STR_TITLE
FROM TAB_MEMBER_DEL 

                        $where $align


)b)a
                where RNUM >=  $offset and RNUM <= $offset+$listnum ";



		$data = $DB->sqlFetchAll($sql);
	/*
	
		*/







   		$tpl->define('CONTENT','html/member/admin/del_list.htm');


		


		$tpl->assign(array(
           
            'LIST'			=>	$data,
            'page'			=>	$page,
            'total'			=>	$total,
            'listnum'		=>	$listnum,
            
            'search_key'	=>	$search_key,
            'search_value'	=>	$search_value,
            'search_auth'	=>	$search_auth,
           
  			'total'	=>	$total,

			
        ));
	break;
	case "POST":
       


	break;
}
?>
