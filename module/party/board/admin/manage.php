<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/admin/manage.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: �Խ��� �ɼ� ����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$mcode = $_REQUEST['mcode'];
switch ($REQUEST_METHOD) {
	case "GET":
		$data = $DB->sqlFetch("SELECT * FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=".$mcode);
        $data['mcode'] = $mcode;

        // ��Ų��� �޾ƿ���
        $skinlist = array();
		foreach (glob('html/party/board/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/board/skin/{$str_skin}/skin.conf.php");
            $skinlist[] = array(
                'str_skin' => $str_skin,
                'skinname' => $skininfo['name']
            );
		}

		$skininfo = @parse_ini_file("html/board/skin/{$data['str_skin']}/skin.conf.php");
		$data['current_skinname'] = $skininfo['name'];

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', 'html/party/board/admin/manage.htm');
		$tpl->assign($data);
        $tpl->assign('SKIN_LIST',$skinlist);
		break;
	case "POST":
        $str_title = $_POST['str_title'];
        $chr_oddcolor = $_POST['chr_oddcolor'];
        $chr_evencolor = $_POST['chr_evencolor'];
        $str_skin = $_POST['str_skin'];
        $chr_recent = $_POST['chr_recent'] ? 'Y' : 'N';
        $chr_comment = $_POST['chr_comment'] ? 'Y' : 'N';
        $chr_upload = $_POST['chr_upload'] ? 'Y' : 'N';
        $sql = "
            UPDATE $CONFIG_TABLE SET
                str_title='$str_title', chr_oddcolor='$chr_oddcolor', chr_evencolor='$chr_evencolor',
                str_skin='$str_skin', chr_recent='$chr_recent', chr_comment='$chr_comment', chr_upload='$chr_upload', chr_su='$chr_su'
            WHERE
                num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";

		if ($DB->query($sql)) {
			$DB->commit();
			updateConf($pcode,$mcode,$party_conf_file);
			WebApp::moveBack('����Ǿ����ϴ�.');
		} else {
            WebApp::raiseError(sprintf(_('Error: Failed saving config ( %s )'),$DB->error['message']));
		}
		break;
}
?>
