<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/login.php
* 작성일: 2009-09-25
* 작성자: 김종태
* 설   명: 호스트 통합로그인
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
$tpl->assign('MAIN_CONF',Display::getMainConf());
switch (REQUEST_METHOD) {
	case 'GET':
	
	$tpl->setLayout('@main');
	$tpl->define("CONTENT", Display::getTemplate("member/t_login.htm")); 

	break;
	case 'POST':

	
	$DB = &WebApp::singleton('DB');
    
	if(!$_POST['userid'] && !$_POST['passwd'] && !$_POST['oid'] && !$_POST['host_url']) {
      WebApp::moveBack();
    }
		
		$sql = "select count(*) from TAB_MEMBER where num_oid = '".$_POST['oid']."' and str_id ='".$_POST['userid']."' and  str_passwd ='".$_POST['passwd']."' ";
		$count_member = $DB -> sqlFetchOne($sql);
	
		
		
		if($count_member>0){		
			

		$sql = "INSERT INTO ".TAB_SESSION." (
				num_oid,str_id,str_pass,str_ip
				) VALUES (
				".$_POST['oid'].",'".$_POST['userid']."','".$_POST['passwd']."','".$_SERVER["REMOTE_ADDR"]."'
				) ";


		 if($DB->query($sql)){
			 $DB->commit();

			 
		 }
		   echo "<meta http-equiv='Refresh' Content=\"0; URL='http://".$_POST['host_url']."/member.ses_member'\">";
	
		} else {
			WebApp::moveBack('아이디 또는 비밀번호가 일치하지 않습니다.');
		}
		break;
}

?>