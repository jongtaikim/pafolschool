<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/menu/xml.php
* 작성일: 2005-03-29
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/


$cache_file = 'hosts/'.HOST.'/menu.xml';

header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");



if(!is_file($cache_file)) {
	$DB = &WebApp::singleton('DB');
	$tabidx = 1;
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_cate)=2 AND num_view=1 ORDER BY num_step";
	if($data = $DB->sqlFetchAll($sql)) {

		for($ii=0; $ii<count($data); $ii++) {
			

		$data[$ii]['str_title'] = htmlspecialchars($data[$ii]['str_title']);
		list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);
		$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'module_type'=>$module_type,'cate'=>$data[$ii]['num_cate']));
		$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
		$data[$ii]['str_target'] = $mdata['menu_target'];
		
		$data[$ii]['tabindex'] = $tabidx;
		$tabidx++;
			

			$sql = "SELECT * FROM ".TAB_MENU."
					WHERE
						NUM_OID=$_OID AND
						num_cate LIKE '".$data[$ii]['num_cate']."__' AND
                        num_view=1
					ORDER BY NUM_STEP";
			if($data[$ii]['MENUITEM'] = $DB->sqlFetchAll($sql)) {
				
				for($i=0; $i<count($data[$ii]['MENUITEM']); $i++) {

				 		$data[$ii]['MENUITEM'][$i]['str_title'] = htmlspecialchars($data[$ii]['MENUITEM'][$i]['str_title']);
						list($module_name,$module_type) = explode('#',$data[$ii]['MENUITEM'][$i]['str_type']);
						$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['MENUITEM'][$i]['num_mcode'],'module_type'=>$module_type,'cate'=>$data[$ii]['MENUITEM'][$i]['num_cate']));
						$data[$ii]['MENUITEM'][$i]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
						$data[$ii]['MENUITEM'][$i]['str_target'] = $mdata['menu_target'];

						$data[$ii]['MENUITEM'][$i]['tabindex'] = $tabidx;
						$tabidx++;
					
				}
				
			}
	

				
		
		}
	}
	

    echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
	$tpl->setLayout('blank');
	$tpl->define('CONTENT',WebApp::getTemplate('tpl.menu.xml'));
	$tpl->assign('MENU',$data);
	$content = $tpl->fetch('CONTENT');


	unset($_SESSION[ses_mcode]);
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);
	$FTP->close();
} else {
   echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
	$tpl->setLayout('blank');
	$tpl->define("!CONTENT",$cache_file);
}

function cb_menuxml_format(&$arr) {
	global $URL;
	$mcode = &$arr['num_mcode'];
    $arr['str_title'] = htmlspecialchars($arr['str_title']);
	list($module_name,$module_type) = explode('#',$arr['str_type']);
	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$arr['num_mcode'],'cate'=>$arr['num_cate'],'module_type'=>$module_type));
	$arr['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
	$arr['str_target'] = $mdata['menu_target'];

}


?>
