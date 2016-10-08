<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: add.php
* 작성일: 2005-02-14
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/

$DB = WebApp::singleton('DB');

switch(REQUEST_METHOD) {
	case "GET":
        if ($parent = $_REQUEST['parent']) {
            if(strlen($parent) == 1) {
                // 추가메뉴 처리
                $cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$parent."__'");
                if ($cnt > 100) {
                    WebApp::alert(_("Can Not Add Mainmenu more than 11"));
                    WebApp::closeWin();
                }
            } else {
                $cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$parent."__'");
                if ($cnt > 100) {
                    WebApp::alert(_("Can Not Add Submenu more than 15"));
                    WebApp::closeWin();
                }
            }
        } else {
            $cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2");
			if ($cnt > 100) {
				WebApp::alert(_("Can Not Add Mainmenu more than 11"));
				WebApp::closeWin();
			}
        }

		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $parent;
		do {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$_mcode");
		} while(strlen($_mcode = substr($_mcode,0,-2)) > 1);
		$_location[] = _('Main');
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

		
		if($MENU_SELECT) {
			$_SESSION['MENU_SELECT2'] = $MENU_SELECT;
		}

		
        $tpl->setLayout('admin');
		$tpl->define('CONTENT',WebApp::getTemplate('menu/admin/add.htm'));
		$tpl->assign('parent',$_REQUEST['parent']);
		$tpl->assign('menu_location',$menu_location);
		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
		$tpl->assign('MENU_TYPE2',$VAR_MENUTYPE2);
		$tpl->assign('MENU_TYPE3',$VAR_MENUTYPE3);
	

/*
	echo "<xmp>";
	print_R($VAR_MENUTYPE);
	exit;
*/
	break;
	case "POST":

//	 $cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/".substr($mcode,0,strlen($mcode)-2).".htm";
	// unlink($cache_file);

	 exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");

    $parent = $_REQUEST['parent'];
		$menu_name = $_POST['str_title'];
		$new_step = newStep($parent);
		$mcode = newChild($parent);
		$cate = newChild2($parent);
		$str_type = $_POST['str_type'];

		$_mcode = $mcode-1;
		$sql = "select str_layout from TAB_MENU where num_oid = '$_OID' and num_mcode = '".$_mcode."'";
		
		$str_layout = $DB -> sqlFetchOne($sql);
		
		if(!$str_layout){
		$sql = "select str_layout from TAB_MENU where num_oid = '$_OID' and num_mcode = '".substr($mcode,0,2)."'";
		$str_layout = $DB -> sqlFetchOne($sql);
		}
		
		if(!$str_layout || _OID ==20277) $str_layout = "sub";

    
	$sql = "
			INSERT INTO ".TAB_MENU."
				(num_oid, num_step, num_step_back, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout,num_cate)
			VALUES
				($_OID,$new_step, $new_step,$mcode,'$menu_name','$str_type', 1, 1,'$str_layout',$cate)
		";

		if ($DB->query($sql)) {

			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/'.$module_name.'/admin/__add.php';
            deleteCacheFiles($mcode);
			$DB->commit();

            $menu_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
            if ($menu_data['default_rights']) {
                $mem_types = WebApp::get('member',array('key'=>'member_types'));
                foreach($mem_types as $mem_type => $_value) {
                    $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'menu','$mcode','$mem_type','".$menu_data['default_rights']."')";
                    $DB->query($sql);
                }
                $DB->commit();
            }
			
			//2008-03-10 종태 추가 그룹도 디폴트값 집어넣도록!!
			  if ($menu_data['default_group_rights']) {
              
				$sql = "select * from tab_group where num_oid = '$_OID' ";
				$row = $DB -> sqlFetchAll($sql);
				for($ii=0; $ii<count($row); $ii++) {
                   $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'menu','$mcode','".$row[$ii][str_group]."','".$menu_data['default_group_rights']."')";
                    $DB->query($sql);
					$DB->commit();				
				}
				
            }


            echo "<script type='text/javascript'>
            try {
                parent.frames['menu'].reloadParent();
                parent.frames['menu'].setSelected('{$parent}');
            } catch(e) {
                //  nothing special
            }
            </script>";
			WebApp::redirect($URL->setVar(array(
				'act' => '.option',
                'parent' => '',
				'mcode' => $mcode
			)));
		} else {
			WebApp::raiseError(_('Can not add menu'));
		}



	break;
}

function newChild($mcode) {
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$sql = "SELECT MAX(num_mcode) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__'";
	$result = $DB->sqlFetchOne($sql);
	if (!$result) $max_mcode = 10;
	else $max_mcode = substr($DB->sqlFetchOne($sql),-2) + 1;
	if ($max_mcode > 99) WebApp::raiseError(_('Can not add menu'));
	return $mcode.sprintf("%02d",$max_mcode);
}

function newChild2($mcode) {
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$sql = "SELECT MAX(num_cate) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate LIKE '".$mcode."__'";
	$result = $DB->sqlFetchOne($sql);
	if (!$result) $max_mcode = 10;
	else $max_mcode = substr($DB->sqlFetchOne($sql),-2) + 1;
	if ($max_mcode > 99) WebApp::raiseError(_('Can not add menu'));
	return $mcode.sprintf("%02d",$max_mcode);
}


function newStep($mcode) {
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$sql = "SELECT MAX(num_step) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__'";
	return $DB->sqlFetchOne($sql) + 1;
}

//=================================================
// _REQUEST 에 $URL->vars 값 덮어씌움
// overwriteREQUEST($_REQUEST,$_POST,$URL);
//=================================================

function overwriteREQUEST(&$_REQUEST,&$_POST,&$URL){
  foreach($URL->vars as $k =>$v){
    if($_REQUEST[$k]=='') {
      $_REQUEST[$k]=$v;
      $_POST[$k]=$v;
    }
  }
}

?>
