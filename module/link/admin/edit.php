<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/link/admin/seturl.php
* 작성일: 2005-04-01
* 작성자: 거친마루
* 설  명: 링크형 메뉴의 URL을 설정하는 다이얼로그
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

switch (REQUEST_METHOD) {
    case 'GET':
        $sql = "
            SELECT * FROM
                TAB_CONTENT_URL
            WHERE
                num_oid="._OID." AND num_mcode='{$mcode}'
        ";
        $data = $DB->sqlFetch($sql);

        $tpl->setLayout('admin');
        $tpl->define('CONTENT', Display::getTemplate('link/admin/edit.htm'));
        $tpl->assign($data);
        break;
    case 'POST':
        

	//링크메뉴에도 서브메뉴코드를 자동으로 붙이자~ 종태
	if(!strstr($str_url,"mcode")) {


		if(strstr($str_url,"?")) {

		$str_url = $str_url."&mcode={$mcode}";
		}else{

		$str_url = $str_url."?mcode={$mcode}";
		}
		


		$str_url  = $str_url ."&cate={$cate}";

	}
	$sql = "
            UPDATE TAB_CONTENT_URL SET
                str_url='{$str_url}', str_target='{$str_target}', dt_date=SYSDATE
            WHERE
                num_oid="._OID." AND num_mcode='{$mcode}'
        ";
        if ($DB->query($sql)) {
            $DB->commit();

            $FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
            $FTP->close();

            WebApp::redirect($URL->setVar('act','menu.admin.option'));
        } else {
            WebApp::raiseError('링크의 URL을 설정할 수 없습니다');
        }
        break;
}
?>
