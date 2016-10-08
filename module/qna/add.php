<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-09-02
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	
	$sql = "select * from TAB_QNA where num_oid = '$_OID' and num_mcode = '".$mcode."' and num_serial = '".$serial."'";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);
	

	if($mode=="reply" && $group){
	
	if($id){
		$sql = "select * from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$id."' and str_wr_index  = '2' order by num_serial desc  ";
		$data = $DB -> sqlFetch($sql);
		
	}else{

	$sql = "select * from TAB_QNA where num_oid = '$_OID' and num_mcode = '".$mcode."' and num_serial = '".$group."'";
	$data = $DB -> sqlFetch($sql);
	$data[str_title] = "Re : ".$data[str_title];
	$data[str_name] = _ONAME;
	$data[str_phone] = _OPHONE;
	$data[str_email] = _EMAIL;
	$data[str_text] = "";

	}
	$tpl->assign($data);

	}
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("qna/add.htm"));
	
	 break;
	case "POST":

	include 'module/file.php';
	



	$datas[num_oid] = _OID;
	foreach( $_POST as $val => $value ){
		if(strstr($val,"num_") || strstr($val,"str_")){
			$datas[$val] = $value;
		}
	}
	
	$datas[num_serial] = WebApp::maxSerial("TAB_QNA","num_serial"," and num_mcode = '".$mcode."' ");

	if(!$mode && !$group){

		
		
		$datas[num_group] = $datas[num_serial];
		$datas[num_mcode] = $mcode;
		$datas[str_st] = 0;
		$datas[str_wr_level] = 1;
		$datas[str_wr_index] = 1;
		$datas[str_ip] = $_SERVER[REMOTE_ADDR];
		$datas[str_date] = mktime();

	

	
	}else{


		
		$datas[num_group] = $group;
		$datas[num_mcode] = $mcode;
		$datas[str_st] = 2;
		$datass[str_st] = 2;
		$datas[str_wr_level] = 2;
		$datas[str_wr_index] = 2;
		$datas[str_ip] = $_SERVER[REMOTE_ADDR];
		$datas[str_date] = mktime();

		
		$DB->updateQuery("TAB_QNA",$datass," num_oid = '"._OID."' and num_group = '".$group."' ");
		$DB->commit();
	
	}


	if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/qna/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("zip,arj,rar,gz,tgz,ace,Z,exe,pdf,doc,docx,hwp,xls,xlsx,ppt,pptx,bmp,jpg,jpeg,png,gif,txt,mp3,mp4,ogg,aiff,avi,mpg,mpeg,mov,rm,swf,flv,wmv,wma,ra,html,htm,alz,dat,ios,psd,xps"))  {
			echo '<script>alert("'.$file->Name.' 은 업로드가 허용되지 않는 파일입니다.");</script>';
			exit;
		 }

		$fidx = mktime()."-".$datas[num_serial];
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("업로드에 실패 했습니다."); </script>';
			exit;
		}
		$file->upload();


		$datas[str_file] = $file->SaveName;

		}


	if($serial){
	
	
	$sql = "select * from TAB_QNA where num_oid = '$_OID' and num_mcode = '".$mcode."' and num_serial = '".$serial."'";
	$data = $DB -> sqlFetch($sql);

	if($data[str_passwd] != $_POST[str_passwd] || !$_SESSION[ADMIN]){
		WebApp::moveBack('비밀번호가 틀립니다.');
		exit;
	}
	

	unset($datas[num_oid]);
	unset($datas[num_group]);
	unset($datas[num_serial]);
	unset($datas[str_wr_index]);
	unset($datas[str_passwd]);

	$DB->updateQuery("TAB_QNA",$datas," num_oid = '"._OID."' and num_serial = '".$serial."' ");
	$DB->commit();

	}else{

	$DB->insertQuery("TAB_QNA",$datas);
	$DB->commit();

	 
	echo '<script>alert("작성되었습니다.");</script>';
	}
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/qna.list?mcode=".$mcode."&cate=".$cate."'\">";
	 
	
	 break;
	}

?>