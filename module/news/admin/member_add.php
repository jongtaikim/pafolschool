<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2011-07-11
* �ۼ���: ������
* ��   ��: ��������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$tpl->assign(array('sub_title'=>"�������� ȸ�� �߰�"));
$table = "TAB_NEWS_MEMBER";


switch ($REQUEST_METHOD) {
	case "GET":


	//2010-12-08 ���� ī�װ�
	$sql = "select * from ".$table." where num_oid = '$_OID'   and num_serial = '".$serial."' ";
	$data = $DB -> sqlFetch($sql);
	
	if($data){
	 $tpl->assign(array('sub_title'=>"ȸ������ ����"));

	$emails = explode("@",$data[str_email]);
	$data[email] = $emails[0];
	$data[email2] = $emails[1];
		

	$tpl->assign($data);
	}

	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("news/admin/member_add.htm"));
	


	 break;
	case "POST":

	$_POST[str_email] = $_POST[email]."@".$_POST[email2];
	 
	 if(!$serial){
		
		$sql = "select max(num_serial)+1 from ".$table." where num_oid = '$_OID' ";
		$new_serial = $DB -> sqlFetchOne($sql);
		if(!$new_serial) $new_serial =1;

			
	

		$datas[num_oid] = _OID;
		$datas[num_serial] = $new_serial;

		  foreach( $_POST as $val => $value )
		 {
			if(substr($val,0,4) == "num_" || substr($val,0,4) == "str_"){
				$datas[$val] = $value;
			}
		 }

		 $DB->insertQuery($table,$datas);
		 $DB->commit();

	 }else{
		
		  foreach( $_POST as $val => $value )
		 {
			if(substr($val,0,4) == "num_" || substr($val,0,4) == "str_"){
				$datas[$val] = $value;
			}
		 }
			
	
		 $DB->updateQuery($table,$datas," num_oid = "._OID." and num_serial = '".$serial."'");
		 $DB->commit();



	 }

	echo '<script>alert("����Ǿ����ϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/news.admin.member_list?PageNum=".$_SESSION[_pn]."'\">";
	exit;
	 

	 break;
	}

?>