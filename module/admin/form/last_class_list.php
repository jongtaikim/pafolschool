<?php
/****************************************************
	�ۼ� : Wes
	�뵵 : ���� �б� Ȩ�� ����Ʈ ���⿩��
	���� : 2008�� 03�� 04��
	������ & ���� ����		
*****************************************************/

include _DB_INFO;
include _DB_CLASS;
include _MODULE;

##	��� ����
$DB = &WebApp::singleton('DB');
$class_condition = "UseLastClassList";	// DB ���� �б�Ȩ�Ǹ���Ʈ ���� ����Ű
$check = $_GET['check'];

if($check == "checked")$num_check=0;
else  $num_check=1;

switch ($REQUEST_METHOD) {
	case "GET":
				
		$query = "  SELECT
			(SELECT count(*) from "._FORMATION_SET ." Where num_oid=$oid and num_year=".$school_year.") c_current,
			(select count(*) from "._FORMATION_SET ." Where num_oid=$oid and num_year=".$school_year."-1 ) c_last
				FROM Dual";	
		$countClass = $DB->sqlFetch($query);
		if($countClass['c_last'] >0){			
			$query = "
				merge into tab_school_config c
     				using DUAL
     					on (c.num_oid= $oid and c.str_option='".$class_condition."')
     				when matched then 
     					update set c.num_use = $num_check
     				when Not Matched Then
     					insert (c.num_oid, c.str_option,c.num_use) values ($oid, '".$class_condition."',$num_check)
     				";     		     				
     			$DB->sqlQuery($query);
			if(!$DB->error) $DB->commit();
		}
	
	case "POST":
		break;		
}

ReturnUrl("?act=admin.form.main");

?>
                                                 