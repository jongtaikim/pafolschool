<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/admin/manage.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = (int)$_REQUEST['mcode'];

switch ($REQUEST_METHOD) {
	case "GET":
		if(!$data = $DB->sqlFetch("SELECT * FROM ".TAB_PARTY_COUNCIL_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode")) {
			WebApp::moveBack('상담실 설정이 존재하지 않습니다.');
		}

        $skin = $data['str_skin'];
		$skininfo = @parse_ini_file("html/party/council/skin/{$skin}/skin.conf.php");
		$current_skinname = $skininfo['name'];

		foreach (glob('html/party/council/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/party/council/skin/{$str_skin}/skin.conf.php");
            $skinlist[] = array(
				'mcode' => $mcode,
                'str_skin' => $str_skin,
                'skinname' => $skininfo['name'],
                'selected' => ($skin == $str_skin ? ' selected' : '')
            );
		}

		$tpl->setLayout('admin');
		$tpl->define('CONTENT','html/party/council/admin/manage.htm');
		$tpl->assign(array(
			'mcode'            => $mcode,
            'current_skinname' => $current_skinname,
			'SKIN_LIST'        => $skinlist
		));
		$tpl->assign($data);
		break;
	case "POST":
		$section = $_REQUEST['section'];
		$str_title = $_REQUEST['str_title'];
		$str_skin = $_REQUEST['str_skin'];
		$chr_oddcolor = $_REQUEST['chr_oddcolor'];
		$chr_evencolor = $_REQUEST['chr_evencolor'];
		$chr_upload = $_REQUEST['chr_upload'];
		
		$sql = "
			UPDATE ".TAB_PARTY_COUNCIL_CONFIG." SET
				str_title='$str_title',chr_oddcolor='$chr_oddcolor', chr_evencolor='$chr_evencolor', str_skin='$str_skin', chr_upload='$chr_upload'
			WHERE
				num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";

		if ($DB->query($sql)) {
			$DB->commit();
            updateConf($pcode,$mcode,$party_conf_file);

			WebApp::redirect($REQUEST_URI,'저장되었습니다.');
		} else {
			WebApp::moveBack("상담실 설정을 변경하는데 실패하였습니다\n" .$DB->error['message']);
		}
		break;
}

?>