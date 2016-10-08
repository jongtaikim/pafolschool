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


$cache_file = 'hosts/'.HOST.'/cate.xml';

header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");


	$DB = &WebApp::singleton('DB');
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2 AND num_view=1 ORDER BY num_step";
	if($data = $DB->sqlFetchAll($sql)) {
		@array_walk($data,'cb_menuxml_format');
		foreach ($data as $key => $row) {
			$sql = "SELECT * FROM ".TAB_MENU."
					WHERE
						NUM_OID=$_OID AND
						NUM_MCODE LIKE '".$row['num_mcode']."__' AND
                        num_view=1
					ORDER BY NUM_STEP";
			if($sub_data = $DB->sqlFetchAll($sql)) {
				@array_walk($sub_data,'cb_menuxml_format');
				$data[$key]['MENUITEM'] = $sub_data;
			}
		}
	}
    echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
	$tpl->setLayout('blank');
	$tpl->define('CONTENT',WebApp::getTemplate('tpl.cate.xml'));
	$tpl->assign('MENU',$data);
	$content = $tpl->fetch('CONTENT');

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);
	$FTP->close();


$num = 0;

function cb_menuxml_format(&$arr) {
	global $URL, $num;
	
	if(!$num) $num = 0;
	
	for($ii=0; $ii<10; $ii++) {
	$color_data[] = "26BAB7";// 매뉴 컬러 배열	
	$color_data[] = "6DBF00";// 매뉴 컬러 배열	
	$color_data[] = "C8BA00";// 매뉴 컬러 배열	
	}
		

	$arr['str_color'] = $color_data[$num];

	$mcode = &$arr['num_mcode'];
    $arr['str_title'] = htmlspecialchars(" ".$arr['str_title']." ");
	list($module_name,$module_type) = explode('#',$arr['str_type']);
	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$arr['num_mcode']));
	$arr['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
	$arr['str_target'] = $mdata['menu_target'];
	$num++;
}
?>
