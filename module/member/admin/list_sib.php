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

        $mtypes = WebApp::get('member',array('key'=>'member_types'));

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
        if($search_key && $search_value) {
            if(substr($search_key,0,3) != "num") {
                $where = "AND $search_key LIKE '%$search_value%' ";
            } else {
                $where = "AND $search_key = $search_value ";
            }
        }
        $search_auth = $_REQUEST['search_auth'];
        if($search_auth != '') $where .= "AND m.num_auth=$search_auth ";
        

if($str_option) {
	$where .= "and o.str_option = '".$str_option."'";
	$tpl->assign(array('str_option'=>$str_option));
	
	
}


        $sql = "SELECT COUNT(*) 	FROM TAB_MEMBER m, TAB_MEDIA_ORDER o
                    WHERE                       
                     m.num_oid=$_OID and
					m.num_oid= o.num_oid  and
						m.str_id = o.str_id
                     
					 $where  ";
      
		$total = $DB->sqlFetchOne($sql);

		if(!$total) $total = 0;


  $sql1 = "SELECT COUNT(*) FROM TAB_MEMBER m ,TAB_MEDIA_ORDER o  WHERE                       
                        m.num_oid=$_OID and
						m.num_oid= o.num_oid and m.num_auth=0 and
						m.str_id = o.str_id $where";
  $total1 = $DB->sqlFetchOne($sql1);

  $sql2 = "SELECT COUNT(*) FROM TAB_MEMBER m ,TAB_MEDIA_ORDER o WHERE                       
                        m.num_oid=$_OID and
						m.num_oid= o.num_oid   and m.num_auth=1 and
						m.str_id = o.str_id $where";
  $total2 = $DB->sqlFetchOne($sql2);

switch($align) {
	case "name":
	$align = " order by m.str_name ";
	break;
	case "id":
	$align = " order by m.str_id ";
	break;
	case "mtype":
	$align = " order by m.chr_mtype ";
	break;
	case "dt_date":
	$align = " order by m.dt_date ";
	break;
	case "str_nick":
	$align = " order by m.dt_date ";
	break;
	case "auth":
	$align = " order by m.num_auth ";
	break;
	case "str_phone":
	$align = " order by m.str_phone ";
	break;
	case "str_handphone":
	$align = " order by m.str_handphone ";
	break;
	default:
	$align = " order by m.dt_date desc ";
	break;

}


$sql = "
select * from (
         select ROWNUM as RNUM, b.* from (


 SELECT 
                       
                        m.str_name,
                        m.str_id,
						m.str_email,
                        m.str_passwd,
						m.chr_mtype,
						m.num_birthday,

						m.str_nick,
						m.str_phone,
						m.str_handphone,
						m.num_auth,
						m.str_state,
						
						m.num_grade,
						m.num_hid,
						m.num_login_cnt,
						m.num_login_point,
						m.num_board_point,
						m.num_commint_point,
						m.num_repaly_point,
						TO_CHAR(m.dt_date,'YYYY-MM-DD') dt_date
						
						
					FROM TAB_MEMBER m , TAB_MEDIA_ORDER o
                    WHERE
                       
                        m.num_oid=$_OID and
						m.num_oid= o.num_oid and
						m.str_id = o.str_id
						


                        $where $align


)b)a
                where RNUM >=  $offset and RNUM <= $offset+$listnum ";



		$data = $DB->sqlFetchAll($sql);

	/*
	
		*/
		for($ii=0; $ii<count($data); $ii++) {
	
	$data[$ii][mtypes] = $mtypes;
	$data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;
	$data[$ii][nno] = $ii+1;
	$mtype = $data[$ii]['chr_mtype'];
	 $sql2  = "select str_group_name from TAB_GROUP where num_oid=$_OID and str_group = '$mtype' ";
	 $member_type = $DB->sqlFetchOne($sql2);
		
	if($mtype != 1) {
		$font1 = "<font color = red>";
		$font2 = "</font>";
	}else{
		$font1 = "<font color = blue>";
		$font2 = "</font>";
	}
	 $data[$ii]['str_group'] =  $font1.$member_type.$font2;
	
	}
		


		//2008-11-02 종태 스탁은 유료서비스 권한 가져오게

		
		$sql = "select distinct str_option  from TAB_MEDIA_ORDER where num_oid = '$_OID' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('LIST_sbis'=>$row));
		



   		$tpl->define('CONTENT','html/member/admin/list.htm');


		


		$tpl->assign(array(
            'MTYPES'        =>  $mtypes,
            'GROUPS'        =>  $gdata,
            'LIST'			=>	$data,
            'page'			=>	$page,
            'total'			=>	$total,
            'listnum'		=>	$listnum,
            'noauth'        =>  $noauth,
            'search_key'	=>	$search_key,
            'search_value'	=>	$search_value,
            'search_auth'	=>	$search_auth,
            'search_mtype'	=>	$search_mtype,
            'search_group'	=>	$search_group,
  			'total1'	=>	$total1,
            'total2'	=>	$total2,
			'total3'	=>	$total1 + $total2,
        ));
	break;
	case "POST":
       
		$ids = $_POST['ids'];
        $ids_in = "'".implode("','",$ids)."'";

        switch($_POST['mode']) {
        	case "delete":
                if($relation) {
                    // 게시판 게시물 삭제
                    $FH = &WebApp::singleton('FileHost');
                    $suffix = '';//$_OID % 10;
                    $sql = "SELECT num_mcode,num_serial,str_text1,str_text2,str_text3,str_thumb FROM ".TAB_BOARD.$suffix." WHERE num_oid=$_OID AND str_user IN (".$ids_in.")";
                    if(!$data = $DB->sqlFetchAll($sql)) {
                        foreach ($data as $row) {
                            $FH->set_code('menu',$row['num_mcode']);
                            if($row['str_thumb']) $FH->del_thumb($row['str_thumb']);
                            $FH->delete_as_html($row['str_text1'].$row['str_text2'].$row['str_text3']);
                            $FH->delete_as_main($row['num_serial']);
                        }
                    }
                    
				//2008-10-27 종태 인증내역도 지워
                    $sql = "DELETE FROM ".TAB_HANDPHONE_IDX." WHERE num_oid=$_OID AND str_id IN (".$ids_in.")";
                    $DB->query($sql);
                    $DB->commit();
		

					$sql = "DELETE FROM ".TAB_BOARD.$suffix." WHERE num_oid=$_OID AND str_user IN (".$ids_in.")";
                    $DB->query($sql);
                    $DB->commit();

                    $sql = "DELETE FROM ".TAB_BOARD.$suffix._COMMENT." WHERE num_oid=$_OID AND str_user IN (".$ids_in.")";
                    $DB->query($sql);
                    $DB->commit();

                    // 상담실 게시물 삭제
                    $sql = "SELECT num_mcode,num_serial,str_text1,str_text2,str_text3 FROM ".TAB_COUNCIL." WHERE num_oid=$_OID AND str_ouser IN (".$ids_in.")";
                    if(!$data = $DB->sqlFetchAll($sql)) {
                        foreach ($data as $row) {
                            $FH->set_code('menu',$row['num_mcode']);
                            $FH->delete_as_html($row['str_text1'].$row['str_text2'].$row['str_text3']);
                            $FH->delete_as_main($row['num_serial']);
                        }
                    }
                    
                    $sql = "DELETE FROM ".TAB_COUNCIL." WHERE num_oid=$_OID AND str_ouser IN (".$ids_in.")";
                    $DB->query($sql);
                    $DB->commit();
                }

                $sql = "DELETE FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id IN (".$ids_in.")";
                $DB->query($sql);
                $DB->commit();

                $sql = "DELETE FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id IN (".$ids_in.")";
                $DB->query($sql);
                $DB->commit();

                WebApp::moveBack('삭제되었습니다.');
        	break;
        	case 'auth':
        		$sql = "UPDATE ".TAB_MEMBER." SET num_auth=1 WHERE num_oid=$_OID AND str_id IN (".$ids_in.")";
                $DB->query($sql);
                $DB->commit();

                WebApp::moveBack('인증 되었습니다.');
        	break;
            case 'noauth':
                $sql = "UPDATE ".TAB_MEMBER." SET num_auth=0 WHERE num_oid=$_OID AND str_id IN (".$ids_in.")";
                $DB->query($sql);
                $DB->commit();

                WebApp::moveBack('인증취소 되었습니다.');
            break;
        }

	break;
}
?>
