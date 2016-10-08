<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/reply.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'w');

$DB = WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
if(!$id = $_REQUEST['id']) WebApp::moveBack('글이 존재하지 않습니다');

switch ($REQUEST_METHOD) {
	case "GET":
		$data = $DB->sqlFetchArray("SELECT * FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
		if (!$data) WebApp::moveBack('해당 글이 존재하지 않습니다');

		// 접근권한체크 (중요!!! : 관리자인지 체크,id 체크,공개글인지체크,쓰기권한 체크)
		if(!$GLOBALS['IS_ADMIN'] && (!$_SESSION['USERID'] || $data['str_ouser'] != $_SESSION['USERID'])) {
			if(!$data['num_public'] || !$PERM->check('party',$pcode.'.'.$mcode,'w')) WebApp::moveBack("권한이 없습니다.");
		}
		// 원본글의 글쓴이 id가 없고 비공개인지 체크
		elseif(!$data['str_ouser'] && !$data['num_public']) {
			WebApp::alert("이 글은 로그인한 회원이 쓴 글이 아니므로 글쓴이가 답변글을 확인할 수 없을 것입니다.");
		}
		@_format_data(&$data);

        if ($env['admin'] && !$_SESSION['USERID']) {
			$name = "관리자";
		} elseif($_SESSION['USERID']) {
            $name = $_SESSION['NAME'];
        }

		$re = '<td width="40">[Re]:</td>';
		$tpl->define("CONTENT","html/party/council/skin/${skin}/write.htm");
		$tpl->assign(array(
            'env'       => $env,
            'name'      => $name,
            'id'        => $id,
			'FILE_HOST' => $FILE_HOST
		));
		$tpl->assign($data);
		break;
	case "POST":
		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".PK_TAB_PARTY_COUNCIL.") */
				NUM_SERIAL+1
			FROM
				".TAB_PARTY_COUNCIL."
			WHERE
				num_oid=$_OID AND
                num_pcode=$pcode AND
				num_mcode=$mcode AND
				ROWNUM=1");

		$parent_info = $DB->sqlFetch("
			SELECT
				/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
				num_mcode, num_serial, num_group, num_step, num_depth, str_user, str_ouser, num_public
			FROM
				".TAB_PARTY_COUNCIL."
			WHERE
				num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id
		");
		// 접근권한체크 (중요!!! : 관리자인지 체크,id 체크,공개글인지체크,쓰기권한 체크)
		if(!$IS_ADMIN && (!$_SESSION['USERID'] || $parent_info['str_ouser'] != $_SESSION['USERID'])) {
			if(!$parent_info['num_public'] || !$PERM->check('w')) WebApp::moveBack("권한이 없습니다.");
		}

		$group = $parent_info['num_group'];
		$depth = (int)$parent_info['num_depth'] + 1;
		$step = (int)$parent_info['num_step'] - 1;
		$mcode = $parent_info['num_mcode'];

		$DB->query("UPDATE ".TAB_PARTY_COUNCIL." SET num_step=num_step-1 
						WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=$group AND num_step<".$parent_info['num_step']);

        $num_notice = $_POST['num_notice'] ? 1 : 0;
		$user = $_SESSION['USERID'];
		$ouser = $parent_info['str_ouser'];
		$name = $_POST['str_name'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$title = $_POST['str_title'];
		$num_public = $parent_info['num_public'];
		$content = $FH->get_content($_POST['content']);
		list($str1,$str2,$str3) = content_split($content);	// 앞에서부터 3개 이하는 버림!
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		
		$ip = getenv('REMOTE_ADDR');
		$sql = "INSERT INTO ".TAB_PARTY_COUNCIL." (
					num_oid,num_pcode,num_mcode,num_serial,num_notice,num_group,num_step,
					num_depth,str_user,str_ouser,str_name,str_email,
					str_title,str_text1,str_text2,str_text3,chr_html,
					dt_date,str_ip,num_public,chr_method
				) VALUES (
					$_OID,$pcode,$mcode,$serial,$num_notice,$group,$step,
					$depth,'$user','$ouser','$name','$email',
					'$title','$str1','$str2','$str3','$use_html',
					sysdate,'$ip',$num_public,'$chr_method'
				)";
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

			if ($DB->query("UPDATE ".TAB_PARTY_COUNCIL." SET NUM_FILE=$num_file
				WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$serial")) $DB->commit();
			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('답변을 달 수 없습니다');
		}
		break;
}

#### Functions ####
function _format_data(&$data) {
	$data['passwd'] = $data['writer'] = $data['email'] = $data['use_html'] = "";
	$data['title'] = &$data['str_title'];
	$data['comment'] = "\n\n\n\n\n------------------------------------------\n[ ".$data['title']." ]\n".$data['body'];
	$data['public_disabled'] = "disabled";	// 원본글이 아닌경우 공개비공개설정 수정불가
	if($data['num_public'] == 1) $data['public_checked'] = "checked";
	if($data['chr_method'] == 'E') $data['method_checked'] = "checked";
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,4000);
		$str = substr($str,4000);
	}
	return $ret;
}
?>
