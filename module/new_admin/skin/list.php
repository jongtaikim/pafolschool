<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/skin.php
* �ۼ���: 2006-03-06
* �ۼ���: ������
* ��  ��: �̴�Ȩ�� ��Ų ��ü
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('lms_admin/skin/list.htm'));
		break;

	case "POST":
	
		$mode = $_POST['mode'];
$FH = &WebApp::singleton('FileHost','skin','skin');

		switch($mode){
			case "save":

				print_r($_POST);
				$upfiles = $_POST['upfiles'];
				$serial = $DB->sqlFetchOne("
					SELECT
						num_main+1
					FROM
						".TAB_FILES."
					WHERE
						num_oid=$_OID AND str_sect='skin' AND str_code='skin' AND rownum=1
				");
				if (!$serial) $serial = 1;

				
				// {{{ ���ε��� ���� ó��
				$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
				if ($num_file) {
					if(!ereg('^(.*).(gif|jpg)$',$_FILES['attach_file']['name'])) {
						WebApp::alert('���������� gif,jpg ���ϸ� �����մϴ�.');
					} else {
						$FH->upload_process($_POST['timestamp'],$serial);
						$FH->rm_tmp_dir($_POST['timestamp']);
					}
				}
				$FH->find_upload($str_text);
				if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
				$FH->close();
				// }}}

				break;

			case "del":
				break;

			case "show":
				break;
		}



		break;
}
?>