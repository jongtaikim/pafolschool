<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	

$sql = "select num_login_point,num_board_point,num_commint_point,num_repaly_point from TAB_ORGAN where num_oid = '$_OID' ";
$chw = $DB -> sqlFetch($sql);
$tpl->assign($chw);



        if(!$page = $_REQUEST['page']) $page = 1;
        if(!$listnum) {
		$listnum = 50;	
        }
        
		$offset = ($page-1) * $listnum;

        $mtypes = WebApp::get('member',array('key'=>'member_types'));

		//print_r($mtypes);

        $sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
        $gdata = $DB->sqlFetchAll($sql);

        $wehre = '';

switch($noauth) {
	case "0":
	 $where .= 'AND num_auth=0 ';
	break;
	case "1":
	 $where .= 'AND num_auth=1 ';
	break;

}


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
        $search_group = $_REQUEST['search_group'];
        if($search_group != '') $where .= "AND str_id IN (SELECT str_id FROM ".TAB_GROUP_MEMBER." WHERE NUM_OID=$_OID AND str_group='$search_group') ";

        $sql = "SELECT COUNT(*) 	FROM TAB_MEMBER
                    WHERE                       
                     num_oid=$_OID 
                     $where $align";
      
		$total = $DB->sqlFetchOne($sql);
        if(!$total) $total = 0;



switch($align) {
	case "name":
	$align = " order by str_name ";
	break;
	case "id":
	$align = " order by str_id ";
	break;
	case "mtype":
	$align = " order by chr_mtype ";
	break;
	case "dt_date":
	$align = " order by dt_date ";
	break;
	case "auth":
	$align = " order by num_auth ";
	break;
	case "str_phone":
	$align = " order by str_phone ";
	break;
	case "str_handphone":
	$align = " order by str_handphone ";
	break;
	default:
	$align = " order by dt_date desc ";
	break;

}


$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (


 SELECT 
                       
                        str_name,
                        str_id,
                        str_email,
                        str_passwd,
						chr_mtype,
						num_birthday,

						
						str_phone,
						str_handphone,
						num_auth,
						str_state,
						
						num_grade,
						num_hid,
						num_login_cnt,
						num_login_point,
						num_board_point,
						num_commint_point,
						num_repaly_point,
						TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,
						num_point_total

						
						
					FROM TAB_MEMBER
                    WHERE
                       
                        num_oid=$_OID 
                        $where $align


)b)a
                where a.RNUM >=  $offset and a.RNUM <= $offset+$listnum ";




	$row = $DB -> sqlFetchAll($sql);


		$tpl->assign(array(
            'MTYPES'        =>  $mtypes,
            'GROUPS'        =>  $gdata,
            'LIST'			=>	$row,
            'page'			=>	$page,
            'total'			=>	$total,
            'listnum'		=>	$listnum,
            'noauth'        =>  $noauth,
			 'noauth2'        =>  $noauth2,
            'search_key'	=>	$search_key,
            'search_value'	=>	$search_value,
            'search_auth'	=>	$search_auth,
            'search_mtype'	=>	$search_mtype,
            'search_group'	=>	$search_group,
  			'total1'	=>	$total1,
            'total2'	=>	$total2,
			'total3'	=>	$total1 + $total2,
        ));





	$tpl->define("CONTENT", Display::getTemplate("member/admin/point_list.htm"));
	
	 break;
	case "POST":




			switch ($mode) {
			case "setup":

			$sql = "UPDATE ".TAB_ORGAN." SET 
			
			num_login_point = '$num_login_point',  
			num_board_point = '$num_board_point',
			num_commint_point = '$num_commint_point',
			num_repaly_point = '$num_repaly_point'

			
			WHERE num_oid=$_OID";

			$DB->query($sql);
			$DB->commit();
			WebApp::moveBack();
			break;
			case "reset":
			 
				$sql = "UPDATE ".TAB_MEMBER." SET 
			
			num_login_point = '0',  
			num_board_point = '0',
			num_commint_point = '0',
			num_repaly_point = '0',
			num_point_total = '0'

			
			WHERE num_oid=$_OID";
			$DB->query($sql);
			$DB->commit();
			WebApp::moveBack();
			
			break;
			


	case "mod":
	
	$sql = "select 
	NUM_LOGIN_POINT, 
   NUM_BOARD_POINT, 
   NUM_COMMINT_POINT, 
   NUM_REPALY_POINT 
   
   from TAB_ORGAN where num_oid = '$_OID' ";
$point_data = $DB -> sqlFetch($sql);

	
	

			for($ii=0; $ii<count($str_id); $ii++) {
			
				
			$totalpint[$ii] = 
				($point_data[num_login_point] * $num_login_point[$ii])+
				($point_data[num_board_point] * $num_board_point[$ii])+
				($point_data[num_commint_point] * $num_commint_point[$ii])+
				($point_data[num_repaly_point] * $num_repaly_point[$ii]);
				
			
			
			
			$sql = "UPDATE ".TAB_MEMBER." SET 
			
			num_login_point = '".$num_login_point[$ii]."',  
			num_board_point =  '".$num_board_point[$ii]."',  
			num_commint_point =  '".$num_commint_point[$ii]."',  
			num_repaly_point =  '".$num_repaly_point[$ii]."',
			num_point_total = '".$num_point_total[$ii]."'
			
			WHERE num_oid=$_OID and str_id='".$str_id[$ii]."' ";
			$DB->query($sql);
			$DB->commit();
			}
			WebApp::moveBack();
			
			break;

			}
			
			
			


	 break;
	}

?>