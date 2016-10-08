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

switch ($REQUEST_METHOD) {
	case "GET":
		// 설명 문구
		$caption_file = "hosts/$HOST/contents/$mcode.board.caption.htm";
		if(is_file($caption_file)) $str_caption = file_get_contents($caption_file);

		$data = $DB->sqlFetch("SELECT * FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=".$mcode);
		list($data['title_type'],$data['title_text']) = explode(':',$data['str_title'],2);
		$data['chr_comment_checked'] = (isset($data['num_comment']) && !$data['num_comment']) ? "" : "checked";

		$listtype = $data['chr_listtype'] == 'G' ? 'gallery' : 'board';

		$skininfo = @parse_ini_file("html/board/skin/{$data['str_skin']}/skin.conf.php");
		$current_skinname = $skininfo['name'];

		$tpl->setLayout('blank');
		$tpl->define('CONTENT', WebApp::getTemplate('board/admin/manage.htm'));

        $skinlist = array();
		foreach (glob('html/board/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/board/skin/$str_skin/skin.conf.php");
            $skinlist[] = array(
                'str_skin' => $str_skin,
                'skinname' => $skininfo['name']
            );
		}
        $tpl->assign(array(
			'SKIN_LIST'=>$skinlist,
			'current_skinname'=>$current_skinname,
			'mcode'=>$mcode
		));
		$tpl->assign($data);
		break;
	case "POST":

		$section = $_REQUEST['section'];
		switch ($section) {
			case 'BASIC':
				$chr_recent = $_POST['chr_recent'] ? $_POST['chr_recent'] : 'N';
				$chr_comment = $_POST['chr_comment'] ? $_POST['chr_comment'] : 'N';
				$sql = "
					UPDATE $CONFIG_TABLE SET
						str_title='$str_title', num_listnum=$num_listnum, num_navnum=$num_navnum,
						num_titlelen=$num_titlelen, chr_oddcolor='$chr_oddcolor', chr_evencolor='$chr_evencolor',
						chr_recent='$chr_recent', chr_comment='$chr_comment'
					WHERE
						num_oid=$_OID AND num_mcode=$mcode";

				break;
			case 'SKIN':
				$sql = "
					UPDATE $CONFIG_TABLE SET
						str_skin='$str_skin'
					WHERE
						num_oid=$_OID AND num_mcode=$mcode
                ";
				break;
		}
		if ($DB->query($sql)) {
			$DB->commit();

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/conf/board/'.$mcode.'.conf.php');
			$FTP->close();
            
			WebApp::redirect($URL->setVar(array(
                'act' => 'board.admin.manage',
                'mcode' => $mcode
            )),'저장되었습니다.');
		} else {
            WebApp::raiseError(sprintf(_('Error: Failed saving config ( %s )'),$DB->error['message']));
		}
		break;
}

// {{{ Functions
function cb_format_config(&$arr) {
    list($arr['title_type'],$arr['title_text']) = explode(':',$arr['str_title'],2);
	$arr['chr_comment_checked'] = (isset($arr['num_comment']) && !$arr['num_comment']) ? "" : "checked";
}
// }}}
?>
