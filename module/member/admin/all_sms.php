<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-27
* 작성자: 김종태
* 설  명: 전체 SMS보내기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
$sql = "SELECT num_point FROM ".TAB_SMS_ORGAN." WHERE num_oid=$_OID";
        $num_point = $DB->sqlFetchOne($sql);


		$sql = "SELECT count(*) FROM ".TAB_MEMBER." WHERE num_oid=$_OID and str_handphone is not NULL and str_sms='Y'";
        $mem_count = $DB->sqlFetchOne($sql);

		

        $tpl->setLayout('admin');
		$tpl->define('CONTENT','/html/sms/send_simple.htm');
		$tpl->assign(array(
			'hp'=>$hp,
		 'num_point'  => $num_point,	
			'mem_count'=>$mem_count,
		));
		

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("member/admin/all_sms.htm"));
	
	 break;
	case "POST":

    $SMS = &WebApp::singleton('EmmaSMS');
	$sql = "select str_handphone from TAB_MEMBER where num_oid = '$_OID' and str_handphone is not NULL and str_sms='Y'";
	$hp2 = $DB -> sqlFetchAll($sql);


	for($ii=0; $ii<count($hp2); $ii++) {
	$hp .= $hp2[$ii][str_handphone]."|";
	}

	$hp = substr($hp,0,strlen($hp)-1);

	$hp = explode("|",$hp);



		switch($result_code = $SMS->send($hp, $str_se_phone, $str_msg, _OID, '일반발송')) {
                    case EMMASMS_ERR_INVALID_MOBILE :
                        WebApp::moveBack('SMS 발송 실패하였습니다.\n받는 번호중 잘못된 번호가 있습니다.\n확인하시고 다시한번 발송해보시기 바랍니다.');
                        break;
                    case EMMASMS_ERR_INVALID_PHONE :
                        WebApp::moveBack('SMS 발송 실패하였습니다.\n보내는 번호가 형식에 맞지 않습니다.\n확인하시고 다시한번 발송해보시기 바랍니다.');
                        break;
                    case EMMASMS_ERR_INVALID_MESSAGE :
                        WebApp::moveBack('SMS 발송 실패하였습니다.\n메시지가 없거나 보낼수 없는 메시지가 포함되어있습니다.\n확인하시고 다시한번 발송해보시기 바랍니다.');
                        break;
                    case EMMASMS_ERR_INVALID_DATE :
                        WebApp::moveBack('SMS 발송 실패하였습니다.\n예약날짜가 형식에 맞지 않습니다.\n확인하시고 다시한번 발송해보시기 바랍니다.');
                        break;
                    case EMMASMS_ERR_DB :
                        WebApp::moveBack('SMS 발송 실패하였습니다.\nDB에 오류가 발생하였습니다.\n다시 한번 시도해 보시고 본사로 연락주시기 바랍니다.');
                        break;
                    case EMMASMS_SEND_OK :
                        WebApp::moveBack('SMS 발송되었습니다.\n발송내역조회에서 확인하실수 있습니다.');
                        break;
                }

	 break;
	}

?>