<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 보이기
*****************************************************************
* 
*/

$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');


	$template = $param['template'];


	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				   "WHERE num_oid="._OID." AND LENGTH(num_mcode)=2 and num_view=1  $que  ORDER BY num_step";	
		$menu = $DB -> sqlFetchAll($sql);

		for($a=0 ; $a<sizeof($menu) ; $a++){
			$m = $menu[$a]['num_mcode'];

			list($module_name,$module_type) = explode('#',$menu[$a]['str_type']);
			$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$menu[$a]['num_mcode'],'module_type'=>$module_type));
			$menu[$a]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];

			$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
					   "WHERE num_oid="._OID." AND num_mcode LIKE '".$m."__'   and num_view=1 $que  ORDER BY num_step";

			$menu[$a][sub_menu] = $DB -> sqlFetchAll($sql);
			for($i=0 ; $i<sizeof($menu[$a][sub_menu]) ; $i++){
				list($module_name,$module_type) = explode('#',$menu[$a][sub_menu][$i]['str_type']);
				$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$menu[$a][sub_menu][$i]['num_mcode'],'module_type'=>$module_type));
				$menu[$a][sub_menu][$i]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
			}
		
		}	



	$tpl->assign(array('LIST'=>$menu));


	$tpl->define('SITEMAP__',$template);
	
	$content = $tpl->fetch('SITEMAP__');

    echo $content;


?>
