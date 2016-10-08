<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/board/manage.php
* 작성일: 2004-02-24
* 작성자: 거친마루
* 설  명: 게시판 옵션 변경
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

switch ($REQUEST_METHOD) {
	case "GET":

		$data = $DB->sqlFetch("SELECT * FROM TAB_BOARD_CONFIG WHERE num_oid=$_OID AND num_mcode=".$mcode);
        $skin = $data['str_skin'];
		$skininfo = @parse_ini_file("html/board/skin/{$skin}/skin.conf.php");
		$current_skinname = $skininfo['name'];

		$tpl->setLayout('blank');
		$tpl->define('CONTENT', WebApp::getTemplate('board/admin/manage/skin.htm'));

        $skinlist = array();
		foreach (glob('html/board/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/board/skin/{$str_skin}/skin.conf.php");
            $skinlist[] = array(
                'str_skin' => $str_skin,
                'skinname' => $skininfo['name']
            );
		}
        $tpl->setLayout('admin');
        $tpl->assign(array(
			'SKIN_LIST' => $skinlist,
			'current_skinname' => $current_skinname,
			'mcode' => $mcode
		));
		$tpl->assign($data);
        $FORM = &WebApp::singleton('Form','skininfo');
        $FORM->setValues($data);
		break;
	case "POST":
        $str_skin = $_POST['str_skin'];
        $sql = "
            UPDATE tab_board_config SET
                str_skin='$str_skin'
            WHERE
                num_oid=$_OID AND num_mcode=$mcode
        ";
		if ($DB->query($sql)) {
			$DB->commit();

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/conf/board/'.$mcode.'.conf.php');
			$FTP->close();
            
			WebApp::redirect($URL->setVar(array(
                'act' => '.skin',
                'mcode' => $mcode
            )),'저장되었습니다.');
		} else {
            WebApp::raiseError(sprintf(_('Error: Failed saving config ( %s )'),$DB->error['message']));
		}
		break;
}

// {{{ Functions
// }}}
?>
