<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-24
* 작성자: 김종태
* 설   명: 기본실행될 global
*****************************************************************
* 
*/


$DB = &WebApp::singleton('DB');
//2008-12-04 현민 여기에서 인트라넷에서 적용된 사이트운영설정, 운영만료일이 적용된다!!



	if(!$_SESSION[_ORGAN]){

	$organdb = $DB->sqlFetch("select 
	*
	 from TAB_ORGAN where num_oid = $_OID ");

	$_SESSION[_ORGAN] = $organdb;
	}else{
	 $organdb = $_SESSION[_ORGAN];
	}

	$tpl->assign(array('HOMETYPE'=>$organdb[str_hometype]));
	define('_HOMETYPE', $organdb[str_hometype]);

	$tpl->assign(array('HG_CD'=>$organdb[str_hg_code],'TYPE'=>$organdb[str_hometype]));

	if($organdb[str_st] == '2'){	 //접근제한
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('err_denied.htm'));
		$tpl->printAll();
		exit;
	}else if($organdb[str_st] == '3'){	 //공사중표시
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('err_setting.htm'));
		$tpl->printAll();
		exit;

	}else if($organdb[str_st] == '4'){	 //폐쇄(삭제아님)
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('err_delete.htm'));
		$tpl->printAll();
		exit;
	}

	if($organdb[str_end_date] && ($organdb[str_end_date] < date("Y-m-d"))){
		//여긴 만료일 경과햇음.. 
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('404.htm'));
		$tpl->printAll();
		exit;
	}
	//여기까지가 사이트운영설정 적용끝~
	define('_STYPE', $organdb[str_school]);

	if (is_file($module) && is_dir("hosts/".$HOST)) include $module;
	else {
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', 'html/404.htm');
	}


if($cate) {
	$_cate = $cate;
	while(strlen($_cate = substr($_cate,0,-2)) > 1) {
		$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=$_cate");
	}
	$_location[] = '';
	$menu_location = implode(' > ',array_reverse($_location));
	$menu_location2 = implode(' <img src="/dot1.gif"> ',array_reverse($_location));
	$menu_location4 = implode('<img src="/dot1.gif">',array_reverse($_location));
	$menu_location5 = implode('&nbsp;>&nbsp;',array_reverse($_location));
	$menu_location6 = implode('&nbsp;>&nbsp;',array_reverse($_location));

	
	
	$tpl->assign(array(
		'menu_location2' => "HOME<img src=/dot1.gif>&nbsp;&nbsp;".$menu_location,
		'menu_location3' => "HOME&nbsp;&nbsp;".$menu_location2." <img src='/dot1.gif'> ".$target_page,
		'menu_location4' => "HOME&nbsp;&nbsp;".$menu_location4."<img src='/dot1.gif'>".$target_page,
		'menu_location5' => $menu_location5,
		'menu_location6' => $menu_location6,
		));

	 $URL = &WebApp::singleton('WebAppURL');
	 
	  if(strlen($cate) >=4 ){
		 if(strlen($cate) ==4 ) $_cate = $cate;
		 if(strlen($cate) ==6 ) $_cate = substr($cate,0,4);

		 $sql = "SELECT  * FROM ".TAB_MENU." ".
		"WHERE num_oid="._OID." AND num_cate LIKE '".$_cate."__' AND num_view=1 $que  ORDER BY num_step";

		if($datas = $DB->sqlFetchAll($sql)) {

			for($ii=0; $ii<count($datas); $ii++) {

				list($module_name,$module_type) = explode('#',$datas[$ii]['str_type']);
				$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$datas[$ii]['num_mcode'],'cate'=>$datas[$ii]['num_cate'],'module_type'=>$module_type));
				$datas[$ii]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
				$datas[$ii]['str_target'] = $mdata['menu_target'];
			}
		
			$tpl->assign(array('SUBMenus'=>$datas));
		}
	}
	
}

if($ccode){
	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$row));

	$left_html = Display::getTemplate("lms/tab.htm");
	$tpl->define("TAB", $left_html);
}


$tpl->assign(array('TOP_EDIT'=>$top_edit));

//2008-01-06 종태 지금 모듈을 템플릿에서도 call 할 수 있도록..
if($_SERVER[REDIRECT_QUERY_STRING]) {
	$act3 = 	$_SERVER[REDIRECT_URL]."?".$_SERVER[REDIRECT_QUERY_STRING];
}else{
	$act3 = 	$_SERVER[REDIRECT_URL];
}



if($_GET[mcode]){ 
	$_SESSION[ses_mcode] = $_GET[mcode]; 
	$_SESSION[ses_mcode2] = $_GET[mcode]; 
}else{
	if($act =="menu.xml" || $act =="url2.xml" ||$act =="url.xml" ||$act =="top_menu.main") {
		unset($_SESSION[ses_mcode]);
		unset($_SESSION[ses_mcode2]);
	}
}


	$tpl->assign(array('rr_url'=>$rr_url));

	$tpl->assign(array(
		'act'      => $_SERVER[REDIRECT_URL]."?".$_SERVER[REDIRECT_QUERY_STRING]  , 
		'act2'      => $_SERVER[REDIRECT_URL] , 
		'act3'      => $act3 , 
	    ));



//회사 아이피에 머시가 달리게 2008-03-28 종태 (체팅방을 위한 처리)
if(check_edumark_ip()) {
	$tpl->assign(array('sadmin'=>"Y"));
}


if($act=="main"){ 
	$layout_r = "main"; 
}else{
	if(!$_SESSION[$mcode][layout]){
		$layout_r = "sub"; 
	}else{

		$layout_r = str_replace("@","",$_SESSION[$mcode][layout]);
	}
}




define('_LAYOUT_R',$layout_r);

$tpl->assign(array(
'mcode'=>$mcode,
));


function _la($text){
	return $text;
}



function getVarURL($alter="", $flag = true) {
	$buff = array();

	if (ereg('^(\.+)',$alter['act'],&$reg)) {
		$len = $i = strlen($reg[1]);
		$curr = MODULE;

		while ($i-- > 0) {
			$curr = substr($curr,0,strrpos($curr,'.'));
		}
		$alter['act'] = $curr.'.'.substr($alter['act'],$len);
	}

	if (defined('HUMAN_URI')) {
		//unset($alter['act']);
	}

	foreach ($alter as $_key=>$_val){
		if ($_key != 'act') $buff[] = "$_key=$_val";
	}

	return $alter['act'] . (($qs = implode("&",$buff)) ? "?$qs" : '');
}



?>