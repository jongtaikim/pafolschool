<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/admin/view.php
* 작성일: 2008-08-18
* 작성자: 김종태
* 설  명: 회원정보
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT
		   *


                FROM TAB_MEMBER  WHERE num_oid=$_OID AND str_id='$str_id' ";
        


		if(!$data = $DB->sqlFetch($sql)) {
       
		WebApp::alert('데이타가 존재하지 않습니다.');
		WebApp::moveBack();
			
        }
        $data['id'] = $str_id;
        $mem_types = WebApp::get('member',array('key'=>'member_types'));
        $data['mtype'] = $mem_types[$data['chr_mtype']];
		
		classList();


        if($data['str_photo']) $data['photo_url'] = 'hosts/'.HOST.'/files/member/'.$data['str_photo'];
		

		$jumin = explode("-",$data[num_jumin]);
		$data[jumin1] = $jumin[0];
		$data[jumin2] = $jumin[1];
		$data[jumin2] = substr($data[jumin2],0,2);
		
		$tel = explode("-",$data[str_handphone]);
		$data[tel1] = $tel[0];
		$data[tel2] = $tel[1];
		$data[tel3] = $tel[2];

		$tel = explode("-",$data[str_phone]);
		$data[tel11] = $tel[0];
		$data[tel22] = $tel[1];
		$data[tel33] = $tel[2];

		$data[birthday1] = substr($data[num_birthday],0,4);
		$data[birthday2] = substr($data[num_birthday],4,2);
		$data[birthday3] = substr($data[num_birthday],6,2);

		$mtypes = WebApp::get('member',array('key'=>'member_types'));

		$tpl->assign(array('mtypes'=>$mtypes));
		
		

        $tpl->define('CONTENT','html/member/admin/view.htm');
        $tpl->assign($data);
	break;
	case "POST":

$jumin_num = $jumin1."-".$jumin2;

/*
$sql = "update TAB_MEMBER_INDEX set 

str_passwd = '$str_passwd',
str_name = '$str_name',

chr_zip = '$str_zipcode',
str_addr1 = '$str_addr1',
str_addr2 = '$str_addr2',
str_phone = '".$tel11."-".$tel22."-".$tel33."', 
str_handphone = '".$tel1."-".$tel2."-".$tel3."' 

where 

str_id ='$str_id' and num_jumin = '".$num_jumin."' ";

$DB->query($sql);
$DB->commit();
*/

if($str_passwd) {
$pwsql = "str_passwd = '$str_passwd',";	
}

$sql = "update TAB_MEMBER set 


$pwsql

str_name = '$str_name',
str_nick = '$str_nick',


str_email = '$str_email',
num_fcode = '$num_fcode',
str_job = '$str_job',
str_voll = '$str_voll',
chr_zip = '$str_zipcode',
str_addr1 = '$str_addr1',
str_addr2 = '$str_addr2',
str_introduct = '$str_introduct',
chr_mtype = '$chr_mtype',
num_point_total = '$num_point_total',

str_phone = '".$tel11."-".$tel22."-".$tel33."', 
str_handphone = '".$tel1."-".$tel2."-".$tel3."' ,

str_plus1 = '".$str_plus1."',
str_plus2 = '".$str_plus2."',
str_plus3 = '".$str_plus3."',
str_plus4 = '".$str_plus4."',
str_plus5 = '".$str_plus5."'


where 

num_oid = '$_OID' and str_id ='$str_id' ";

$DB->query($sql);
$DB->commit();


if($num_fcode_def != $num_fcode){
 $sql = "UPDATE ".TAB_PARTY_MEMBER." SET num_pcode=$num_fcode, str_mtype='u' WHERE num_oid=$_OID and str_id = 'str_id' and num_pcode = '$num_fcode' ";

 if($DB->query($sql)){
 $DB->commit();


 }else{
 echo "sql 에러 : ".$sql;
 exit;
 }

}
			
echo '<script>alert("저장하였습니다.");</script>';
WebApp::moveBack();

	break;
}
?>