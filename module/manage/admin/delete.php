<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-12-09
* 작성자: 김종태
* 설   명: 호스트 삭제 모듈
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
		WebApp::moveBack('삭제 방지 처리된 호스트입니다.');
		exit;
	}
}



for($ii=0; $ii<count($delbackhost); $ii++) {
	if($delbackhost[$ii] == $host) {
		WebApp::moveBack('삭제 방지 처리된 호스트입니다.');
		exit;
	}
}


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$DB = &WebApp::singleton('DB');

//2008-12-09 종태 테이블 삭제
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
	* 디렉토리를 삭제합니다.
	* $recursive가 true 일경우 하위 디렉토리와 파일까지 모두 지웁니다.
	*
	* @param string $dir 삭제할 디렉토리명
	* @param $recursive 하위디렉토리까지 재귀적으로 삭제할 것인지 여부 (defualt: false)
	* @return boolean 삭제 성공여부
	
	function rmdir($dir,$recursive=false) {*/


	$del_dir =_DOC_ROOT."/hosts/{$host}/";

		if (is_dir($del_dir)) { 
			system("rm -rf $del_dir");
		}


	echo '<script>alert("삭제되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.organ'\">";






?>