<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-02
* �ۼ���: ������
* ��   ��: ī��⺻����
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/admin/manage.htm');
	break;

	case "POST":

if(mktime() >$cafe_data[num_update]) {
$mk = mktime() + (86400*180);
$usql   = ",num_ccode='$num_ccode' ,num_update = ".$mk." ";
}

	
	
	$sql = "UPDATE TAB_PARTY SET 
					str_memo='$str_memo', str_join_msg='$str_join_msg', str_mtype='$mtype', 
					str_text1='$str_text1', str_text2='$str_text2', str_text3='$str_text3', str_text4='$str_text4', str_text5='$str_text5' $usql
					WHERE num_oid=$_OID and num_pcode=$pcode";
		$DB->query($sql);

		if($DB->commit()){
			WebApp::moveBack('����Ǿ����ϴ�.');
		}else{
			WebApp::moveBack('Error!!!');
		}

	break;
}
?>