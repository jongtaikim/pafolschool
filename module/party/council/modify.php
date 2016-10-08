<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/modify.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/

$PERM->apply('party',$pcode.'.'.$mcode,'w');

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
if(!$id = $_REQUEST['id']) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');

switch($REQUEST_METHOD) {
	case "GET":
		$sql = "SELECT
                    num_pcode,
					num_mcode as mcode,
					num_serial as serial,
                    num_notice,
					num_step,
					str_user,
					str_name as name,
					str_email as email,
					str_title as title,
					str_text1,
					str_text2,
					str_text3,
					chr_html as use_html, 
					TO_CHAR(dt_date,'YYYY-MM-DD') as reg_date, 
					num_hit as hit, 
					num_file, 
					num_public,
					chr_method,
					str_ip as remote_addr
				FROM
					".TAB_PARTY_COUNCIL."
				WHERE
					num_oid=$_OID AND 
					num_pcode=$pcode AND
					num_mcode=$mcode AND
					num_serial=$id";
		$data = $DB->sqlFetch($sql);
		// ID üũ
		if(!$env['admin'] && (!$_SESSION['USERID'] || $data['str_user'] != $_SESSION['USERID'])) {
			WebApp::moveBack("�α������� �ʾҰų� ȸ������ �ۼ��Ͻ� ���� �ƴմϴ�.");
		}
		@_format_data(&$data);
		$data['content'] = $FH->set_content($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$fdata = $FH->get_files_info($id);
		$total_size = array_pop($fdata);

		$tpl->define("CONTENT","html/party/council/skin/${skin}/write.htm");
		$tpl->assign(array(
            'env'       => $env,
			'mcode'     => $mcode,
			'id'        => $id,
			'num_serial'=> $id,
			'FILE_LIST' => $fdata,
			'total_size'=> $total_size
		));
		$tpl->assign($data);
	break;
	case "POST":
		if(!$env['admin']) {
			$sql = "SELECT STR_USER FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
			if(!$_SESSION['USERID'] || $_SESSION['USERID'] != $DB->sqlFetchOne($sql)) {
				WebApp::moveBack('�α������� �ʾҰų� ȸ������ �ۼ��Ͻ� ���� �ƴմϴ�.');
			}
		}

        $num_notice = $_POST['num_notice'] ? 1 : 0;
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$email = $_POST['str_email'];
		$use_html = $_POST['use_html'];
		$num_public = $_POST['num_public'];
		$chr_method = $_POST['chr_method'];
		if (!$use_html) $use_html = 'Y';
		$content = $FH->get_content($_POST['content']);
		list($str1,$str2,$str3) = content_split($content);	// �տ������� 3�� ���ϴ� ����!

		$sql =
			"UPDATE
				".TAB_PARTY_COUNCIL."
			SET
                num_notice=$num_notice,
				str_title='$title',
				str_text1='$str1',
				str_text2='$str2',
				str_text3='$str3',
				str_email='$email', 
				chr_html='$use_html', 
				chr_method='$chr_method'
			WHERE
				num_oid=$_OID AND
                num_pcode=$pcode AND
				num_mcode=$mcode AND
				num_serial=$id
			";
		if ($DB->sqlQuery($sql)) {
			$DB->commit();
			// {{{ �ش���� �������� ��� -> �������� ����(���� �׷��� ������ �������� ����)
			$sql = "SELECT num_group,num_step FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_mcode=$mcode AND num_serial=$id";
			$data = $DB->sqlFetch($sql);
			if($data['num_step'] == 0) {
				$sql = "UPDATE ".TAB_PARTY_COUNCIL." SET num_public=$num_public
						WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=".$data['num_group'];
				$DB->sqlQuery($sql);
				$DB->commit();
			}
			// }}}

			// {{{ ���ε��� ���� ó��
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			$FH->close();
			// }}}

			if ($DB->query("
				UPDATE
					".TAB_PARTY_COUNCIL."
				SET
					num_file=."($origin_num_file + $num_file)."
				WHERE
					num_oid=$_OID AND
                    num_pcode=$pcode AND
					num_mcode=$mcode AND
					num_serial=$id"
				)) $DB->commit();
			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('���� ������ �� �����ϴ�');
		}
	break;
}

#### Functions ####
function _format_data(&$arr) {
	$arr['use_html_checked'] = ($arr['use_html'] == 1) ? " CHECKED" : "";
	$arr['secret_checked'] = ($arr['secret'] == 1) ? " CHECKED" : "";
	$arr['name'] = &$arr['name'];
	$arr['title'] = strip_tags(&$arr['title']);
	$arr['content'] = $arr['str_text1'].$arr['str_text2'].$arr['str_text3'];
	if($arr['num_step'] != 0) $arr['public_disabled'] = "disabled";	// �������� �ƴѰ�� ������������� �����Ұ�
	if($arr['num_public'] == 1) $arr['public_checked'] = "checked";
	if($arr['chr_method'] == 'E') $arr['method_checked'] = "checked";
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
