<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
switch ($REQUEST_METHOD) {
	case "GET":
	
	//print_r($_GET);
	//print_r($_POST);
	if($_GET[file]){
		$normal_gallery=GetImageSize($_GET[file]); 
		
	}

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("pedit.htm"));
	$tpl->assign(array(
			'file'=>$_GET[file],
			'img_w'=>$normal_gallery[0],
		));
	 break;
	
	}

?>