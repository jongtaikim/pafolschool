<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/menu/option.php
* �ۼ���: 2004-01-26
* �ۼ���: ��ģ����
* ��  ��: �޴� �ɼ��� �����ϴ� ȭ��
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

		// {{{ �޴���ġ �����̼ǹ� �����
		$_mcode = $mcode;
		while($_mcode = substr($_mcode,0,-2)) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$_mcode");
		}
		$_location[] = '����';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('menu/admin/option.htm'));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);

		/*/ {{{ ����ڱ׷�� ���� �κ� �Ľ��ϱ�
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

		// TODO: tab_menu_right ���̺��� ���� �о�� ��Ī��Ű��
		if(!$_oid = WebApp::getConf("member_alias_oid")) $_oid = $_OID;
		$groups = $DB->sqlFetchAll("SELECT * FROM tab_group WHERE num_oid=$_oid ORDER BY num_step");

		$def_groups = array(	// �⺻�׷��
			array('str_title'=>'��ȸ��',chr_group=>'n', num_right => 0 ),
			array('str_title'=>'�Ϲ�',chr_group=>'g', num_right => 0 ),
			array('str_title'=>'�л�',chr_group=>'s', num_right => 0 ),
			array('str_title'=>'�кθ�',chr_group=>'p', num_right => 0 ),
			array('str_title'=>'������',chr_group=>'t', num_right => 0 ),
			array('str_title'=>'������',chr_group=>'a', num_right => 0 )
		);

		$tpl->assign('BASIC_PERM',&$def_groups);
		$tpl->assign('EXT_PERM',&$groups);

		//==-- üũ�ڽ� üũ�ϱ� --==//
		$rights = $DB->sqlFetchAll("SELECT * FROM TAB_MENU_RIGHT WHERE num_oid=$_OID AND num_mcode=$mcode");
		$tpl->assign('CHECKBOX',&$rights);
		// }}}*/

		$len = strlen($mcode) + 2;
		$env['showopt'] = ($len !=2);
		// {{{ ����޴� ����Ʈ�ڽ�

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
/// {{{ �����ϴ� �κ�
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
					WebApp::moveBack("<!> �޴� ������ �������� ���߽��ϴ�.\n�ڵ�: $errors[code]\n����: $errors[message]\n����: $errors[sqltext]");
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
				WebApp::redirect('admin.menu.option?mcode='.$mcode,'�����Ͽ����ϴ�');

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
					WebApp::redirect('admin.menu.option?mcode='.$mcode); //,'�����Ͽ����ϴ�');
				} else {
					$errors = $DB->error;
					WebApp::moveBack("<!> ��������� �������� ���߽��ϴ�.\n�ڵ�: $errors[code]\n����: $errors[message]\n����: $errors[sqltext]");
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
