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

		//print_r($mtypes);

        $sql = "SELECT * FROM ".TAB_ORGAN." order by str_organ asc";
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
        if($search_group != '') $where .= "AND num_oid = '$search_group' ";

        $sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE num_oid > 0  $where";
      
		$total = $DB->sqlFetchOne($sql);
        if(!$total) $total = 0;


  $sql1 = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE num_auth=0 ";
  $total1 = $DB->sqlFetchOne($sql1);

  $sql2 = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE num_auth=1 ";
  $total2 = $DB->sqlFetchOne($sql2);


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
	case "email":
	$align = " order by str_email ";
	break;
	case "auth":
	$align = " order by num_auth ";
	break;

}

        $sql = "SELECT * FROM (
                    SELECT 
                        ROWNUM AS rnum,
                        num_oid,
						str_name,
                        str_id,
                        str_email,
                        chr_mtype,
						num_birthday,
						decode(chr_birthday,'s','양','음') birthday_type,
						str_phone,
						str_handphone,
						num_auth

					FROM ".TAB_MEMBER."
                    WHERE
                        ROWNUM<=$offset+$listnum 
                        
                        $where

						order by num_oid desc
                ) WHERE rnum>$offset   $align";
 
		$data = $DB->sqlFetchAll($sql);
	
	/*
	
		*/
		for($ii=0; $ii<count($data); $ii++) {
			
	$mtype = $data[$ii]['chr_mtype'];
	 $sql2  = "select str_group_name from TAB_GROUP where  str_group = '$mtype' ";
	 $member_type = $DB->sqlFetchOne($sql2);
		
	if($mtype != 1) {
		$font1 = "<font color = red>";
		$font2 = "</font>";
	}else{
		$font1 = "<font color = blue>";
		$font2 = "</font>";
	}
	 $data[$ii]['str_group'] =  $font1.$member_type.$font2;
	
	$data[$ii]['str_organ'] = $DB -> sqlFetchOne("select str_organ from tab_organ where num_oid = '".$data[$ii]['num_oid']."' ");
	


	}
		
if ($noauth == "0"){
$noauth2 = "sasd";
}
       
		$tpl->setLayout('menu1');
        $tpl->define('CONTENT','html/member/admin/list_all.htm');
		
		$tpl->assign(array(
            'MTYPES'        =>  $mtypes,
            'GROUPS'        =>  $gdata,
            'LIST'			=>	$data,
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
        }

	break;
}
?>
