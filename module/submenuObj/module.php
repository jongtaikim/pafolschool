<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16
* 작성자: 김종태
* 설  명: 공지사항 라이브러리 생성 파일
*****************************************************************
* 
*/



	$cate = _CATE;

	if(!$cate && $mcode){
	$DB = &WebApp::singleton('DB');
	$sql = "select NUM_CATE from TAB_MENU where num_oid = "._OID." and num_mcode =  "._MCODE." ";
	$cate = $DB -> sqlFetchOne($sql);
	$tpl = &WebApp::singleton('Display'); 
	$tpl->assign(array('cate'=>$cate));


	}

	//if(strlen($cate) ==6) $del ="y";
	if(!$mcode && !$cate){
	$del ="y";
	}
	
	$DB = &WebApp::singleton("DB");
	$t_menu_ = $DB->sqlFetch("SELECT STR_TITLE ,STR_TITLE2 FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_cate=$cate");

	$t_menu = $t_menu_[str_title];
	$t_menu2 = $t_menu_[str_title2];
	$tpl->assign(array(
	 't_menu' => $t_menu,
	't_menu2' => $t_menu2,
	));



	
	
	

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/".$cate.".htm";
/*if(!$cate)  $del = "y";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {*/


$class = $param['class'];
$class_current = $param['class_current'];
	
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');



//echo _LAYOUT_R.'_'.$mou_name;

if(strlen($cate) %2 == 0) {
$psql = " AND num_cate=".substr($cate,0,2)."";	
$_cate = substr($cate,0,2);
}else{
$psql = " AND num_cate=".substr($cate,0,3)."";
$_cate = substr($cate,0,3);
}
	
	$actw = explode(".",$param['setmodule']);
	
if(!_MCODE && WebApp::get($actw[0],array('key'=>'leftmenu'))) {
	//2009-07-31 종태 모듈별 매뉴가 있다면 가저오기
	
	$data = WebApp::get($actw[0],array('key'=>'leftmenu'));
	
	if($param['setmodule']=="/member.join" || $param['setmodule']=="/member.join_step") $current_menu = "회원가입";

}else{





//2009-07-13 종태 상단 링크 얻기
$sql = "SELECT * FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." $psql  ORDER BY num_step) WHERE ROWNUM=1";
$data = $DB->sqlFetch($sql);
list($module_name,$module_type) = explode('#',$data['str_type']);
$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data['num_mcode'],'cate'=>$data['num_cate'],'module_type'=>$module_type));
$link = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];

$tpl->assign(array('backlink'=>$link));






//2009-09-24 종태 상위메뉴가 숨김인지 아닌지;
if(strlen($cate) %2 == 0) {
	$sql = "SELECT num_view FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." AND		num_cate=".substr($cate,0,strlen($cate)-2)."  ORDER BY num_step) WHERE ROWNUM=1";
}else{
	$sql = "SELECT num_view FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." AND		num_cate=".substr($cate,0,strlen($cate)-3)."  ORDER BY num_step) WHERE ROWNUM=1";	
}
$up_num_view = $DB->sqlFetchOne($sql);

if($up_num_view == "0"){
	if(strlen($cate) %2 == 0) {
	$psql = " AND num_cate=".substr($cate,0,strlen($cate)-2)."";	
	$_cate = substr($cate,0,strlen($cate)-2);
	}else{
	$psql = " AND num_cate=".substr($cate,0,strlen($cate)-3)."";
	$_cate = substr($cate,0,strlen($cate)-3);
	}
	
}

				




if($cate) {
	$current_menu_ = $DB->sqlFetch("SELECT STR_TITLE ,STR_TITLE2 FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_cate=$_cate");

	$current_menu = $current_menu_[str_title];
	$current_menu2 = $current_menu_[str_title2];

	
} else {
	
	
	$current_menu = '매인메뉴';
}


			if(!$cate){
			$sql = "SELECT * FROM ".TAB_MENU." ".
			"WHERE num_oid="._OID." AND LENGTH(num_cate)=2  AND num_view=1 $que  ORDER BY num_step";
		
			}else	{
				$sql = "SELECT  * FROM ".TAB_MENU." ".
				"WHERE num_oid="._OID." AND num_cate LIKE '".$_cate."__' AND num_view=1 $que  ORDER BY num_step";
				
			}
	
			


			if($data = $DB->sqlFetchAll($sql)) {

				$total = count($data);
				$tpl->assign(array('total_sub_menu'=>$total));


				for($ii=0; $ii<count($data); $ii++) {
					
					list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);

				
					$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'cate'=>$data[$ii]['num_cate'],'module_type'=>$module_type));

					
					$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
					$data[$ii]['str_target'] = $mdata['menu_target'];
				


						$sql = "SELECT  * FROM ".TAB_MENU." WHERE ".
						"num_oid="._OID." AND num_cate LIKE '".$data[$ii]['num_cate']."__' AND num_view=1  ORDER BY num_step";
						

						if($data_sub =  $DB->sqlFetchAll($sql)) {
							
							for($i=0; $i<count($data_sub); $i++) {

								list($module_name,$module_type) = explode('#',$data_sub[$i]['str_type']);

								$mdata_sub = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$i]['num_mcode'],'cate'=>$data_sub[$i]['num_cate'],'module_type'=>$module_type));
								
								
							
								$data_sub[$i]['str_link'] = is_array($mdata_sub['menu_url']) ? getVarURL($mdata_sub['menu_url'],false) : $mdata_sub['menu_url'];

								$data_sub[$i]['str_target'] = $mdata_sub['menu_target'];
						
							}

							$data[$ii]['SUBMENU_SUB'] = $data_sub;

							$data[$ii]['is_sub'] = true;
						}
					
				}
					
			}


}





$tpl = &WebApp::singleton('Display');

if(count($data) == 0) $data=1;
$is_total = (count($data) * 27) + 84;

$tpl->assign(array('is_total'=>$is_total));

$mlen = strlen($cate);

$tpl->assign(array(
'SUBMENU'      => $data,
'current_menu' => $current_menu,
'current_menu2' => $current_menu2,
 't_menu' => $t_menu,
't_menu2' => $t_menu2,
'cate__1'        => $cate,
'cate_2'        => substr($cate,0,$mlen-2),
'class'        => $class,
'class_current'=> $class_current,

));



$make = "y";
/*} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}*/


unset($param);

?>
