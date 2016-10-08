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

$sql = "select str_id, str_pass from TAB_SESSION where num_oid = "._OID." and str_ip = '".$_SERVER["REMOTE_ADDR"]."'  and ssid = '".$_GET[ssid]."'";
$data = $DB -> sqlFetch($sql);

$str_id = $data[str_id];

switch($REQUEST_METHOD) {
	case "GET":

		

        $sql = "SELECT
		   str_name, 
		   str_id, 
		   str_passwd, 
		   num_jumin,
   		   str_email, 
		   str_phone, 
		   str_handphone, 
		   chr_zip, 
		   str_addr1, 
		   str_addr2, 
		

		   chr_mtype, 
		   num_fcode, 
		   
		   str_introduct, 
		   str_photo, 
		   num_auth, 
		   num_login_cnt, 
		   str_ip, 
		   TO_CHAR(dt_date,'YYYYMMDD') dt_date, 
		   str_job, 
		   str_voll, 
		   str_group, 
		   str_state, 
		   num_grade, 
		   num_hid,
		   num_login_point,
		   num_board_point,
		   num_commint_point,
		   num_repaly_point,
		   str_plus1,
		   str_plus2,
		   str_plus3,
		   str_plus4,
		   str_plus5,
		   str_nick

           FROM TAB_MEMBER  WHERE num_oid=$_OID AND str_id='$str_id' ";


        if(!$data = $DB->sqlFetch($sql)) {
            WebApp::alert('데이타가 존재하지 않습니다.');
            WebApp::moveBack();
        }
        $data['id'] = $str_id;
        $mem_types = WebApp::get('member',array('key'=>'member_types'));
        $data['mtype'] = $mem_types[$data['chr_mtype']];
        if($data['num_fcode']) {
            $sql = "SELECT str_fname_full FROM ".TAB_CLASS_FORMATION." WHERE num_oid=$_OID AND num_fcode=".$data['num_fcode'];
            $data['fname_full'] = $DB->sqlFetchOne($sql);
        }
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

		$email = explode("@",$data[str_email]);
		$data[email1] = $email[0];
		$data[email2] = $email[1];
		

		if(!$mcode) $DOC_TITLE="str:회원정보수정";

		classList();

		$tpl->setLayout('admin_xhtml');
        $tpl->define('CONTENT',Display::getTemplate('member/modify.htm'));
        $tpl->assign($data);

	break;
	case "POST":

	$FH = &WebApp::singleton('FileHost');

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

	$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/files/member/");
	$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/files/member/",777);

	if($upfile1) {
	$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
	$file->Path = _DOC_ROOT."/hosts/".HOST."/files/member/";  // 마지막에 /꼭 붙여야함

	//$file->file_mkdir(); 
	if(!$file->Ext("gif,jpg,png"))  {
	echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
	exit;
	 }
	$mk = mktime();

	$file->file_rename($str_id); 
	if(!$file->upload()){
	//echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
	//exit;
	}
	$file->upload();
	GDImageResize(_DOC_ROOT."/hosts/".HOST."/files/member/".$file->SaveName , _DOC_ROOT."/hosts/".HOST."/files/member/".$file->SaveName."_100" , 80, 60);
	}



$str_email = $email1."@".$email2;


/*
$sql = "update TAB_MEMBER_INDEX set 

str_passwd = '$str_passwd',

str_email = '$str_email',

chr_zip = '$str_zipcode',
str_addr1 = '$str_addr1',
str_addr2 = '$str_addr2',
str_phone = '".$tel11."-".$tel22."-".$tel33."', 
str_handphone = '".$tel1."-".$tel2."-".$tel3."' 

where 

str_id ='$str_id' and num_jumin = '".$num_jumin."'";


$DB->query($sql);
$DB->commit();
*/

if($str_passwd){
$pwsql = " str_passwd = '$str_passwd',";
}


$sql = "update TAB_MEMBER set 

$pwsql

str_email = '$str_email',
str_nick = '$str_nick',
num_fcode = '$num_fcode',

chr_zip = '$str_zipcode',
str_addr1 = '$str_addr1',
str_addr2 = '$str_addr2',
str_introduct = '$str_introduct',

str_phone = '".$tel11."-".$tel22."-".$tel33."', 
str_handphone = '".$tel1."-".$tel2."-".$tel3."' ,

str_job = '$job',

str_plus1 = '$str_plus1',
str_plus2 = '$str_plus2',
str_plus3 = '$str_plus3',
str_plus4 = '$str_plus4',
str_plus5 = '$str_plus5'


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
echo "<meta http-equiv='Refresh' Content=\"0; URL='http://".$_SESSION[baseurl_]."/'\">";

  

	break;
}
?>