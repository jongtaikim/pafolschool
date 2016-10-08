<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/reply.php
* �ۼ���: 2006-05-11
* �ۼ���: �̹���
* ��  ��: �Խ��� ��۾���
*****************************************************************
* 
*/
$id = $_REQUEST['id'];
if(!$env['writable']) WebApp::raiseError('������ �����ϴ�.');
$DB = WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid($oid);

switch ($REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('���� �������� �ʽ��ϴ�');
		$data = $DB->sqlFetch("SELECT * FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
		if (!$data) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
		@_format_data(&$data);

		$tpl->assign('re','<td width="40">[Re]:</td>');
		$tpl->define("CONTENT", "html/party/board/skin/".$board_skin."/write.htm");
		$tpl->assign($data);
		$tpl->assign(array(
			'id'=>$id,
			'mcode'=>$mcode,
			'env'=>$env
		));
		break;
	case "POST":



		//��Ӿ�ó�� 2009-07-25 ����
		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';




		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_PRIMARY_INDEX) */
				num_serial+1
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid=$oid AND num_pcode=$pcode AND num_mcode=$mcode AND rownum=1
		");

		$parent_info = $DB->sqlFetch("
			SELECT
				num_mcode, num_serial, num_group, num_step, num_depth
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid=$oid AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id
		");

		$group = $parent_info['num_group'];
		$depth = (int)$parent_info['num_depth'] + 1;
		$step = (int)$parent_info['num_step'] - 1;
		$mcode = $parent_info['num_mcode'];

		$DB->query("UPDATE $ARTICLE_TABLE SET num_step=num_step-1 WHERE num_oid=$oid AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=$group AND num_step<".$parent_info['num_step']);

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$user = $_SESSION['USERID'];
		$name = $_POST['str_name'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$title = $_POST['str_title'];

		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$title = str_replace("'","''",$title);
		//$str_text = str_replace("'","''",$str_text);
		$str_text = WebApp::ImgChaneDe($str_text, $serial);

	//	list($str1,$str2,$str3) = content_split($str_text);	// �տ������� 3�� ���ϴ� ����!
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		
		$ip = getenv('REMOTE_ADDR');
		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text, chr_html, dt_date, str_ip)
			VALUES
				($oid,$pcode,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title',:str_text,'$use_html',sysdate,'$ip')
			";
		if ($DB->query_clob($sql,$str_text)) {
			$DB->commit();

			// {{{ ���ε��� ���� ó��
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$serial);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
			$FH->close();
			// }}}

			if ($DB->query("
				UPDATE
					$ARTICLE_TABLE
				SET
					num_file=$num_file
				WHERE
					num_oid=$oid AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$serial
			")) $DB->commit();

			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('�亯�� �� �� �����ϴ�');
		}
		break;
}

#### Functions ####
function _format_data(&$data) {
	$data['passwd'] = $data['writer'] = $data['email'] = $data['use_html'] = "";
	$data['title'] = &$data['str_title'];
	$data['comment'] = "\n\n\n\n\n------------------------------------------\n[ ".$data['title']." ]\n".$data['body'];
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
