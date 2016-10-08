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

$PERM->apply('menu',$mcode,'w');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);
$DB = &WebApp::singleton('DB');




switch ($REQUEST_METHOD) {
	case "GET":
	
	$timestamp = date('U');

	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '$mcode'";
	$names = $DB -> sqlFetchOne($sql);
	$DOC_TITLE = "str:".$names;



		$tpl->define("CONTENT", WebApp::getTemplate("qna_board/skin/${skin}/write.htm"));
	
		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row));

		WebApp::call('_titlebar',array('title'=>$TITLE));
		$tpl->assign(array(
			'mcode'=>$mcode,
			'env'=>$env,
			'edit'=>$edit,
			'str_title'=>$names,
		));
		
		$data['user_id'] = $_SESSION['USERID'];
		$data['name2'] = $_SESSION['NAME'];
		$data['e_mail'] = $_SESSION['E_MAIL'];
		$data['password'] = $_SESSION['PASSWORD'];
		$data['dt_date'] = date("Y-m-d",mktime());
	



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
		break;
	
	case "POST":

		$que = " num_oid = '$_OID' and ";

		

		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
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
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$upfiles = $_POST['upfiles'];
		

		
		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$title = str_replace("'","''",$title);
		$str_text = str_replace("'","''",$str_text);
		$str_text = WebApp::ImgChaneDe($str_text, $serial);
		
		list($str1,$str2,$str3,$str4,$str5,$str6,$str7,$str8,$str9,$str10) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!
		

		
		//2008-08-08 종태 외부이미지를 찾아서 서버에 저장한다..ㅋㅋ
/*
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->mkdir($FH->file_dir);
		$FTP->chmod($FH->file_dir,777);
		$FTP->mkdir($FH->file_dir."/board_img/");
		$FTP->chmod($FH->file_dir."/board_img/",777);
			
		$s = $str_text; 
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		for($ii=0; $ii<count($tmp_img_list); $ii++) {
			if(!strstr($tmp_img_list[$ii],"isch")){
		
			///////////////////////////////////////////
			$ch = curl_init($tmp_img_list[$ii]);
			$tmp_file = $FH->file_dir."/board_img/".mktime()."gif";

			$fp = fopen($tmp_file, "w");

			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			curl_exec($ch);
			curl_close($ch);
			fclose($fp);

			$str_text = str_replace($tmp_img_list[$ii],$tmp_file,$str_text);
			//////////////////////////////////////////////
			}
		}
*/		
	



		/*$str1 = substr($str_text, 0, 2000);
		$str2 = substr($str_text, 2001, 4000);
		$str3 = substr($str_text, 4001, 6000);
		*/
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';


		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text1, str_text2, str_text3, str_text4, str_text5, chr_html, dt_date, str_ip, num_hit, str_hak, num_input_pass,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10) 
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$str4','$str5','$use_html', $dt_date,'$ip', $num_hit, '$str_hak','$num_input_pass','$str_category','$str_tmp1', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10')
			";




		if ($DB->query($sql)) {
			$DB->commit();



// {{{ 업로드한 파일 처리
if(!$_SESSION['get_thumb_filename']) {
	

	
            $num_file = ($upfiles = $_POST['upfiles']) ? count(explode("\n",$upfiles)) : 0;


            if ($num_file) {
              $FH->upload_process($_POST['timestamp'],$serial);
              $FH->rm_tmp_dir($_POST['timestamp']);
            }
           
            if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
            $FH->close();
            // }}}


            if ($DB->query("
                UPDATE
                    $ARTICLE_TABLE
                SET
                    num_file=$num_file, str_thumb='$get_thumb_filename'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial"
                )) $DB->commit();

}else{



  if ($DB->query("
                UPDATE
                    $ARTICLE_TABLE
                SET
                    num_file=1, str_thumb='$get_thumb_filename'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial"
                )) $DB->commit();




}

$_SESSION['get_thumb_filename'] = "";
unset($_SESSION['get_thumb_filename']);
           



	echo "<meta http-equiv='Refresh' Content=\"0; URL='/qna_board.list?mcode=$mcode&id=$serial'\">";

		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

			WebApp::moveBack('글을 작성할 수 없습니다'.$DB->error['message']);
		}
	break;
}
?>
