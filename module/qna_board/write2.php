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

switch ($REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		$tpl->setLayout('sub');
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/write2.htm"));
        WebApp::call('_titlebar',array('title'=>$TITLE));
		$tpl->assign(array(
			'mcode'=>$mcode,
			'env'=>$env
		));
	    break;
	case "POST":
		$DB = &WebApp::singleton('DB');
		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_PRIMARY_INDEX) */
				num_serial+1
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid=$oid AND num_mcode=$mcode AND rownum=1
		");
		if (!$serial) $serial = 1;
		$group = $DB->sqlFetchOne("
			SELECT
				max(num_group) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid=$oid AND num_mcode=$mcode
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
		$str_text = $FH->get_content($str_text);
		list($str1,$str2,$str3) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';
		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text1, str_text2, str_text3, chr_html, dt_date, str_ip, num_hit)
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$use_html', $dt_date,'$ip', $num_hit)
			";
		if ($DB->query($sql)) {
			$DB->commit();

            // {{{ 업로드한 파일 처리
            $num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
            if ($num_file) {
                $FH->upload_process($_POST['timestamp'],$serial);
                $FH->rm_tmp_dir($_POST['timestamp']);
            }
            $FH->find_upload($str_text);
            if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
            $FH->close();
            // }}}


            if ($DB->query("
                UPDATE
                    $ARTICLE_TABLE
                SET
                    num_file=$num_file, str_thumb='$get_thumb_filename'
                WHERE
                    num_oid=$oid AND num_mcode=$mcode AND num_serial=$serial"
                )) $DB->commit();

           
            if($env['use_recent']) {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
            }
			
			//echo "$listlink";exit;
			$listlink = "board.list2?mcode=110";
			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

			WebApp::moveBack('글을 작성할 수 없습니다'.$DB->error['message']);
		}
	break;
}
?>
