<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-08-20
* 작성자: 김종태
* 설  명: 회원
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$_MEMBER = WebApp::getConf('member');

$sql = "SELECT
		   b.str_name, 
		   b.str_id, 
		   b.str_passwd, 
		   b.num_jumin,
   		   b.str_email, 

		   a.chr_zip, 
		   a.str_nick, 
		   a.str_addr1, 
		   a.str_addr2, 
		   a.str_phone, 
		   a.str_handphone, 
		   a.str_introduct, 
		   a.num_fcode, 

		   a.num_auth, 
		   a.num_login_cnt
		

                FROM TAB_MEMBER a , TAB_MEMBER_INDEX b WHERE b.str_id='$userid' and b.str_passwd =  '$passwd' and a.num_jumin = b.num_jumin";


$data = $DB -> sqlFetch($sql);

$data[num_oid] =  $_OID;

if($_MEMBER[inj] == 'y') {	$inj = 0; }else{	$inj = 1; }
				
if(!$_MEMBER[mtype])   $_MEMBER[mtype] = 'n';
$data[chr_mtype] = $_MEMBER[mtype];
$data[num_auth] = $inj;
$data[str_ip] = getenv('REMOTE_ADDR');
$data[num_login_cnt] = 0;



if($DB-> insertQuery('TAB_MEMBER',$data)){
$DB->commit();

if($inj ==1) {
	

		$_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
		$_SESSION['NICKNAME'] = $data['str_nick'];
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];

echo "<script>opener.location.reload();</script>";
}
echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.modify'\">";


}else{


echo '<script>alert("아이디와 비밀번호를 다시한번 확인하세요.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.join_c'\">";

}


?>