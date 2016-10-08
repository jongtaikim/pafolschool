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
	
	$sql = "select * from TAB_MAIN_VIS where num_oid = '$_OID' and num_serial = 1 ";
	$vis = $DB -> sqlFetch($sql);
	$tpl->assign(array('vis1'=>$vis));

	$sql = "select * from TAB_MAIN_VIS where num_oid = '$_OID' and num_serial = 2 ";
	$vis = $DB -> sqlFetch($sql);
	$tpl->assign(array('vis2'=>$vis));

	$sql = "select * from TAB_MAIN_VIS where num_oid = '$_OID' and num_serial = 3 ";
	$vis = $DB -> sqlFetch($sql);
	$tpl->assign(array('vis3'=>$vis));

	$sql = "select * from TAB_MAIN_VIS where num_oid = '$_OID' and num_serial = 4 ";
	$vis = $DB -> sqlFetch($sql);
	$tpl->assign(array('vis4'=>$vis));

	$sql = "select * from TAB_MAIN_VIS where num_oid = '$_OID' and num_serial = 5 ";
	$vis = $DB -> sqlFetch($sql);
	$tpl->assign(array('vis5'=>$vis));
	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vis/admin/list.htm"));
	
	 break;
	case "POST":
	
	include 'module/file.php';
	
	
	for($ii=1; $ii<6; $ii++) {
		
	$file_names = "upfile".$ii;
	
		if($$file_names) {
		$file = new FileUpload($file_names); // datafile은 form에서의 이름 
		$file->Path = _DOC_ROOT."/hosts/".HOST."/vis/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("jpg"))  {
			echo '<script>alert("jpg 파일만 업로드 가능합니다."); </script>';
			exit;
		 }

		$fidx = mktime()."_".$ii;
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("업로드에 실패 했습니다."); </script>';
			exit;
		}
		$file->upload();

		GDImageResize(_DOC_ROOT."/hosts/".HOST."/vis/".$file->SaveName, _DOC_ROOT."/hosts/".HOST."/lms/".$file->SaveName, '415', '592');

		$str_file[$ii][file_name] = $file->SaveName;

		}
	
	}


	inFile(1, $str_file[1][file_name],$str_alt1,$str_link1,$str_view1);
	inFile(2, $str_file[2][file_name],$str_alt2,$str_link2,$str_view2);
	inFile(3,$str_file[3][file_name], $str_alt3,$str_link3,$str_view3);
	inFile(4,$str_file[4][file_name], $str_alt4,$str_link4,$str_view4);
	inFile(5,$str_file[5][file_name], $str_alt5,$str_link5,$str_view5);


	WebApp::moveBack();
	
	

	 break;
	}

	function inFile($idx , $str_file, $str_alt, $str_link,$str_view){
		global $DB;

		$sql = "INSERT INTO ".TAB_MAIN_VIS." (
				num_oid,  num_serial , str_alt ,str_file, str_link, str_view
				) VALUES (
				'"._OID."', $idx, '$str_alt', '$str_file','$str_link','$str_view'
				) ";
		
		
			 if($DB->query($sql)){
				 $DB->commit();
			 }else{
				if($str_file){
					$psql = " ,str_file = '$str_file' ";
				}
				$sql = "UPDATE  ".TAB_MAIN_VIS." set  str_alt = '$str_alt',  str_link = '$str_link', str_view = '$str_view'  $psql
				where num_oid = '"._OID."' and num_serial = $idx
				";
				$DB->query($sql);
				 $DB->commit();
			 }				
	}

?>