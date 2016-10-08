<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/rights.php
* 작성일: 2006-05-16
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

$menu_type = $DB->sqlFetchOne("SELECT str_type FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
list($module_name,$module_type) = explode('#',$menu_type);
if(!$module_name) $module_name = $mcode;
$menu_data = WebApp::get('party.'.$module_name,array('key'=>'menu','pcode'=>$pcode,'mcode'=>$mcode,'module_type'=>$module_type));
if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
$enable_rights = $menu_data['rights'];

switch($REQUEST_METHOD) {
	case "GET":
        // 기본그룹
        $_mem_types = WebApp::get('party.member',array('key'=>'member_types'));
        foreach($_mem_types as $key_ => $value_) {
            $mem_types[] = array('name' => $value_, 'code' => $key_);
        }
        array_walk($mem_types,'cb_rights_format',$enable_rights);

        // 추가그룹
        //$sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
        //if($gdata = $DB->sqlFetchAll($sql)) array_walk($gdata,'cb_rights_format',$enable_rights);

		$sql = "SELECT count(*) FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='party' AND str_code='".$pcode.".".$mcode."' and str_group !='str_group' and str_group !='menu_url' and str_group !='menu_name'";
		$chk = $DB -> sqlFetchOne($sql);
		
		if(!$chk){
		
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','x','lr')";
			$DB->query($sql);
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','w','lrw')";
			$DB->query($sql);
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','v','lrw')";
			$DB->query($sql);
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','u','lrw')";
			$DB->query($sql);
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','t','lrw')";
			$DB->query($sql);
			$sql="INSERT INTO TAB_MENU_RIGHT (num_oid,str_sect,str_code,str_group,str_right) VALUES ($_OID,'party','".$pcode.".".$mcode."','s','lrw')";
			$DB->query($sql);
			$DB->commit();
		}

				
				


        // 현재 설정된 데이타
        $sql = "SELECT * FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='party' AND str_code='".$pcode.".".$mcode."'";
        if($rdata = $DB->sqlFetchAll($sql)) {
            $data = array();
            foreach($rdata as $row) {
                $_rights = str_split($row['str_right']);
                foreach($_rights as $_right) {
                    $data[] = array('str_group'=>$row['str_group'],'right'=>$_right);
                }
            }
        }
		


		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/menu/admin/rights.htm');
        $tpl->assign(array(
            'mcode'     =>  $mcode,
            'TABS'      =>  $menu_data['admin_tabs'],
            'LIST'      =>  $data,
            //'GROUPS'    =>  $gdata,
            'TYPES'     =>  $mem_types
        ));
	break;
	case "POST":
		$sql = "DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='party' AND str_code='".$pcode.".".$mcode."'";
        $DB->query($sql);

        $rights = $_POST['rights'];
        foreach($rights as $group => $row) {
            $str_right = '';
            foreach($row as $right => $value) {
                $str_right .= $right;
            }
            $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right) ".
                   "VALUES ($_OID,'party','".$pcode.".".$mcode."','$group','$str_right')";

			
            if(!$DB->query($sql)) die($sql);
        }
        $DB->commit();

        WebApp::moveBack('저장되었습니다.');
	break;
}

function cb_rights_format(&$arr, $key, $enable_rights) {
    $arr['RIGHTS'] = $enable_rights;
}
?>