<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "SELECT /*+ INDEX (".TAB_BANNER." ".IDX_TAB_BANNER.") */ NUM_OID,NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
	if($data = $DB->sqlFetchAll($sql)) {
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			$data[$i]['str_link'] = stripslashes($data[$i]['str_link']);
		}
	}



	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("bannerZone/main_view.htm"));
	$tpl->assign(array(
            'LIST'  => $data,
            'width' => $conf['width'],
            'height'=> $conf['height']
        ));
		

	 break;
	case "POST":
	 break;
	}

?>