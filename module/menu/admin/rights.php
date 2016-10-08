<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: menu/admin/rights.php
* 작성일: 2006-03-16
* 작성자: 이범민
* 설  명: 권한설정
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
if(!$mcode = $_REQUEST['mcode']) WebApp::moveBack('잘못된 요청입니다.');
$DB = &WebApp::singleton('DB');

$menu_type = $DB->sqlFetchOne("SELECT str_type FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode");
list($module_name,$module_type) = explode('#',$menu_type);
$menu_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
$enable_rights = $menu_data['rights'];


$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '$mcode' ";
$str_title = $DB -> sqlFetchOne($sql);
$tpl->assign(array('str_title'=>$str_title));




switch($REQUEST_METHOD) {
	case "GET":
        $sub_cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__'");

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
        $sql = "SELECT * FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='menu' AND str_code='$mcode'";
        if($rdata = $DB->sqlFetchAll($sql)) {
            $data = array();
            foreach($rdata as $row) {
                $_rights = str_split($row['str_right']);
                foreach($_rights as $_right) {
                    $data[] = array('str_group'=>$row['str_group'],'right'=>$_right);
                }
            }
        }


		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $mcode;
		while(strlen($_mcode = substr($_mcode,0,-2)) > 1) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_MCODE=$_mcode");
		}
		$_location[] = '메인';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}
		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/menu/admin/rights.htm');
        $tpl->assign($menu_data);
        $tpl->assign(array(
            'mcode'     =>  $mcode,
            'sub_cnt'   =>  $sub_cnt,
            'TABS'      =>  $menu_data['admin_tabs'],
            'LIST'      =>  $data,
            'TYPES'     =>  $mem_types,
            'GROUPS'    =>  $gdata,
			'menu_location' => $menu_location,
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
                   "VALUES ($_OID,'menu','$mcode','$group','$str_right')";
            $DB->query($sql);
        }
        $DB->commit();
        WebApp::moveBack();
	break;
}

function cb_rights_format(&$arr, $key, $enable_rights) {
    $arr['RIGHTS'] = $enable_rights;
}

?>