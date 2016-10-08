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


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$row));
	

	$sql = "select * from TAB_TACH where num_oid = '$_OID' and num_serial = '".$serial."'";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);
	
		

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/tach_add.htm"));
	
	 break;
	case "POST":

	require_once _DOC_ROOT.'/module/file.php';

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/tach");
	$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/tach",777);

	$datas[num_oid] = _OID;
	$new_serial = WebApp::maxSerial("TAB_TACH",'num_serial' );

	$datas[num_serial] = $new_serial;
	foreach( $_POST as $val => $value ){
		if(strstr($val,"num_") || strstr($val,"str_")){
			$datas[$val] = $value;
		}
	}

	if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/tach/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
			echo '<script>alert("이미지 파일만 업로드 가능합니다."); </script>';
			exit;
		 }

		if($serial ){
		$fidx = $serial;
		}else{
		$fidx = $new_serial;
		}
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("업로드에 실패 했습니다."); </script>';
			exit;
		}
		$file->upload();

		$file->Resize_sum('145', '161');

		//GDImageResize(_DOC_ROOT."/hosts/".HOST."/tach/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName."_300", '300', '300');

		$datas[str_file] = $file->SaveName;

		}

	if($serial){
	unset($datas[num_serial]);
	$DB->updateQuery("TAB_TACH",$datas," num_serial = '".$serial."' ");
	$DB->commit();
	
	}else{
	$DB->insertQuery("TAB_TACH",$datas);
	$DB->commit();

	}
	 
	echo '<script>alert("저장되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms.admin.tach'\">";
	
	 break;
	}

?>