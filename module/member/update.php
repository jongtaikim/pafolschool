<?
/***********************************
*  lms 과목 카테고리 
*  작성자 : 김종태
**********************************/



$DB = &WebApp::singleton("DB");
$table = "TAB_BOOK_LIST"; //사용할 테이블 명


include "fileupload.inc";




switch ($mode) {
	case "juminchk":

$jumin = $jumin1."-".$jumin2;

	$sql = 
			"select count(num_jumin) from TAB_MEMBER where num_oid = ".$_OID." and num_jumin = '$jumin' 	";


$juminchk = $DB->sqlFetchOne($sql);

if($juminchk > 0) {
	echo "Y";
}else{
	echo "N";
}



	break;



}
?>