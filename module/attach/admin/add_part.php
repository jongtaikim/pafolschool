<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/attach/admin/add_part.php
* 작성일: 2006-05-08
* 작성자: 이범민
* 설  명: 레이아웃관리에서 컨텐츠 추가
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','part');


switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/attach/admin/add_part.htm');
		
		$sql = "SELECT  max(num_serial) ".
		   "FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID and num_css = '"._CSS."' ";
			$id = $DB->sqlFetchOne($sql) + 1;
			if(!$id) $id = 1;

        $tpl->assign('str_title','추가 HTML'.$id);
	break;
	case "POST":
        $name = 'part_'.$id;
        $str_title = $_POST['str_title'];
        //$content = $FH->get_content($_POST['content']);


        $THEME_CONF = Display::getThemeConf();
        $attach_file = 'attach/attach.part_'.$id.'.msg';
        foreach($THEME_CONF['attach']['layouts'] as $_layout => $_layout_name) {
            $sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (num_oid,str_layout,str_name,str_layer,num_step,str_width,num_css) ".
                   "VALUES ($_OID,'$_layout','$name','NONE',1,'100%','"._CSS."')";
            if(!$DB->query($sql)) {
                $FH->rm_tmp_files($_POST['timestamp']);
                $FH->close();
			   // WebApp::moveBack('저장 실패하였습니다.');
            }
        }
		

		$content = WebApp::ImgChaneDe($content);

		
		$content = str_replace(">&nbsp;</TD","><img src=\"/b.gif\" width=\"1\" height=\"1\"></TD",$content);
        $content = str_replace("'","''",$content);
		list($str1,$str2,$str3) = WebApp::content_split($content);	// 앞에서부터 3개 이하는 버림!
		
			$sql = "SELECT  max(num_serial) ".
		   "FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID and num_css = '"._CSS."' ";
			$id = $DB->sqlFetchOne($sql) + 1;
			if(!$id) $id = 1;
			$name = 'part_'.$id;

			$sql = "INSERT INTO ".TAB_ATTACH_PART." (num_oid,num_serial,str_name,str_title,str_text1,str_text2,str_text3,num_css) "."VALUES ($_OID,$id,'$name','$str_title','$str1','$str2','$str3','"._CSS."')";

			if(!$DB->query($sql)) {
				$FH->rm_tmp_files($_POST['timestamp']);
				$FH->close();
				
				echo $sql;
				//WebApp::moveBack('저장 실패하였습니다.');
			}else{
		    $DB->commit();
			}
			
     
		$_SESSION['get_thumb_filename'] = "";
		unset($_SESSION['get_thumb_filename']);
     
		
        $msg = $content;

        $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        $FTP->put_string($msg,_DOC_ROOT."/hosts/".HOST."/attach/attach.".$name.".msg");

        $attach_file_arr = array();
        foreach($THEME_CONF['attach']['layouts'] as $_layout => $_layout_name) $attach_file_arr[] = "'".$_layout."'=>'".$attach_file."'";
        $attach_file_str = 'array('.implode(',',$attach_file_arr).')';
        

	       
        $attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
			
		$INI = &WebApp::singleton('IniFile',$attach_conf_file);
        $INI->setVar('name',$name,$name);
        $INI->setVar('title',$str_title,$name);
        $INI->setVar('modules',$name,$name);
        $INI->setVar('file',$attach_file_str,$name);
        $INI->setVar('avail_width',"array('main'=>array('635'),'sub'=>array('635'))",$name);
		$INI->setVar('avail_height',"100",$name);
        $INI->setVar('avail_layer',"array('main'=>array('MAIN','LEFT','RIGHT','TOP','FOOT','MAIN_TOP','MAIN_FOOT'),'sub'=>array('MAIN','LEFT','RIGHT','TOP','FOOT','MAIN_TOP','MAIN_FOOT'))",$name);
        $INI->setVar('attachable',1,$name);
        $INI->setVar('removable',1,$name);
        $FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);	
		
	
		

		$sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (num_oid,str_layout,str_name,str_layer,num_step,str_width,num_css) ".
                   "VALUES ($_OID,'$layout','$name','NONE',1,'100%','".$_oid."')";
        $DB->query($sql);
        $DB->commit();

        

		

	////////여기까지 이미지 처리 끝

        echo '<script type="text/javascript">
				parent.appendPart("'.$id.'","'.$str_title.'");
				parent.closewPop(2);
				</script>';

        exit;
	break;
}
?>