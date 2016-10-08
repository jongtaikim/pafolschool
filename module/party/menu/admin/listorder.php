<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/listorder.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 순서변경
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT num_mcode,str_title FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode ORDER BY num_step";
        $list = $DB->sqlFetchAll($sql);


		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/menu/admin/listorder.htm');
        $tpl->assign(array(
            'mcode' =>  $mcode,
            'LIST'  =>  $list
        ));
	break;
	case "POST":
		$mcodes = $_POST['mcodes'];
        foreach ($mcodes as $mcode) {
            $i++;
            $DB->query("UPDATE ".TAB_PARTY_MENU." SET num_step=$i WHERE num_oid=$_OID AND num_pcode=$pcode");
        }
        if (!$DB->error) {
            $DB->commit();
            
            echo '<script type="text/javascript">parent.frames["padmin_menu"].reloadSelected();</script>';
            WebApp::moveBack();
        } else {
            $errors = $DB->error;
            WebApp::moveBack("<!> 메뉴 순서를 변경하지 못했습니다.\n코드: $errors[code]\n에러: $errors[message]\n문장: $errors[sqltext]");
        }
	break;
}
?>