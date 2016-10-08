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

$conf_main =  WebApp::getThemeConf('top_menu');
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_top_menu');
$tpl->assign($conf);
$tpl->assign($conf_main);


	//2008-04-17 종태 라이브러리를 위해서
	if($conf['skin']) $theme_name = $conf['skin']; else $theme_name = $conf_main['skin'];
	$template = $param['template'];
    if ($theme_name) $template = "/theme_lib/top_menu/".$theme_name."/attach.top_menu_no.htm";

	//2008-06-25 종태 메뉴정보가저오기 1차

		 $sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=2 AND num_view=1 $que  ORDER BY num_step";
        if($data = $DB->sqlFetchAll($sql)) {

		

$total =  count($data);

		for($iia=0; $iia<count($data); $iia++) {
		
		$data[$iia]['total_count'] = $total;
	
		list($module_name,$module_type) = explode('#',$data[$iia]['str_type']);
        	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['num_mcode']));
        	$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data[$iia]['str_target'] = $mdata['menu_target'];
		


				//2008-06-26 종태 추가 메뉴가저오기
			 $sql2 = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
					   "WHERE num_oid="._OID." AND num_mcode LIKE '".substr($data[$iia]['num_mcode'],0,2)."__'AND num_view=1 $que  ORDER BY num_step";
			 
				if($data[$iia]['sub_menu'] = $DB->sqlFetchAll($sql2)) {


				for($ih=0; $ih<count($data[$iia]['sub_menu']); $ih++) {
				
				$data[$iia]['sub_menu'][$ih]['total_count'] = count($data[$iia]['sub_menu']);
				list($module_name,$module_type) = explode('#',$data[$iia]['sub_menu'][$ih]['str_type']);
					$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['sub_menu'][$ih]['num_mcode']));
					$data[$iia]['sub_menu'][$ih]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
					$data[$iia]['sub_menu'][$ih]['str_target'] = $mdata['menu_target'];
				}
				}

				}
		
		}

	//2008-06-26 종태 추가 메뉴가저오기
	 $sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=3 AND num_view=1 $que  ORDER BY num_step";
        if($data_sub = $DB->sqlFetchAll($sql)) {


		for($ii=0; $ii<count($data_sub); $ii++) {

		list($module_name,$module_type) = explode('#',$data_sub[$ii]['str_type']);
        	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$ii]['num_mcode']));
        	$data_sub[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data_sub[$ii]['str_target'] = $mdata['menu_target'];
		}
		}







	$tpl->assign(array('LIST_topmenu'=>$data, 'LIST_plusmenu'=>$data_sub,  'LIST_menu'=>$data_menu,' mcode' => $mcode ,'mcode_len' => strlen(_MCODE) ));


	$tpl->define('TOPMENU__',$template);
	
	$content = $tpl->fetch('TOPMENU__');

    echo $content;


?>
