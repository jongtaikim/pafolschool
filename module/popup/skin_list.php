<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
if(!$area) $area = "skin";

		$num = 0;
		$pop_skinlist = array();
		foreach (glob(_DOC_ROOT.'/html/popup/'.$area.'/*',GLOB_ONLYDIR) as $pop_str_skin) {
				$pop_str_skin = array_pop(explode('/',$pop_str_skin));
				
				if($pop_str_skin!="default") {
				$pop_skininfo = parse_ini_file("html/popup/".$area."/{$pop_str_skin}/skin.conf.php");
				$pop_skinlist[] = array(
					'pop_str_skin' => $pop_str_skin,
					'pop_skin_name' => $pop_skininfo['name']
					);
				}
		$num ++;
		}

		
	

		if(!$listnum) $listnum = 5;

		if(!$page) $num_start = 0; else $num_start = $page * $listnum ;
		$num_end =  $num_start + $listnum -1 ;

		for($ii=0; $ii<($num / $listnum); $ii++) {
		$idx[$ii]['str_link']	= "javascript:skinLoad('".$ii."')";
		}


		$tpl->assign(array(
			'pop_skin' => $pop_skinlist,
			'total'=>$num,
			'num_start'=>$num_start,
			'num_end'=>$num_end,
			'page'=>$page,
			'idx'=>$idx,
			'area'=>$area,

			));



	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("popup/skin_list.htm"));
	

?>