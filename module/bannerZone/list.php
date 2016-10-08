<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: list.php
* �ۼ���: 2005-03-18
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
        $conf = Display::getMainConf('banner');
        
		$sql = "SELECT /*+ INDEX (".TAB_BANNER." ".IDX_TAB_BANNER.") */ NUM_OID,NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE FROM ".TAB_BANNER." WHERE NUM_OID=$_OID";
		if($data = $DB->sqlFetchAll($sql)) {
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
				$data[$i]['str_link'] = stripslashes($data[$i]['str_link']);
			}
		}

		$tpl->setLayout('no4');
		$tpl->define('CONTENT','html/banner/admin/list.htm');
		$tpl->assign(array(
            'LIST'  => $data,
            'width' => $conf['width'],
            'height'=> $conf['height']
        ));
	break;
	
}
?>