<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-29
* 작성자: 이현민
* 설   명: 사이트 사이트맵을 출력하는 국가차원에 이익이 되는 좋은 프로그램
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$title = WebApp::get("sitemap",array('key'=>'menu'));
$DOC_TITLE = "str:".$title[menu_name];

	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_cate)=2 and num_view=1  $que  ORDER BY num_step";	
	$menu = $DB -> sqlFetchAll($sql);

	for($a=0 ; $a<sizeof($menu) ; $a++){
		$m = $menu[$a]['num_cate'];

	    list($module_name,$module_type) = explode('#',$menu[$a]['str_type']);
		$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu[$a]['num_cate'],'module_type'=>$module_type));
		$menu[$a]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];

		$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				   "WHERE num_oid="._OID." AND num_cate LIKE '".$m."__'   and num_view=1 $que  ORDER BY num_step";

		$menu[$a][sub_menu] = $DB -> sqlFetchAll($sql);
		for($i=0 ; $i<sizeof($menu[$a][sub_menu]) ; $i++){
		    
			list($module_name,$module_type) = explode('#',$menu[$a][sub_menu][$i]['str_type']);
			$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu[$a][sub_menu][$i]['num_cate'],'mcode'=>$menu[$a][sub_menu][$i]['num_mcode'],'module_type'=>$module_type));
			$menu[$a][sub_menu][$i]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
					
					$mm = $menu[$a][sub_menu][$i]['num_cate'];
					
					$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				   "WHERE num_oid="._OID." AND num_cate LIKE '".$mm."__'   and num_view=1 $que  ORDER BY num_step";

					$menu[$a][sub_menu][$i][sub_menu_sub] = $DB -> sqlFetchAll($sql);
					for($ii=0 ; $ii<sizeof($menu[$a][sub_menu][$i][sub_menu_sub]) ; $ii++){

					 list($module_name,$module_type) = explode('#',$menu[$a][sub_menu][$i][sub_menu_sub][$ii]['str_type']);
					$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu[$a][sub_menu][$i][sub_menu_sub][$ii]['num_cate'],'mcode'=>$menu[$a][sub_menu][$i][sub_menu_sub][$ii]['num_mcode'],'module_type'=>$module_type));
					$menu[$a][sub_menu][$i][sub_menu_sub][$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
					
					}

		}
	
	}	



	$tpl->assign(array('LIST'=>$menu));




	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_cate)=3 and num_view=1  $que  ORDER BY num_step";	
	$menu_plus = $DB -> sqlFetchAll($sql);

	for($a=0 ; $a<sizeof($menu_plus) ; $a++){
		$m = $menu_plus[$a]['num_cate'];

	    list($module_name,$module_type) = explode('#',$menu_plus[$a]['str_type']);
		$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu_plus[$a]['num_cate'],'mcode'=>$menu_plus[$a]['num_mcode'],'module_type'=>$module_type));
		$menu_plus[$a]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];

		$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				   "WHERE num_oid="._OID." AND num_cate LIKE '".$m."__'   and num_view=1 $que  ORDER BY num_step";

		$menu_plus[$a][sub_menu] = $DB -> sqlFetchAll($sql);
		for($i=0 ; $i<sizeof($menu_plus[$a][sub_menu]) ; $i++){
		    
			list($module_name,$module_type) = explode('#',$menu_plus[$a][sub_menu][$i]['str_type']);
			$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu_plus[$a][sub_menu][$i]['num_cate'],'module_type'=>$module_type));
			$menu_plus[$a][sub_menu][$i]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
					
					$mm = $menu_plus[$a][sub_menu][$i]['num_cate'];
					
					$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				   "WHERE num_oid="._OID." AND num_cate LIKE '".$mm."__'   and num_view=1 $que  ORDER BY num_step";

					$menu_plus[$a][sub_menu][$i][sub_menu_sub] = $DB -> sqlFetchAll($sql);
					for($ii=0 ; $ii<sizeof($menu_plus[$a][sub_menu][$i][sub_menu_sub]) ; $ii++){

					 list($module_name,$module_type) = explode('#',$menu_plus[$a][sub_menu][$i][sub_menu_sub][$ii]['str_type']);
					$mdata = WebApp::get($module_name,array('key'=>'menu','cate'=>$menu_plus[$a][sub_menu][$i][sub_menu_sub][$ii]['num_cate'],'mcode'=>$menu_plus[$a][sub_menu][$i][sub_menu_sub][$ii]['num_mcode'],'module_type'=>$module_type));
					$menu_plus[$a][sub_menu][$i][sub_menu_sub][$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
					
					}

		}
	
	}	
	



	$tpl->assign(array('LISTplus'=>$menu_plus));

	$tpl->setLayout("@sub");
	$tpl->define("CONTENT", Display::getTemplate("sitemap/view.htm"));

?>