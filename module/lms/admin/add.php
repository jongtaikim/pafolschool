<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2011-07-11
* �ۼ���: ������
* ��   ��: ��������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$tpl->assign(array('sub_title'=>"ķ�� ���"));



switch ($REQUEST_METHOD) {
	case "GET":


	$sql = "select * from $table2 where num_oid = '$_OID' and   LENGTH(NUM_CCODE)=2 order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('title_LIST'=>$row));

	//2010-12-08 ���� ī�װ�
	$sql = "select * from ".$table." where num_oid = '$_OID'   and num_serial = '".$serial."' and num_ccode = '".$ccode."'  ";
	$data = $DB -> sqlFetch($sql);
	
	if($data){
	 $tpl->assign(array('sub_title'=>"ķ�� ����"));

	$data[start_date] = substr($data[num_start_date],0,4)."-".substr($data[num_start_date],4,2)."-".substr($data[num_start_date],6,2);
	$data[end_date] =  substr($data[num_end_date],0,4)."-".substr($data[num_end_date],4,2)."-".substr($data[num_end_date],6,2);

	$tpl->assign($data);
	}

	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/add.htm"));
	


	 break;
	case "POST":

	require_once _DOC_ROOT.'/module/file.php';

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/lms");
	$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/lms",777);

	//$types = $_POST[num_ccode];
	 
	 if(!$serial){
		
		if($st_num_serial){
			$sql = "select count(*) from $table where num_oid = '$_OID' and num_ccode = '$num_ccode' and num_serial = '".$st_num_serial."' ";

			$new_serial = $DB -> sqlFetchOne($sql);
			if(!$new_serial){
				$new_serial = $st_num_serial;
			}else{
				echo '<script>alert("�ش� ���α׷��� �̹� ���� ��� ��ȣ�Դϴ�.");history.go(-1)</script>';
				exit;
			}
		}else{
			$sql = "select max(num_serial)+1 from $table where num_oid = '$_OID' and num_ccode = '$num_ccode' ";
			$new_serial = $DB -> sqlFetchOne($sql);
			if(!$new_serial) $new_serial =1;
		}

			
		if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile�� form������ �̸� 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/lms/";  // �������� /�� �ٿ�����

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
			echo '<script>alert("�̹��� ���ϸ� ���ε� �����մϴ�."); </script>';
			exit;
		 }

		$fidx = $_POST[num_ccode]."-".$new_serial;
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("���ε忡 ���� �߽��ϴ�."); </script>';
			exit;
		}
		$file->upload();

		GDImageResize(_DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName."_100", '100', '100');

		GDImageResize(_DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName."_300", '300', '300');

		$datas[str_file] = $file->SaveName;

		}

		if($upfile2) {
			$file = new FileUpload("upfile2"); // datafile�� form������ �̸� 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/lms/";  // �������� /�� �ٿ�����

		//$file->file_mkdir(); 
		if(!$file->Ext("zip,arj,rar,gz,tgz,ace,Z,exe,pdf,doc,docx,hwp,xls,xlsx,ppt,pptx,bmp,jpg,jpeg,png,gif,txt,mp3,mp4,ogg,aiff,avi,mpg,mpeg,mov,rm,swf,flv,wmv,wma,ra,html,htm,alz,dat,ios,psd,xps"))  {
			echo '<script>alert("������ �ʴ� ������ ���ε� �õ��Ǿ����ϴ�."); </script>';
			exit;
		 }

		$fidx = "pds_".$_POST[num_ccode]."-".$new_serial;
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("���ε忡 ���� �߽��ϴ�."); </script>';
			exit;
		}
		$file->upload();

	
		$datas[str_pds] = $file->SaveName;

		}



		$datas[num_oid] = _OID;
		$datas[num_serial] = $new_serial;
		
		$datas[num_end_date] = str_replace("-","",$_POST[end_date]);
		$datas[num_start_date] = str_replace("-","",$_POST[start_date]);
		

		  foreach( $_POST as $val => $value )
		 {
			if(substr($val,0,4) == "num_" || substr($val,0,4) == "str_"){
				$datas[$val] = $value;
			}
		 }
		
		 $DB->insertQuery($table,$datas);

		 $DB->commit();

	 }else{
	 

	
			
		if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile�� form������ �̸� 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/lms/";  // �������� /�� �ٿ�����

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
			echo '<script>alert("�̹��� ���ϸ� ���ε� �����մϴ�."); </script>';
			exit;
		 }

		$fidx = $_POST[num_ccode]."-".$serial;
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("���ε忡 ���� �߽��ϴ�."); </script>';
			exit;
		}
		$file->upload();

		GDImageResize(_DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName."_100", '100', '100');

		GDImageResize(_DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName."_300", '300', '300');
		
		$datas[str_file] = $file->SaveName;
		}
		

		if($upfile2_del){
			unlink( _DOC_ROOT."/hosts/".HOST."/lms/".$upfile2_del);
			$datas[str_pds] ="";
		}
	
		
		if($upfile2) {
		$file = new FileUpload("upfile2"); // datafile�� form������ �̸� 
		$file->Path = _DOC_ROOT."/hosts/".HOST."/lms/";  // �������� /�� �ٿ�����

		//$file->file_mkdir(); 
		if(!$file->Ext("zip,arj,rar,gz,tgz,ace,Z,exe,pdf,doc,docx,hwp,xls,xlsx,ppt,pptx,bmp,jpg,jpeg,png,gif,txt,mp3,mp4,ogg,aiff,avi,mpg,mpeg,mov,rm,swf,flv,wmv,wma,ra,html,htm,alz,dat,ios,psd,xps"))  {
			echo '<script>alert("������ �ʴ� ������ ���ε� �õ��Ǿ����ϴ�."); </script>';
			exit;
		 }

		$fidx = "pds_".$_POST[num_ccode]."-".$new_serial;
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("���ε忡 ���� �߽��ϴ�."); </script>';
			exit;
		}
		$file->upload();

	
		$datas[str_pds] = $file->SaveName;

		}

		unset($datas[num_ccode]);

		$datas[num_end_date] = str_replace("-","",$_POST[end_date]);
		$datas[num_start_date] = str_replace("-","",$_POST[start_date]);

		  foreach( $_POST as $val => $value )
		 {
			if(substr($val,0,4) == "num_" || substr($val,0,4) == "str_"){
				$datas[$val] = $value;
			}
		 }
		 
		
		 $DB->updateQuery($table,$datas," num_oid = "._OID." and num_serial = '".$serial."' and num_ccode = '".$num_ccode."' ");
		 $DB->commit();



	 }

	echo '<script>alert("����Ǿ����ϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms.admin.list?ccode=$num_ccode'\">";
	exit;
	 

	 break;
	}

?>