<?

$tpl->setLayout('admin');

if($mode == "1") {
	
$tpl->define('CONTENT',WebApp::getTemplate('new_admin/index2.htm'));

}else{



$tpl->define('CONTENT',WebApp::getTemplate('new_admin/index.htm'));
}
?>