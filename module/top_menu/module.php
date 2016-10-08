<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-06-19
* 작성자: 김종태
* 설  명: top_menu 데이터
*****************************************************************
* 
*/

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc_menu/inc.'._CATE.'.htm';

$widths =   array(105,  105,  110,  95,  105,   105,   115);
$widthss = array(100,   102,   99,  84,   94,    80,   90);

if($del =="y") unlink($cache_file);

//if(!is_file($cache_file)) {


$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

	$tabidx = 1;
	$sql = "SELECT * FROM ".TAB_MENU." WHERE NUM_OID="._OID." AND LENGTH(NUM_CATE)=2 AND NUM_VIEW=1 ORDER BY num_step";
	

	if($data = $DB->sqlFetchAll($sql)) {

		for($ii=0; $ii<count($data); $ii++) {
			
		$data[$ii]['width'] = $widths[$ii];
		$data[$ii]['width2'] = $widthss[$ii];
		$data[$ii]['str_title'] = htmlspecialchars($data[$ii]['str_title']);
		list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);
		$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'module_type'=>$module_type,'cate'=>$data[$ii]['num_cate']));
		$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
		$data[$ii]['str_target'] = $mdata['menu_target'];
		
		$data[$ii]['tabindex'] = $tabidx;
		$tabidx++;
			

			$sql = "SELECT * FROM ".TAB_MENU."
					WHERE
						NUM_OID="._OID." AND
						NUM_CATE LIKE '".$data[$ii]['num_cate']."__' AND
                        NUM_VIEW=1
					ORDER BY NUM_STEP";

			
			if($data[$ii]['SUBMENU_SUB'] = $DB->sqlFetchAll($sql)) {
				
				for($i=0; $i<count($data[$ii]['SUBMENU_SUB']); $i++) {

				 		$data[$ii]['SUBMENU_SUB'][$i]['str_title'] = htmlspecialchars($data[$ii]['SUBMENU_SUB'][$i]['str_title']);
						list($module_name,$module_type) = explode('#',$data[$ii]['SUBMENU_SUB'][$i]['str_type']);
						
						$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['SUBMENU_SUB'][$i]['num_mcode'],'module_type'=>$module_type,'cate'=>$data[$ii]['SUBMENU_SUB'][$i]['num_cate']));
						$data[$ii]['SUBMENU_SUB'][$i]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
						
						
						
						$data[$ii]['SUBMENU_SUB'][$i]['str_target'] = $mdata['menu_target'];

						$data[$ii]['SUBMENU_SUB'][$i]['tabindex'] = $tabidx;
						$tabidx++;


						$sql = "SELECT * FROM ".TAB_MENU."
								WHERE
									NUM_OID="._OID." AND
									NUM_CATE LIKE '".$data[$ii]['SUBMENU_SUB'][$i]['num_cate']."__' AND
							NUM_VIEW=1
								ORDER BY NUM_STEP";


						if($data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'] = $DB->sqlFetchAll($sql)) {
							
							for($ia=0; $ia<count($data[$ii]['SUBMENU_SUB'][$i]['MENUSUB']); $ia++) {

									$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['str_title'] = htmlspecialchars($data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['str_title']);
									list($module_name,$module_type) = explode('#',$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['str_type']);
									$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['num_mcode'],'module_type'=>$module_type,'cate'=>$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['num_cate']));
									$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
									$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['str_target'] = $mdata['menu_target'];

									$data[$ii]['SUBMENU_SUB'][$i]['MENUSUB'][$ia]['tabindex'] = $tabidx;
									$tabidx++;
								
							}
							
						}


					
				}
				
			}
	

				
		
		}
	}


$tpl->assign(array('SUBMENU'=>$data,  'cate' => _CATE ,'mcode_len' => strlen(_CATE) ));
$make = "y";
/*} else {
    $content =  file_get_contents($cache_file);
}*/
?>
