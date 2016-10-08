<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-27
* 작성자: 김종태
* 설   명: 퀵메뉴관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$sql = "select * from TAB_QMENU where num_oid = "._OID." order by num_step asc";
$row = $DB -> sqlFetchAll($sql);

		if(count($row)<1) { //기본값이 없을시 생성

		$sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 1, '학급홈피','Class hompy', 'Y', '/class.list', 1) ";
		$DB->query($sql);

		$sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 2, '온라인교무실', 'Teachers`room','Y', 'javascript:intranet_url();', 2) ";
		$DB->query($sql);
		 
		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 3, '동아리', 'Club', 'Y','/party.list', 3) ";
		$DB->query($sql);

		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 4, '스쿨잼', 'SchoolZam','Y', 'http://www.schoolzem.com/', 4) ";
		$DB->query($sql);

		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 5, '전자도서관','Digital library', 'Y', '#', 5) ";
		$DB->query($sql);

		$DB->commit();

		$sql = "select * from TAB_QMENU where num_oid = "._OID." order by num_step asc ";
		$row = $DB -> sqlFetchAll($sql);
	
		}

switch ($REQUEST_METHOD) {
	case "GET":
	
	if($mode =="del") {
		 $sql = "delete from  TAB_QMENU WHERE num_oid=$_OID and num_serial = ".$serial."";
		 $DB->query($sql);
		 $DB->commit();
		 WebApp::moveBack();
	}


	$sql = "select * from TAB_QMENU where num_oid = $_OID order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);


	$tpl->assign(array('LIST'=>$row));
	
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("qmenu/admin/main.htm"));
	
	 break;
	case "POST":

		$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.qmenu.htm";
		unlink($cache_file);

		 switch ($mode) {
		case "list":
		
			for($ii=0; $ii<count($step); $ii++) {
				 $sql = "UPDATE ".TAB_QMENU." SET num_step=".$ii." WHERE num_oid=$_OID and num_serial = ".$step[$ii]."";
				 $DB->query($sql);
			}
		 		 $DB->commit();
		 break;
		 case "update":
	

		 if(!$num_view) $num_view = "Y";
		if($num_serial){

		 $sql = "UPDATE ".TAB_QMENU." SET 
		 str_text='$str_text', 
		 str_text2='$str_text2',
		 str_url='$str_url',
		 str_target='$str_target',
		 num_view = '$num_view'

		 WHERE num_oid=$_OID and num_serial = ".$num_serial."";
		$DB->query($sql);
	
		}else{
		 $sql = "select max(num_serial) from TAB_QMENU where num_oid = $_OID ";
		 $maxnum = $DB -> sqlFetchOne($sql)+1;

		 
		 
		$sql = "INSERT INTO ".TAB_QMENU." (	
		num_oid, num_serial, str_text, str_text2, str_url, num_view, str_target
		) VALUES (
		"._OID.", ".$maxnum.", '$str_text', '$str_text2', '$str_url', '$num_view', '$str_target'
		) ";
		
		$DB->query($sql);

		
		
		}


		 $DB->commit();
		 break;

		 case "use":

		  
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');		
        
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("qmenu_use",$qmenu_use);
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
		 break;
		}


	
	WebApp::moveBack('적용되었습니다.');
	
	 break;
	}

?>