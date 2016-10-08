<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$sql = 
	"DELETE FROM TAB_MAIN_BOARD WHERE NUM_OID=".$_OID." AND ".
		"STR_CODE='".$code."' AND "."NUM_SERIAL=".$id;
						   
		$DB->query($sql);
			if(!$DB->query($sql)) {
			WebApp::raiseError("SQL문이 정상적으로 실행되지 못했습니다.");
		}else{
		  $DB->commit();
						   
		
	   

		// 캐쉬삭제
		$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
		$FTP->delete(_DOC_ROOT.'/'.$cache_file);
		$FTP->delete(_DOC_ROOT.'/'.$cache_file2);
		$FTP->close();

	   
		echo '<script>alert("삭제되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/news.list?mcode=$mcode&code=$code'\">";
		
		
		}

?>