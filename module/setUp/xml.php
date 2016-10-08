<?
$cache_file = 'hosts/'.HOST.'/setUp.xml';

header('Content-type: text/xml; charset=euc_kr');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");




  echo '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
	$tpl->setLayout('blank');
	$tpl->define('CONTENT',WebApp::getTemplate('tpl.setUp.xml'));
	$tpl->assign(array(
	'link1'=>_LINK1,
		'link2'=>_LINK2,
		'link3'=>_LINK3,
	));
	$content = $tpl->fetch('CONTENT');



?>
