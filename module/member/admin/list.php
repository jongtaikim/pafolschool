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
        
		
		
		
        $mtypes =  array(
		
		'g' => '학부모',
	
		's' => '학생',
		
		'm' => '맨토',
		'z' => '최고관리자' );

		$sql = "select chr_mtype , count(chr_mtype) as counter from TAB_MEMBER where num_oid = $_OID group by chr_mtype ";
		$member_types_count = $DB -> sqlFetchAll($sql);
		for($ii=0; $ii<count($member_types_count); $ii++) {
			$member_types_count[$ii][name] = $mtypes[$member_types_count[$ii][chr_mtype]];
		}
		
		$tpl->assign(array('member_types_count'=>$member_types_count));




		$offset = ($page-1) * $listnum;




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
        if($search_auth != '') $where .= "AND num_auth=$search_auth ";
        $search_mtype = $_REQUEST['search_mtype'];
        if($search_mtype != '') $where .= "AND chr_mtype = '$search_mtype' ";
		if($search_group) $where .= "AND str_group like '%$search_group%' ";

        $sql = "SELECT COUNT(*) 	FROM TAB_MEMBER
                    WHERE                       
                     num_oid=$_OID 
                     $where $fsql ";
      
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
	case "str_nick":
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


if($num_fcode){
	$fsql = " and num_fcode = '".$num_fcode."'";
}

$maxnum = $offset+$listnum;

$sql = " SELECT                        
                       
					   *
						
					FROM TAB_MEMBER 
                    
					WHERE
                       
                        num_oid=$_OID 


                        $where $fsql  $align



                limit $offset ,$listnum  ";


		$data = $DB->sqlFetchAll($sql);




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

	$ftype = $data[$ii]['num_fcode'];
	$sql3 = "select str_fname_full from TAB_CLASS_FORMATION where num_oid=$_OID and num_fcode = '$ftype' ";
	$f_type = $DB->sqlFetchOne($sql3);
	$data[$ii]['ftypes'] = $f_type;

	
	}
		



		



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
			'num_fcode'	=>	$num_fcode,
			'query_string' =>		$__[query]
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

			case 'gg':
        		$sql = "UPDATE ".TAB_MEMBER." SET chr_mtype='a' WHERE num_oid=$_OID AND chr_mtype = 's' and str_id IN (".$ids_in.")  ";

                $DB->query($sql);
                $DB->commit();

                WebApp::moveBack('처리 되었습니다.');
        	break;

			case 'msg':

			 for($ii=0; $ii<count($_POST['ids']); $ii++) {
				
				
				$max_serial = WebApp::maxSerial("TAB_MEMO",'num_serial');
				$sql = "INSERT INTO ".TAB_MEMO." (
						
						num_oid, str_send_id, str_to_id,num_serial,str_title, str_text, str_send_date, str_save,str_send_del, str_to_del, str_send_name,str_send_nick
						) VALUES (
						"._OID.", 'admin', '".$_POST['ids'][$ii]."',".$max_serial.",'".$str_title."', '".$mmsg."', ".mktime().", 'N','N', 'N', '학교관리자','학교관리자'
						) ";
				
				
 			    $DB->query($sql);
				//echo $sql."<br><br>";
			 }
			 
			 
			 
			 
        	   $DB->commit();

               WebApp::moveBack('처리 되었습니다.');
        	break;
        }

	break;
}
?>
