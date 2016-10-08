<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/write.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'w');

$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);

switch ($REQUEST_METHOD) {
	case "GET":
		if (!$env['admin'] && !$_SESSION['USERID']) {
			WebApp::alert("로그인 하지 않고 비공개로 글을 작성하실 경우\n작성하신 글과 답변글을 열람하실 수 없습니다.");
		}
		if ($env['admin'] && !$_SESSION['USERID']) {
			$name = "관리자";
		} elseif($_SESSION['USERID']) {
            $name = $_SESSION['NAME'];
        }

		$tpl->setLayout('sub');
		$tpl->define("CONTENT","html/party/council/skin/${skin}/write.htm");
		$tpl->assign(array(
            'env'   => $env,
            'name'  => $name,
			'mcode' => $mcode
		));
	break;
	case "POST":
		$DB = &WebApp::singleton('DB');
		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".PK_TAB_PARTY_COUNCIL.") */
				num_serial+1
			FROM
				".TAB_PARTY_COUNCIL."
			WHERE
				num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND rownum=1
		");
		if (!$serial) $serial = 1;
		$group = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
				num_group+1
			FROM
				".TAB_PARTY_COUNCIL."
			WHERE
				num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND rownum=1
		");
		if (!$group) $group = 1;
		$depth = 0;
		$step = 0;

        $num_notice = $_POST['num_notice'] ? 1 : 0;
		$user = $_SESSION['USERID'];
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$upfiles = $_POST['upfiles'];
		$content = $_POST['content'];
		$num_public = $_POST['num_public'];
		$chr_method = $_POST['chr_method'];
		$content = $_POST['content'];
		if(!$content) $content = "<p></p>";
		$content = $FH->get_content($content);
		list($str1,$str2,$str3) = content_split($content);	// 앞에서부터 3개 이하는 버림!
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');

		$sql = 
			"INSERT INTO ".TAB_PARTY_COUNCIL."
				(num_oid, num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_ouser, str_name, 
					str_email, str_title, str_text1, str_text2, str_text3, chr_html, dt_date, str_ip,num_public,chr_method)
			VALUES
				($_OID,$pcode,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$user','$name',
					'$email','$title','$str1','$str2','$str3','$use_html',sysdate,'$ip',$num_public,'$chr_method')
			";
		if ($DB->query($sql)) {
			$DB->commit();

			// {{{ 업로드한 파일 처리
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$serial);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			$FH->close();
			// }}}

			if ($DB->query("UPDATE ".TAB_PARTY_COUNCIL." SET num_file=$num_file
				WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$serial")) $DB->commit();
			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('글을 작성할 수 없습니다'.$DB->error['message']);
		}
	break;
}


// {{{ Functions
function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}
// }}}
?>