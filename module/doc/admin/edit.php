<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: edit.php
* 작성일: 2005-03-31
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

$mcode = $_REQUEST['mcode'];

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$filepath = 'hosts/'.$HOST.'/doc/'.$mcode.'.msg';
$filepath2 = 'hosts/'.$HOST.'/doc/'.$mcode.'.css';
$filepath3 = 'hosts/'.$HOST.'/doc/image/'.$mcode.'/';

require_once _DOC_ROOT.'/module/file.php';

switch($REQUEST_METHOD) {
	case "GET":
	
	
		$msg = WebApp_Message::fromFile($filepath);
		$data['content'] = $FH->set_content($msg->__toString());
		
		$data['title_decorator'] = $msg->header['Title-Decorator'];
		if ($data['title_decorator'] == 'str') $data['title'] = $msg->header['Title'];
		$data['title'] = $DB->sqlFetchOne("SELECT str_title FROM TAB_MENU WHERE num_oid="._OID." AND num_mcode={$mcode}");
		if (!$data['title_decorator']) $data['title_decorator'] = 'str';
		if ($data['title_decorator'] == 'image') $data['title_image_url'] = $msg->header['Title'];
		$DOC_TITLE = "str:".$data['title'];
		$data['code'] = $data['mcode'] = $mcode;

		$data[css_text] = file_get_contents(_DOC_ROOT."/".$filepath2);

		
		
		foreach (glob('hosts/'.HOST."/doc/image/".$mcode."/*") as $img_files) {
			
		$img_files = array_pop(explode('/',$img_files));
            
            $skinlist[] = array(
                'filename' => $img_files,
              );
		
		}
	
		$tpl->assign(array('fLIST'=>$skinlist));
		
		

		if($no) {
			$tpl->setLayout('admin');
		}else{
			$tpl->setLayout('@sub');
		}

		$tpl->define('CONTENT','html/doc/admin/edit.htm');
		$tpl->assign($data);
	break;
	case "POST":


		$title = $DB->sqlFetchOne("SELECT str_title FROM TAB_MENU WHERE num_oid="._OID." AND num_mcode={$mcode}");
		$title_decorator = $_POST['title_decorator'];
		if (!$title_decorator) $title_decorator = 'str';


		
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/doc/image");
		$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/doc/image",777);
		$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/doc/image/".$mcode);
		$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/doc/image/".$mcode,777);

		if($_POST[upfile1]) {
		$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
		$file->Path = _DOC_ROOT."/hosts/".HOST."/doc/image/".$mcode."/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
		echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
		exit;
		 }
		$mk = mktime();

		$file->file_rename($mk); 
		if(!$file->upload()){
		echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
		exit;
		}
		$file->upload();
		
		$no = "y";
		}



		$content = WebApp::ImgChaneDe($content);
		
		//$content = str_replace(">&nbsp;<","><",$content);
		//2011-07-11 종태 검색엔진에 키워드 등록
		$sch_data[num_oid] = _OID;
		$sch_data[str_type] = "doc";
		$sch_data[str_title] = $title;
		$sch_data[str_url] = "/doc.view?mcode=".$mcode;
		$sch_data[str_text] = strip_tags($content);
		$sch_data[num_date] = date("Ymd");
		$sch_data[num_hit] = 0;
		
		$sch_data['str_location'] = 
		 $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".substr($mcode,0,-2))." >".$DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".$mcode);

		$DB->insertQuery("TAB_SCH",$sch_data);
		$DB->commit();

		//2011-07-11 종태 검색엔진에 키워드 등록
		$str_urls ="/doc.view?mcode=".$mcode;
		$sch_datas[str_title] = $title;
		$sch_datas[str_text] = strip_tags($content);
		$sch_datas[num_date] = date("Ymd");
		$sch_datas['str_location'] = $sch_data['str_location'];
		
		$DB->updateQuery("TAB_SCH",$sch_datas, " num_oid = '"._OID."'  and str_url = '".$str_urls."' ");
		$DB->commit();
	

        $header = array(
            'Content-Type' => 'text/html',
            'Content-Encoding' => 'euc-kr',
            'Title' => $title,
            'Title-Decorator' => $title_decorator
        );	
		$msg = new WebApp_Message($header,$content);
	
		
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->check_dir('hosts/'.HOST.'/doc','hosts/'.HOST);
		$FTP->put_string($msg->build(), _DOC_ROOT.'/'.$filepath);
		$FTP->put_string($css_text, _DOC_ROOT.'/'.$filepath2);
		$FTP->close();
		
		WebApp::log_txt(date('Y-m-d H:i:s')."에 ".$_SESSION[NAME]."(".$_SERVER["REMOTE_ADDR"].")"."에 의해서 문서를 수정됨\n","doc.".date("Y").".log.txt");
	

if(!$no){
	echo '<script>alert("수정되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/doc.view?mcode=".$mcode."&cate=".$cate."'\">";
	
}else{
	WebApp::moveBack('저장되었습니다.');
}
		
	break;
}
?>
