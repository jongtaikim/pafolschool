<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$sql = 
	"DELETE FROM TAB_MAIN_BOARD WHERE NUM_OID=".$_OID." AND ".
		"STR_CODE='".$code."' AND "."NUM_SERIAL=".$id;
						   
		$DB->query($sql);
			if(!$DB->query($sql)) {
			WebApp::raiseError("SQL���� ���������� ������� ���߽��ϴ�.");
		}else{
		  $DB->commit();
						   
		
	   

		// ĳ������
		$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
		$FTP->delete(_DOC_ROOT.'/'.$cache_file);
		$FTP->delete(_DOC_ROOT.'/'.$cache_file2);
		$FTP->close();

	   
		echo '<script>alert("�����Ǿ����ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/news.list?mcode=$mcode&code=$code'\">";
		
		
		}

?>