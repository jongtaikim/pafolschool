<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16
* 작성자: 김종태
* 설  명: 카페서브메뉴
*****************************************************************
* 
*/


$_mcode =_MCODE;
$_pcode = _PCODE;
$mou_name = "submenu";

if(!$_pcode) {
	$_pcode = $pcode;
}
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

//echo _LAYOUT_R.'_'.$mou_name;

//2008-04-17 종태 라이브러리를 위해서

if($mode == "lib") $template = "/html/party/menu/submenu_lib.htm"; else $template = "/html/party/menu/submenu.htm";

$sql = "SELECT /*+ INDEX(".TAB_PARTY_MENU." ".IDX_TAB_PARTY_MENU_INDEX.") */ * FROM ".TAB_PARTY_MENU." ".
		"WHERE num_oid="._OID."  and num_pcode = ".$_pcode."AND LENGTH(num_mcode)=2 AND num_view=1 $que  ORDER BY num_step";
		if($data = $DB->sqlFetchAll($sql)) {
			for($iia=0; $iia<count($data); $iia++) {
				list($module_name,$module_type) = explode('#',$data[$iia]['str_type']);
				$module_name = "party.board";

				$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['num_mcode'],'pcode'=>$data[$iia]['num_pcode'],'module_type'=>$module_type));
				$sql = "select str_skin from TAB_PARTY_BOARD_CONFIG where num_oid = "._OID." and num_pcode = ".$_pcode." and num_mcode = ".$data[$iia]['num_mcode']." ";
				$data[$iia]['str_skin_type'] = $DB -> sqlFetchOne($sql);

				
				
				//$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
				$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
				
			}
		}




$tpl = &WebApp::singleton('Display');

if(count($data) == 0) $data=1;
$is_total = (count($data) * 27) + 84;

$tpl->assign(array('is_total'=>$is_total));

$mlen = strlen($mcode);

$tpl->define("SUBMENU_AREA",$template);
$tpl->assign(array(


'SUBMENU'      => $data,
'current_menu' => $current_menu,
'current_menu2' => $current_menu2,
'mcode__1'        => $mcode,
'mcode_2'        => substr($mcode,0,$mlen-2),
'class'        => $class,
'class_current'=> $class_current,

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





?>
