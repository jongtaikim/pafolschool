<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-12-30
* 작성자: 김종태
* 설   명: 오라클 테이블 쿼리 mysql로 치환
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("sql_sync.htm"));
	
	 break;
	case "POST":
	
	//$sql = strtolower($sql);

	$sql = str_replace("VARCHAR2(4000 byte)","TEXT",$sql );
	$sql = str_replace("CHAR(","VARCHAR(",$sql );
	$sql = str_replace("VARCHAR2","VARCHAR",$sql );
	$sql = str_replace(" BYTE)",")",$sql );
	$sql = str_replace("NUMBER","INT",$sql );
	$sql = str_replace("CLOB","TEXT",$sql );
	$sql = str_replace("DEFAULT SYSDATE","",$sql );
	$sql = str_replace("SET DEFINE OFF;","",$sql );
	
	$sql = str_replace("COMMIT;","",$sql );
	




	
	
	$sql = str_replace("TO_DATE(","",$sql );
	$sql = str_replace(", 'MM/DD/YYYY HH24:MI:SS')","",$sql );
	

	echo "<xmp>".$sql."</xmp>";
	 break;
	}

?>