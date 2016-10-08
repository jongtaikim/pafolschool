<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-05
* 작성자: 김종태
* 설   명: 일정등록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','calendar');



switch ($REQUEST_METHOD) {
	case "GET":


	$sql = "SELECT num_date, str_title, str_text, num_icon, num_hit, str_dday ".
		   "FROM ".TAB_CALENDAR." WHERE num_oid=$_OID AND num_serial=$id";
	$data = $DB->sqlFetch($sql);
	$data['content'] = $FH->set_content($data['str_text']);

	$file_list = $FH->get_files_info($id);
	$total_size = array_pop($file_list);

	$tpl->assign($data);
	$tpl->assign('FILE_LIST',$file_list);
	$tpl->assign('total_size',$total_size);



	$tpl->define("CONTENT", Display::getTemplate("calendar/admin/write.htm"));
	 $sdate = date('Y/m/d',strtotime($startdate));
     $prev_ym = date('Ym',strtotime($sdate.' -1 year'));
     $prev_y = substr($prev_ym,0,4);
     $prev_m = substr($prev_ym,4,2);
     $next_ym = date('Ym',strtotime($sdate.' +1 year'));
     $next_y = substr($next_ym,0,4);
     $next_m = substr($next_ym,4,2);
	
	 $tpl->assign(array(
            'skin'     => $skin,
            'ym'       => $ym,
            'id'       => $id,
            'year'     => $year,
            'month'    => $month,
            'prev_ym'  => $prev_ym,
            'prev_y'   => $prev_y,
            'prev_m'   => $prev_m,
            'next_ym'  => $next_ym,
            'next_y'   => $next_y,
            'next_m'   => $next_m,
			'f'   => $f
        ));
	
	 break;
	case "POST":
	
	$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.calendar.htm";
	unlink($cache_file);
	
	 if(!ereg('^([0-9]{4})[^0-9]?([0-9]{2})[^0-9]?([0-9]{2})?$',trim($_POST['num_date']),&$_date)) WebApp::moveBack('날짜가 형식에 맞지 않습니다.');
        $num_date = $_date[1].$_date[2].$_date[3];
        $str_title = $_POST['str_title'];
        $num_icon = $_POST['num_icon'];
        
		$content = $_POST['content'];
		if(!$content) $content = "<p></p>";



		$title = str_replace("'","''",$title);
       
		if(strlen($content) > 4000) WebApp::moveBack('내용이 너무 많습니다.');
		if(!$str_dday) $str_dday="N";

        if($id == 'write') {

		  $sql = "SELECT /*+ INDEX_DESC (".TAB_CALENDAR." ".PK_TAB_CALENDAR.") */ num_serial FROM ".TAB_CALENDAR." WHERE num_oid=$_OID";
           $id = $DB->sqlFetchOne($sql) + 1;

			$content = WebApp::ImgChaneDe($content, $id);

            $sql = "INSERT INTO ".TAB_CALENDAR." ( num_oid, num_serial, num_date, str_title, chr_html, str_text, num_icon, num_hit, dt_date, str_dday ) ".
                   "VALUES ( $_OID, $id, $num_date, '$str_title','Y','$content',$num_icon, 0, SYSDATE , '$str_dday')";
        } else {
	 		$content = WebApp::ImgChaneDe($content, $id);
    
			$sql = "UPDATE ".TAB_CALENDAR." SET ".
                   "num_date=$num_date, str_title='$str_title', str_text='$content',num_icon=$num_icon, str_dday='$str_dday' ".
                   "WHERE num_oid=$_OID AND num_serial=$id";
        }
        if($DB->query($sql)) {
            $DB->commit();

            // {{{ 업로드한 파일 처리
		
			/*//2009-07-01 종태 신규 업로드 프로세서
			$FH = &WebApp::singleton('FileHost');
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

			$FTP->mkdir($FH->file_dir);
			$FTP->chmod($FH->file_dir,777);
			$FTP->mkdir($FH->file_dir."/".date("Ym")."/");
			$FTP->chmod($FH->file_dir."/".date("Ym")."/",777);


			
			for($ii=1; $ii<11; $ii++) {
				uploadFile($ii);
			}*/


            // }}}


            WebApp::redirect('calendar.admin.list?ym='.$ym.'&f='.$f, '등록되었습니다.');
			exit;

        } else {
            $FH->rm_tmp_files($_POST['timestamp']);
            $FH->close();

            WebApp::moveBack('등록실패 : DB 오류입니다.');
        }


	 break;
	}

?>