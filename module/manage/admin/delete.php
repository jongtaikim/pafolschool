<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-12-09
* �ۼ���: ������
* ��   ��: ȣ��Ʈ ���� ���
*****************************************************************
* 
*/


$delback = array('20250','20252','0','2','3','20278','20277');
$delbackhost = array(
					
					'yeseasy.ezsol.kr',
					'stockstory.ezsol.kr',
					'main.hkedu.co.kr',
					'now17.ezsol.kr',
					'ultraweb.ezsol.kr',
					'help.ezsol.kr',
					'educock.ezsol.kr'
					);

for($ii=0; $ii<count($delback); $ii++) {
	if($delback[$ii] == $oids) {
		WebApp::moveBack('���� ���� ó���� ȣ��Ʈ�Դϴ�.');
		exit;
	}
}



for($ii=0; $ii<count($delbackhost); $ii++) {
	if($delbackhost[$ii] == $host) {
		WebApp::moveBack('���� ���� ó���� ȣ��Ʈ�Դϴ�.');
		exit;
	}
}


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$DB = &WebApp::singleton('DB');

//2008-12-09 ���� ���̺� ����
for($ii=0; $ii<count($table); $ii++) {
	 $sql = "delete from ".$table[$ii]." WHERE num_oid=$oids";
	 //echo $sql;
	 $DB->query($sql);
	 $DB->commit();
	
}

 $sql = "delete from TAB_ORGAN WHERE num_oid=$oids";
 //echo $sql;
	 $DB->query($sql);
	 $DB->commit();
	


/** 
	* ���丮�� �����մϴ�.
	* $recursive�� true �ϰ�� ���� ���丮�� ���ϱ��� ��� ����ϴ�.
	*
	* @param string $dir ������ ���丮��
	* @param $recursive �������丮���� ��������� ������ ������ ���� (defualt: false)
	* @return boolean ���� ��������
	
	function rmdir($dir,$recursive=false) {*/


	$del_dir =_DOC_ROOT."/hosts/{$host}/";

		if (is_dir($del_dir)) { 
			system("rm -rf $del_dir");
		}


	echo '<script>alert("�����Ǿ����ϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.organ'\">";






?>