<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-10-27
* �ۼ���: ������
* ��  ��: ��ü SMS������
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



		switch($result_code = $SMS->send($hp, $str_se_phone, $str_msg, _OID, '�Ϲݹ߼�')) {
                    case EMMASMS_ERR_INVALID_MOBILE :
                        WebApp::moveBack('SMS �߼� �����Ͽ����ϴ�.\n�޴� ��ȣ�� �߸��� ��ȣ�� �ֽ��ϴ�.\nȮ���Ͻð� �ٽ��ѹ� �߼��غ��ñ� �ٶ��ϴ�.');
                        break;
                    case EMMASMS_ERR_INVALID_PHONE :
                        WebApp::moveBack('SMS �߼� �����Ͽ����ϴ�.\n������ ��ȣ�� ���Ŀ� ���� �ʽ��ϴ�.\nȮ���Ͻð� �ٽ��ѹ� �߼��غ��ñ� �ٶ��ϴ�.');
                        break;
                    case EMMASMS_ERR_INVALID_MESSAGE :
                        WebApp::moveBack('SMS �߼� �����Ͽ����ϴ�.\n�޽����� ���ų� ������ ���� �޽����� ���ԵǾ��ֽ��ϴ�.\nȮ���Ͻð� �ٽ��ѹ� �߼��غ��ñ� �ٶ��ϴ�.');
                        break;
                    case EMMASMS_ERR_INVALID_DATE :
                        WebApp::moveBack('SMS �߼� �����Ͽ����ϴ�.\n���೯¥�� ���Ŀ� ���� �ʽ��ϴ�.\nȮ���Ͻð� �ٽ��ѹ� �߼��غ��ñ� �ٶ��ϴ�.');
                        break;
                    case EMMASMS_ERR_DB :
                        WebApp::moveBack('SMS �߼� �����Ͽ����ϴ�.\nDB�� ������ �߻��Ͽ����ϴ�.\n�ٽ� �ѹ� �õ��� ���ð� ����� �����ֽñ� �ٶ��ϴ�.');
                        break;
                    case EMMASMS_SEND_OK :
                        WebApp::moveBack('SMS �߼۵Ǿ����ϴ�.\n�߼۳�����ȸ���� Ȯ���ϽǼ� �ֽ��ϴ�.');
                        break;
                }

	 break;
	}

?>