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


$cache_file = 'hosts/'.HOST.'/url.xml';

header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

/*if(!is_file($cache_file)) {*/

	$DB = &WebApp::singleton('DB');
	if(!$_SESSION[ses_mcode]) {
		$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2 AND num_view=1 ORDER BY num_step";

	
		

	}else{

		if(strlen($_SESSION[ses_mcode]) ==3 || strlen($_SESSION[ses_mcode]) ==5 ||strlen($_SESSION[ses_mcode]) == 7 ) {
			$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2 AND num_view=1 ORDER BY num_step";
		}else{
			$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode like '".substr($_SESSION[ses_mcode],0,2)."__' AND num_view=1 ORDER BY num_step";
		}

	}
	$data = $DB->sqlFetchAll($sql);
	
	unset($_SESSION[ses_mcode]);

		
		@array_walk($data,'cb_menuxml_format');
		

		for($ii=0; $ii<count($data); $ii++) {
			

		$sql = "SELECT * FROM ".TAB_MENU."
					WHERE
						NUM_OID=$_OID AND
						NUM_MCODE LIKE '".$data[$ii]['num_mcode']."__' AND
                        num_view=1
					ORDER BY NUM_STEP";
				
				$sub_data = $DB->sqlFetchAll($sql);


	

	if(!$sub_data) { 
	$sub_data = array('0' => array( 'num_oid' => _OID, 'num_step' => "1", 'num_mcode' => $data[$ii]['num_mcode'], 'str_title' => $data[$ii]['str_title'], 'str_type' => $data[$ii]['str_type'], 'num_view' => "1", 'num_enable_remove' => "1"));
	}
				

@array_walk($sub_data,'cb_menuxml_format');
				$data[$ii]['MENUITEM'] = $sub_data;

				for($iii=0; $iii<count($sub_data); $iii++) {
					
							$sql = "SELECT * FROM ".TAB_MENU."
							WHERE
								NUM_OID=$_OID AND
								NUM_MCODE LIKE '".$sub_data[$iii]['num_mcode']."__' AND
								num_view=1
							ORDER BY NUM_STEP";
						
						$sub_sub_data[$iii] = $DB->sqlFetchAll($sql);
						@array_walk($sub_sub_data[$iii],'cb_menuxml_format');
						$data[$ii]['MENUITEM'][$iii]['MENUITEM_SUB'] = $sub_sub_data[$iii];



				}
				
				
		
		}		
		


	
    echo '<?xml version="1.0" encoding="euc-kr"?>';
	//$tpl->setLayout('blank');
	$tpl->define('CONTENT',WebApp::getTemplate('tpl.url.xml'));
	$tpl->assign('MENU',$data);
	$content = $tpl->fetch('CONTENT');

echo $content ;
/*$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);
	$FTP->close();
} else {
   echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
	$tpl->setLayout('blank');
	$tpl->define("!CONTENT",$cache_file);
}*/

function cb_menuxml_format(&$arr) {
	global $URL;
	$mcode = &$arr['num_mcode'];


	
	$arr['str_title'] = htmlspecialchars($arr['str_title']);
	list($module_name,$module_type) = explode('#',$arr['str_type']);
	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$arr['num_mcode'],'module_type'=>$module_type));
	
	if(_OID==20252 && ($mcode==20 || $mcode==21)) {
	$arr['str_link'] = "#";	
	}else{
	$arr['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
	}
	
	$arr['str_target'] = $mdata['menu_target'];
}
?>
