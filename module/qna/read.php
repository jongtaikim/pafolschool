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
	
	$_SESSION[EMAILS] = str_replace(" ","",$_SESSION[EMAILS]);

	$sql = "select * from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$id."' and str_wr_index  = '1'  ";
	$data = $DB -> sqlFetch($sql);
	
	$datas[num_hit] = $data[num_hit]+1;
	$DB->updateQuery("TAB_QNA",$datas, " num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$id."' and str_wr_index  = '1'");
	$DB->commit();


		if($_SESSION[ADMIN]){
			$emails = explode("@",$data[str_email]);
			$tpl->assign(array(
				'email11'=>$emails[0],
				'email22'=>$emails[1],
			 ));		
		}else{

		$emails = explode("@",$_SESSION[EMAILS]);
		$tpl->assign(array(
			'email11'=>$emails[0],
			'email22'=>$emails[1],
		 ));

		}


	$tpl->assign(array('data1'=>$data));

		
	
	 break;
	case "POST":
	

	

	 $sql = "select * from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$id."' and str_wr_index  = '1'  ";
	$data = $DB -> sqlFetch($sql);
	$data[str_email] = str_replace(" ","",$data[str_email]);

	$datas[num_hit] = $data[num_hit]+1;
	$DB->updateQuery("TAB_QNA",$datas, " num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$id."' and str_wr_index  = '1'");
	$DB->commit();
	

	if($data[str_fl] == "0"){

	}else{
		if($data[str_passwd] == $_POST[passwd] || $_SESSION[ADMIN]){
			$tpl->assign(array('views'=>"y"));
		}else{
			WebApp::moveBack('정보가 일치하지 않습니다.');
			exit;
		}
	}


	 $sql = "select * from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_group = '".$id."' and str_wr_index  = '2' order by num_serial desc  ";
	$data2 = $DB -> sqlFetch($sql);

	//2011-09-06 종태 젠장젠장젠장젠장젠장젠장젠장젠장젠장
	if(!$data2){
		$tpl->assign(array('mode'=>"reply"));
	}else{
		$tpl->assign(array('mode'=>"view"));
	}

	$tpl->assign(array('data2'=>$data2));
	$tpl->assign(array('data1'=>$data));

	 break;
	}

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("qna/read.htm"));

?>