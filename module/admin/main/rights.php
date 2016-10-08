<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: admin/main/rights.php
* 작성일: 2006-05-30
* 작성자: 이범민
* 설  명: 메인모듈 권한설정
*****************************************************************
* 
*/
if(!function_exists('str_split')) {
    function str_split($str,$len = 1) {
        $len = ceil($len);
        if($len < 1) $len = 1;
        $cnt = ceil(strlen($str)/$len);
        $ret = array();
        for($i = 0;$i < $cnt;$i++) {
            $ret[] = substr($str,$i*$len,$len);
        }
        return $ret;
    }
}

if(!$_SESSION[ADMIN]){
WebApp::moveBack('권한이 없습니다.');
exit;
}

$sect = $_REQUEST['sect'];
$code = $_REQUEST['code'];
$module = $_REQUEST['module'];
$enable_rights = WebApp::get($module,array('key'=>'rights'));

$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $conf = Display::getMainConf($module);

         // 기본그룹
        $_mem_types = WebApp::get('member',array('key'=>'member_types'));
        foreach($_mem_types as $key_ => $value_) {
            $mem_types[] = array('name' => $value_, 'code' => $key_);
        }
        array_walk($mem_types,'cb_rights_format',$enable_rights);

        // 추가그룹
        $sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
        if($gdata = $DB->sqlFetchAll($sql)) array_walk($gdata,'cb_rights_format',$enable_rights);

        // 현재 설정된 데이타
        $sql = "SELECT * FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='$sect' AND str_code='$code'";
        if($rdata = $DB->sqlFetchAll($sql)) {
            $data = array();
            foreach($rdata as $row) {
                $_rights = str_split($row['str_right']);
                foreach($_rights as $_right) {
                    $data[] = array('str_group'=>$row['str_group'],'right'=>$_right);
                }
            }
        }

		$tpl->setLayout('no3');
        $tpl->define('CONTENT','html/admin/main/rights.htm');
        $tpl->assign(array(
            'title'  => $conf['title'],
            'LIST'   => $data,
            'TYPES'  => $mem_types,
            'GROUPS' => $gdata,
			 'title'=>$title,
        ));
	break;
	case "POST":
		$sql = "DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='menu' AND str_code='$mcode'";
        $DB->query($sql);

        $rights = $_POST['rights'];
        foreach($rights as $group => $row) {
            $str_right = '';
            foreach($row as $right => $value) {
                $str_right .= $right;
            }
            $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right) ".
                   "VALUES ($_OID,'$sect','$code','$group','$str_right')";
            $DB->query($sql);
        }
        $DB->commit();
        WebApp::moveBack('저장되었습니다.');
	break;
}

function cb_rights_format(&$arr, $key, $enable_rights) {
    $arr['RIGHTS'] = $enable_rights;
}
?>