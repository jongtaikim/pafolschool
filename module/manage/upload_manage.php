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

 $sql = "delete from TAB_UPLOAD_DATE where num_date < ".mktime()."";

 if($DB->query($sql)){
 $DB->commit();
 }

if($mode=="del" && $num_serial){
	 $sql = "delete from TAB_UPLOAD_DATE where num_serial = ".$num_serial."";
	 if($DB->query($sql)){
	 $DB->commit();
	 WebApp::moveBack('������');
	 exit;
	 }
}


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_UPLOAD_DATE a, TAB_ORGAN b where a.num_oid = b.num_oid ";
	$row = $DB -> sqlFetchAll($sql);
	

	$tpl->assign(array('LIST'=>$row));

	
	$sql = "select str_organ,num_oid from TAB_ORGAN  ";
	$row2 = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST2'=>$row2));
	
	
	

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("manage/upload_manage.htm"));
	
	 break;
	case "POST":
	
	$num_date = WebApp::mkday($num_date) ;
	
	$sql = "select count(*) from  TAB_UPLOAD_DATE where num_oid = $num_oid and num_date < ".mktime()." ";
	$incount = $DB -> sqlFetchOne($sql);

	
	if($incount < 1){

		$sql = "select max(num_serial)+1 from TAB_UPLOAD_DATE ";
		$max = $DB -> sqlFetchOne($sql);
		if(!$max) $max = 1;
		
		$num_size = $num_size * (1024*1024);

		$sql = "INSERT INTO ".TAB_UPLOAD_DATE." (
				num_oid, num_serial, num_size, num_date
				) VALUES (
				'$num_oid', '$max', '$num_size', '$num_date'
				) ";
		

				 if($DB->query($sql)){
				 $DB->commit();
				 WebApp::moveBack('�߰���');
				 exit;
				 }else{
				 echo "sql ���� : ".$sql;
				 exit;
				 }				
				
	}else{
	WebApp::moveBack('�̹� �������� �����Ͱ� �ֽ��ϴ�.');
	 
	}

	 break;
	}

?>