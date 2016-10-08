<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: write.php
* 작성일: 2002-12-26
* 작성자: 거친마루
* 설  명: 게시판 글 새로 작성
*****************************************************************
* 
*/

if($_SESSION[nonBoard]){
	$PERM->apply('menu',$_SESSION[nonBoard],'w');
}else{
	$PERM->apply('menu',$mcode,'w');
}

$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
		$timestamp = date('U');
		
		
		switch ($_conf[chr_listtype]) {
			case "B":
			$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write.htm"));
			 break;
			case "G":
			$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write.htm"));
			 break;
 			case "D":
			$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write_d.htm"));
			 break;
  			case "W":
			$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write.htm"));
			 break;
			}

        
		$str_title = "";
		$tpl->assign(array('str_title'=>$str_title));
		
	

		//2009-03-18 현민 선생님들 공지랑 관리할 수 있는 관리 권한
		$env['admin'] = ($env['admin'] || ($_SESSION['CHR_MTYPE'] == 't'));

		$tpl->assign(array(
			'mcode'=>$mcode,
			'env'=>$env,
			'edit'=>$edit
		));
		
		$data['user_id'] = $_SESSION['USERID'];
		$data['name2'] = $_SESSION['NAME'];
		$data['e_mail'] = $_SESSION['E_MAIL'];
		$data['password'] = $_SESSION['PASSWORD'];
		$data['dt_date'] = date("Y-m-d",mktime());

		//2008-06-24 종태 카테고리 목록

		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row));



		// {{{ 업로드한 파일 처리
		$serial = $DB->sqlFetchOne("
					SELECT
						/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
							max(num_serial) + 1
					FROM
						$ARTICLE_TABLE
					WHERE
						 num_oid = '$_OID' and  num_mcode=$mcode 
				");

		if(!$serial) $serial = 1;



		$FH->delete_as_main($serial);


		/*		$sql = 'delete  '.
						'FROM '.TAB_FILES.' '.
						'WHERE '.
							'NUM_OID='.$_OID.' AND '.
							'STR_SECT=\'menu\' AND '.
							'STR_CODE=\''.$mcode.'\' AND '.
							'NUM_MAIN='.$serial;


					$DB->query($sql);
					$DB->commit();
		*/
		$tpl->assign($data);


		list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize();


		$tpl->assign(array(
			'num_disk'=>$num_disk,
			'num_upload_size'=>$num_upload_size,
			'db_num_size'=>$db_num_size,
			'use_size'=>$use_size,
			'maxfilesize'=>$maxfilesize,
			'str_category'=>$str_category,
		));


		include "gpin.php";


		break; 
	
	case "POST":


		//현민 TAB_CATEGORY 추가
		if($str_category_text && ($str_category_text != '일반')){
			$sql = "select count(*) from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode=$mcode and str_category='$str_category_text'";
			$cat_count = $DB -> sqlFetchOne($sql);

			if(!$cat_count){
				$sql = "
					SELECT
						
							max(NUM_SERIAL) + 1
					FROM
						TAB_BOARD_CATEGORY
					WHERE
						 num_oid = $_OID and num_mcode=$mcode
				";
				$cat_serial = $DB -> sqlFetchOne($sql);
				if (!$cat_serial) $cat_serial = 1;

				$sql = "INSERT INTO TAB_BOARD_CATEGORY(num_oid, num_mcode, num_serial, str_category) VALUES($_OID, $mcode, $cat_serial, '$str_category_text')";
				$DB->query($sql);
				$DB->commit();
			}
			$str_category = $str_category_text;
		}

		$que = " num_oid = '$_OID' and ";

		

		$serial = $DB->sqlFetchOne("
			SELECT
				
					max(num_serial) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				 num_oid = '$_OID' and  num_mcode=$mcode 
		");




		if (!$serial) $serial = 1;
		$group = $DB->sqlFetchOne("
			SELECT
				max(num_group) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				$que num_mcode=$mcode
		");
		

		

		if (!$group) $group = 1;
		$depth = 0;
		$step = 0;

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$user = $_SESSION['USERID'];
		$name = trim($_POST['str_name']);
		$title = trim($_POST['str_title']);
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$upfiles = $_POST['upfiles'];



		
	
		if(!$_POST['content']) {
			WebApp::moveBack('본문을 입력해주십시오.');
		}

	
		
		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$str_text = WebApp::ImgChaneDe($str_text, $serial);

		$title = str_replace("'","''",$title);
		//$str_text = str_replace("'","\'",$str_text);
		
		

	
	

		//비속어처리 2009-07-25 종태
		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';


		/*$str1 = substr($str_text, 0, 2000);
		$str2 = substr($str_text, 2001, 4000);
		$str3 = substr($str_text, 4001, 6000);
		*/
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
		if((strlen($_POST['dt_date'])>0) && substr(trim($_POST['dt_date']),0,2) != '20') $_POST['dt_date'] = "20".trim($_POST['dt_date']);
        
		
		if($_POST['dt_date']){
			$dt_date = WebApp::mkday($_POST['dt_date']);
		}else{
			$dt_date = mktime();
		}	


		if(!$str_tag_use) {
			$str_tag = '';
		}

		
		if($_conf[chr_listtype] =="D"){
		if(!$str_view)  $str_view = "N";
		$listsql = ",str_view";
		$listsql_value = ",'$str_view'";
		$listsql_update = ",str_view = '$str_view'";
		}


		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text, chr_html, dt_date, str_ip, num_hit, str_hak, num_input_pass,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick,str_vr_no,num_unix_time $listsql) 
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str_text','$use_html', $dt_date,'$ip', $num_hit, '$str_hak','$num_input_pass','$str_category','$str_tmp1', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10','$str_tag','$str_coment','$str_scrab','$str_rss' ,'$str_nick','".$_SESSION[vr_no]."',".mktime()." $listsql_value)
			";


		if ($DB->query($sql)) {
			$DB->commit();
			
				
			//2011-07-11 종태 검색엔진에 키워드 등록
			$sch_data[num_oid] = _OID;
			$sch_data[str_url] = "/board.view?mcode=".$mcode."&id=".$serial;
			$sch_data[str_type] = "board";
			$sch_data[str_title] = $title;
			$sch_data[str_text] = strip_tags($str_text);
			$sch_data[num_date] = date("Ymd");
			$sch_data[num_hit] = 0;

			$DB->insertQuery("TAB_SCH",$sch_data);
			$DB->commit();
				

			if($str_setup) {

				 $str_setup_val = $str_coment."|".$str_scrab."|".$str_rss;
				
				 $sql = "UPDATE ".TAB_MEMBER." SET STR_SETUP='$str_setup_val' WHERE num_oid=$_OID and str_id = '".$_SESSION['USERID']."'";
				 $DB->query($sql);
				 $DB->commit();
				$_SESSION['SETUP'] = $str_setup_val;
			}



			if($_SESSION['USERID']){
				//2008-07-07 회원 포인트 값
				$plus_point = "num_board_point";

				$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
				$chw = $DB -> sqlFetchOne($sql);
				
				//2008-11-10 현민 - 게시글 등록시 포인트는 하루에 2건만으로 제한.
				$sql = "select count(*) from $ARTICLE_TABLE where num_oid = $_OID and str_user = '".$_SESSION['USERID']."'";
				$bcnt = $DB -> sqlFetchOne($sql);

				if($bcnt < 2){
					$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
					$DB->query($sql);
					$DB->commit();
				}

			}
// {{{ 업로드한 파일 처리


		//2009-07-01 종태 신규 업로드 프로세서
		$FH = &WebApp::singleton('FileHost');
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		
		$FTP->mkdir($FH->file_dir);
		$FTP->chmod($FH->file_dir,777);
		$FTP->mkdir($FH->file_dir."/".date("Ym")."/");
		$FTP->chmod($FH->file_dir."/".date("Ym")."/",777);


		
		for($ii=1; $ii<11; $ii++) {
			uploadFile($ii);
		}

		
		  if ($DB->query("
                UPDATE
                    $ARTICLE_TABLE
                SET
                   str_thumb='".$_SESSION['get_thumb_filename']."'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial"
                )) $DB->commit();
			
			$_SESSION['get_thumb_filename'] = "";
			unset($_SESSION['get_thumb_filename']);




function deleteCacheFiles($mcode) {
    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/smenu.htm');

        $_mcode = substr($mcode,0,2);
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$_mcode.'.htm');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$mcode.'.htm');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu2.xml');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');
 		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');


		  $dellist=array();
		  $dellist[]="inc.main.out_bbs1.htm";
		  $dellist[]="inc.main.out_bbs2.htm";
   	      $dellist[]="inc.main.out_bbs3.htm";
		  $dellist[]="inc.main.out_bbs4.htm";
		  $dellist[]="inc.main.out_bbs5.htm";
		  $dellist[]="inc.main.new_bbs.htm";
		

		for($ii=0; $ii<count($dellist); $ii++) {
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
		}

}

deleteCacheFiles($mcode);





	echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.list?mcode=$mcode'\">";

		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

			//WebApp::moveBack('글을 작성할 수 없습니다'.$DB->error['message']);
		}
	break;
}
?>
