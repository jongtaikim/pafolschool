<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-27
* �ۼ���: ������
* ��   ��: ������ ī����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$rrref = str_replace("www.","",$_SERVER[HTTP_REFERER]);
if(!strstr("http://ultraweb.ezsol.kr/board.list?mcode=1016",$_SERVER[HTTP_HOST])) {
echo "111";
}
exit;



if(!strstr($_SERVER[HTTP_REFERER],$_SERVER[HTTP_HOST])) {
	

$sql = "INSERT INTO ".TAB_IP_COUNTER." 
			(
			num_oid,
			str_ip,
			num_date,
			str_http_referer
			
			) VALUES (
					
			$_OID,
			'".$_SERVER[REMOTE_ADDR]."',
			".mktime().",
			'".$_SERVER[HTTP_REFERER]."'

			) ";

			$DB->query($sql);
			$DB->commit();

}

?>