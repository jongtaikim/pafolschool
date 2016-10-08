<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16
* 작성자: 김종태
* 설  명: 공지사항 라이브러리 생성 파일
*****************************************************************
* 
*/

$fcode = $_REQUEST['fcode'] ? $_REQUEST['fcode'] : '';
$pcode = $_REQUEST['pcode'] ? $_REQUEST['pcode'] : '';
$class = $param['class'];
$class_current = $param['class_current'];
$mou_name = "submenu";
	
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$tpl->assign($conf);
$tpl->assign($conf_main);

$cache_file = 'hosts/'.HOST.'/menu/'.$_cate.'.htm';

//echo _LAYOUT_R.'_'.$mou_name;

 $conf['skin'] = "IN1";

//2008-04-17 종태 라이브러리를 위해서
if($conf['skin']) $theme_name = $conf['skin']; else $theme_name = $conf_main['skin'];
$template = $param['template'];
if ($theme_name) $template = "/theme_lib/".$mou_name."/".$theme_name."/attach.".$mou_name."_no.htm";




//2008-12-16 현민 최상단메뉴가 있을경우 3depth 가 나오게한다.

if(_LAYOUT_R !="main" && (strlen(_MCODE) == 2 || strlen(_MCODE) == 4 || strlen(_MCODE) == 6)) {

$sql = "select count(*) from TAB_ATTACH_CONFIG where num_oid = "._OID." and num_css = '"._CSS."' and str_name = 'sub_top_menu' and str_layout = '"._LAYOUT_R."' and str_layer !='NONE' ";
$ifsubMenu = $DB -> sqlFetchOne($sql);
}
if($ifsubMenu>0) $menulen = 2;
else $menulen = 0;



if(strlen($cate) %2 == 0){
	$_cate = substr($cate,0,2+$menulen);
	$psql = " AND num_mcode=".substr($cate,0,2)."";
}else{
	$_cate = substr($cate,0,3+$menulen);
	$psql = " AND num_mcode=".substr($cate,0,3)."";
}

$sql = "SELECT * FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." $psql  ORDER BY num_step) WHERE ROWNUM=1";
$data = $DB->sqlFetch($sql);

//echo $sql;

list($module_name,$module_type) = explode('#',$data['str_type']);
$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data['num_mcode'],'module_type'=>$module_type));
$link = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];

$tpl->assign(array('backlink'=>$link));

$cache_file = 'hosts/'.HOST.'/menu/'.$_cate.'.htm';
        		
if($_cate != '_') {
	$current_menu = $DB->sqlFetchOne("SELECT STR_TITLE FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_cate");
	 $current_menu2 = $DB->sqlFetchOne("SELECT STR_TITLE2 FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_cate");
} else {
	
	/*추가메뉴 상단 타이틀 부분 값 삭제 9/13일 author=박종호*/
	$current_menu = '';
}

$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
"WHERE num_oid="._OID." AND num_cate LIKE '".$_cate."__' AND num_view=1 $que  ORDER BY num_step";

if($data = $DB->sqlFetchAll($sql)) {

	$total = count($data);
	$tpl->assign(array('total_sub_menu'=>$total));


	for($ii=0; $ii<count($data); $ii++) {
		
		list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);

		$mk = date("Y-m-d",mktime() - 169200);
		$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data[$ii]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

		$data[$ii][new_img] = $DB -> sqlFetchOne($sql);

		/*$sql = "select count(dt_date) from TAB_BOARD_COMMENT where num_oid = '"._OID."'  and num_mcode  = '".$data[$ii]['num_mcode']."' and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

		$data[$ii][new_img] = $DB -> sqlFetchOne($sql);*/
		//$data[$ii][new_img] = "Y";

		$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'cate'=>$data[$ii]['num_cate'],'module_type'=>$module_type));

		//$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
		$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
		$data[$ii]['str_target'] = $mdata['menu_target'];
		//$data[$ii]['class'] = $extra_data['class'];

		if(strlen($data[$ii]['num_mcode']) <= 5) {

			$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
			"num_oid="._OID." AND num_cate LIKE '".$data[$ii]['num_cate']."__' AND num_view=1  ORDER BY num_step";

			if($data_sub =  $DB->sqlFetchAll($sql)) {

				for($i=0; $i<count($data_sub); $i++) {

					$mk = date("Y-m-d",mktime() - 169200);
					$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data_sub[$i]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";
					$data_sub[$i][new_img] = $DB -> sqlFetchOne($sql);
					/*$sql = "select count(dt_date) from TAB_BOARD_COMMENT where num_oid = '"._OID."'  and num_mcode  = '".$data_sub[$i]['num_mcode']."' and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";
					$data_sub[$i][new_img2] = $DB -> sqlFetchOne($sql);*/

					list($module_name,$module_type) = explode('#',$data_sub[$i]['str_type']);

					$mdata_sub = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$i]['num_mcode'],'cate'=>$data_sub[$i]['num_cate'],'module_type'=>$module_type));

					//$data_sub[$i]['str_link'] = is_array($mdata_sub['menu_url']) ? $URL->setVar($mdata_sub['menu_url'],false) : $mdata_sub['menu_url'];
					$data_sub[$i]['str_link'] = is_array($mdata_sub['menu_url']) ? getVarURL($mdata_sub['menu_url'],false) : $mdata_sub['menu_url'];

					$data_sub[$i]['str_target'] = $mdata_sub['menu_target'];
					//$data[$ii]['class'] = $extra_data['class'];

				}

				$data[$ii]['SUBMENU_SUB'] = $data_sub;

				$data[$ii]['is_sub'] = true;
			}
		}
	}
		
}else{
	


	if(!$cate) {
		$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
		"WHERE num_oid="._OID." AND LENGTH(num_cate)=2 AND num_view=1 $que  ORDER BY num_step";
		if($data = $DB->sqlFetchAll($sql)) {
			for($iia=0; $iia<count($data); $iia++) {
				list($module_name,$module_type) = explode('#',$data[$iia]['str_type']);

				$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['num_mcode'],'cate'=>$data[$iia]['num_cate'],'module_type'=>$module_type));

				//$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
				$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
				$data[$iia]['str_target'] = $mdata['menu_target'];
			}
		}
	}
}


$tpl = &WebApp::singleton('Display');

if(count($data) == 0) $data=1;
$is_total = (count($data) * 27) + 84;

$tpl->assign(array('is_total'=>$is_total));

$mlen = strlen($cate);

//스탁 하단 처리
$tpl->define("STOCK_FOOT", '/theme_lib/submenu/stock_foot.htm');


$tpl->define("SUBMENU_AREA",$template);
$tpl->assign(array(


'SUBMENU'      => $data,
'current_menu' => $current_menu,
'current_menu2' => $current_menu2,
'mcode__1'        => $cate,
'mcode_2'        => substr($cate,0,$mlen-2),
'class'        => $class,
'class_current'=> $class_current,
'mcode'=> _MCODE,
));
$content = $tpl->fetch("SUBMENU_AREA");

/*    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
$FTP->mkdir('menu');
}
$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);

}*/

echo $content;

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
