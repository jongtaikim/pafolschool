<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 회원가입폼 설정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":

	//$_member_type = WebApp::getConf('member_type');
	if(!$_member_type){
		$_member_type = WebApp::get('member',array('key'=>'member_types'));
	}
	$tpl->assign($_member_type);


	$sql = "SELECT num_join_point FROM ".TAB_ORGAN." WHERE num_oid=$_OID";
    $num_join_point = $DB->sqlFetchOnel($sql);
	$tpl->assign(array('num_join_point'=>$num_join_point,'MTYPES'=>$_member_type));
	
	
	$tpl->assign($_MEMBER);

	$tpl->define("CONTENT", Display::getTemplate("member/admin/setup.htm"));
	break;
	case "POST":
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
           
     
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->delSection("member");
			foreach( $_REQUEST as $val => $value )
			{
			if($val == "end")  break;
			if($value !="") {
			$INI->setVar($val,$value,"member");		
			}
			
			} 

		
					$sql = "update TAB_ORGAN set 

					num_join_point ='$num_join_point'

					where 

					num_oid = '$_OID'";

					$DB->query($sql);
					$DB->commit();




			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');		

	WebApp::moveBack('설정되었습니다.');
	 
	 break;
	}

?>