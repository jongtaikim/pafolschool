<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	
	$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup
		
		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$_OID AND str_id = 'admin' and
		 chr_mtype = 'z' and ROWNUM = 1
		
		
		";
		
		
		
	$data = $DB->sqlFetch($sql);
	$tpl->assign($data);
		
		

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/passwd.htm"));
	
	 break;
	case "POST":

	
	$sql = "select str_passwd from TAB_MEMBER where num_oid=$_OID AND str_id = 'admin' and
		 chr_mtype = 'z' and ROWNUM = 1 ";
	$def_pass = $DB -> sqlFetchOne($sql);

	if($def_passwd != $def_pass ){
	WebApp::moveBack('������ȣ�� ���� �ʽ��ϴ�.');
	exit;
	}
	
	 $sql = "UPDATE ".TAB_MEMBER." SET str_passwd='$str_passwd' WHERE num_oid=$_OID AND str_id = 'admin' and
		 chr_mtype = 'z' and str_passwd = '$def_pass' and ROWNUM = 1  ";
	
	 if($DB->query($sql)){
	 $DB->commit();
	 WebApp::moveBack('������');
	 exit;
	 }else{
	 echo "sql ���� : ".$sql;
	 exit;
	 }
	
	
	

	 break;
	}

?>