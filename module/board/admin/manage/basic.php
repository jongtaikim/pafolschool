<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/board/manage/basic.php
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
		//==-- 설명 문구 --==//
		$caption_file = "hosts/$HOST/contents/$mcode.board.caption.htm";
		if(is_file($caption_file)) $str_caption = file_get_contents($caption_file);

		$data = $DB->sqlFetch("SELECT * FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=".$mcode);


		list($data['title_type'],$data['title_text']) = explode(':',$data['str_title'],2);
		$data['chr_comment_checked'] = (isset($data['num_comment']) && !$data['num_comment']) ? "" : "checked";

		$listtype = $data['chr_listtype'] == 'G' ? 'gallery' : 'board';

		$skininfo = @parse_ini_file("html/board/skin/{$data['str_skin']}/skin.conf.php");
		$current_skinname = $skininfo['name'];

		$data['str_title2'] = $data['str_title'];
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', WebApp::getTemplate('board/admin/manage/basic.htm'));

        $tpl->assign('mcode',$mcode);
		$tpl->assign($data);
				$tpl->assign(array('menu' => $a,));
		break;
	case "POST":
        $data = Form::values('str_title','num_listnum','num_navnum','num_titlelen','chr_oddcolor','chr_evencolor','str_file_type','str_admin_id', 'str_list_view');
        $data['chr_recent'] = $_POST['chr_recent'] ? 'Y' : 'N';
        $data['chr_comment'] = $_POST['chr_comment'] ? 'Y' : 'N';
        $data['chr_upload'] = $_POST['chr_upload'] ? 'Y' : 'N';
	    $data['chr_stats'] = $_POST['chr_stats'] ? 'Y' : 'N';
    	$data['chr_hak'] = $_POST['chr_hak'] ? 'Y' : 'N';
        $data['num_titlelen'] = $_POST['num_titlelen'] ? $_POST['num_titlelen'] : '200';

		$data['num_board_point'] = $num_board_point;
		$data['num_repaly_point'] = $num_repaly_point;
		$data['num_commint_point'] = $num_commint_point;
		$data['str_width'] = $str_width;
	
		if ($DB->updateQuery($CONFIG_TABLE,$data,"num_oid={$_OID} AND num_mcode={$mcode}")) {
			$DB->commit();

            $sql = "UPDATE ".TAB_MENU." SET str_title='".$data['str_title']."' WHERE num_oid=$_OID AND num_mcode=$mcode";
            $DB->query($sql);
            $DB->commit();

			/*
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/conf/board/'.$mcode.'.conf.php');
            $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
			$FTP->close();
			*/
            
			WebApp::redirect($URL->setVar(array(
                'act' => '.basic',
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
