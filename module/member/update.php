<?
/***********************************
*  lms ���� ī�װ� 
*  �ۼ��� : ������
**********************************/



$DB = &WebApp::singleton("DB");
$table = "TAB_BOOK_LIST"; //����� ���̺� ��


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