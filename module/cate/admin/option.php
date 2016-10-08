<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/option.php
* 작성일: 2004-01-26
* 작성자: 거친마루
* 설  명: 메뉴 옵션을 수정하는 화면
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$_OID = WebApp::getConf('oid');
$mcode = $_REQUEST['mcode'];

switch (REQUEST_METHOD) {
	case "GET":
		$env = array();
		$data = $DB->sqlFetch("SELECT * FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$mcode");
		list($module_name,$module_type) = explode('#',$data['str_type']);
		$ext_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
		if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
		if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);

		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $mcode;
		while($_mcode = substr($_mcode,0,-2)) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$_mcode");
		}
		$_location[] = '메인';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('menu/admin/option.htm'));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);

		/*/ {{{ 사용자그룹과 권한 부분 파싱하기
		$sql = "
			SELECT
				*
			FROM
				TAB_ACCESS_RIGHT
			WHERE
				num_oid={$_OID} AND str_sect='menu' AND str_code='{$mcode}'
		";
		$access = $DB->sqlFetchAll($sql);
		print_r($access);

		// TODO: tab_menu_right 테이블에서 권한 읽어와 매칭시키기
		if(!$_oid = WebApp::getConf("member_alias_oid")) $_oid = $_OID;
		$groups = $DB->sqlFetchAll("SELECT * FROM tab_group WHERE num_oid=$_oid ORDER BY num_step");

		$def_groups = array(	// 기본그룹들
			array('str_title'=>'비회원',chr_group=>'n', num_right => 0 ),
			array('str_title'=>'일반',chr_group=>'g', num_right => 0 ),
			array('str_title'=>'학생',chr_group=>'s', num_right => 0 ),
			array('str_title'=>'학부모',chr_group=>'p', num_right => 0 ),
			array('str_title'=>'교직원',chr_group=>'t', num_right => 0 ),
			array('str_title'=>'졸업생',chr_group=>'a', num_right => 0 )
		);

		$tpl->assign('BASIC_PERM',&$def_groups);
		$tpl->assign('EXT_PERM',&$groups);

		//==-- 체크박스 체크하기 --==//
		$rights = $DB->sqlFetchAll("SELECT * FROM TAB_MENU_RIGHT WHERE num_oid=$_OID AND num_mcode=$mcode");
		$tpl->assign('CHECKBOX',&$rights);
		// }}}*/

		$len = strlen($mcode) + 2;
		$env['showopt'] = ($len !=2);
		// {{{ 서브메뉴 셀렉트박스

		$sub = $DB->sqlFetchAll("SELECT * FROM tab_menu WHERE num_oid=$_OID AND num_mcode LIKE '$mcode%' AND LENGTH(num_mcode)=$len");
		if (count($sub) > 1) {
			$env['showsub'] = true;
			$tpl->assign('SUBMENU',&$sub);
		}
		// }}}

		$tpl->assign($data);
		$tpl->assign($ext_data);
		$tpl->assign('menu_location',$menu_location);
		$tpl->assign('env',$env);
		break;
/// {{{ 저장하는 부분
	case "POST":
		$what = $_POST['what'];
        $mcode = $_REQUEST['mcode'];
		switch($what) {
			case "listorder":
				$menus = explode(';',$_POST['listorder']);
				foreach ($menus as $menu) {
					$i++;
					$DB->query("UPDATE tab_menu SET num_step=$i WHERE num_oid=$_OID AND num_mcode=$menu");
				}
				if (!$DB->error) {
					$DB->commit();
					
					$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
					$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
					$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.$mcode.'.htm');
					$FTP->close();

					echo '<script type="text.javascript">try { top.frames["menu"].tree.getSelected().reload() } catch(e) {} </script>';
					WebApp::redirect('admin.menu.option?mcode='.$mcode);
				} else {
					$errors = $DB->error;
					WebApp::moveBack("<!> 메뉴 순서를 변경하지 못했습니다.\n코드: $errors[code]\n에러: $errors[message]\n문장: $errors[sqltext]");
				}
				break;
			case "permission":
				$DB->query("DELETE FROM TAB_MENU_RIGHT WHERE num_oid=$_OID AND num_mcode=$mcode");
				foreach ($_POST['rights'] as $group=>$rights) {
					$num_right = array_sum($rights);
					$DB->query("
						INSERT INTO TAB_MENU_RIGHT
							(num_oid, num_mcode, chr_group, num_right)
						VALUES
							($_OID, $mcode, '$group', $num_right)
					");
					/*
					if (_DEBUG) {
						echo "
						INSERT INTO TAB_MENU_RIGHT
							(num_oid, num_mcode, chr_group, num_right)
						VALUES
							($_OID, $mcode, '$group', $num_right)
						";
					}
					*/
					$group = $rights = '';

				}
				//if (_DEBUG) die();
				if (!$DB->error) $DB->commit();
				WebApp::redirect('admin.menu.option?mcode='.$mcode,'저장하였습니다');

				break;
			default:
				$new_title = $_POST['str_title'];
				$menu_type = $DB->sqlFetchOne("SELECT str_type FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$mcode");
				
				$sql = "UPDATE tab_menu SET str_title='$new_title' WHERE num_oid=$_OID AND num_mcode=$mcode";
				if ($DB->query($sql)) {
					$DB->commit();

					$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
					$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
					if(strlen($mcode)>2) $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.substr($mcode,0,-2).'.htm');
					$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.$mcode.'.htm');
					$FTP->close();
					
					echo "<script type='text/javascript'>parent.frames['menu'].tree.getSelected().parentNode.reload()</script>";
					WebApp::redirect('admin.menu.option?mcode='.$mcode); //,'저장하였습니다');
				} else {
					$errors = $DB->error;
					WebApp::moveBack("<!> 변경사항을 저장하지 못했습니다.\n코드: $errors[code]\n에러: $errors[message]\n문장: $errors[sqltext]");
				}
		}
		break;
// }}}

// {{{ Functions
function cb_admin_tabs(&$arr,$key,$mcode) {
    $arr = sprintf($arr,$mcode);
}
// }}}
}
?>
