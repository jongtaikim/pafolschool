<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/main/compose.php
* 작성일: 2005-03-29
* 작성자: 거친마루
* 설  명: 메인화면 구성 마법사
*****************************************************************
* 
*/
$THEME_CONF = Display::getThemeConf();
$main_conf_path = 'hosts/'.HOST.'/conf/main.conf.php';
$MAIN_CONF = Display::getMainConf();

switch (REQUEST_METHOD) {
	case 'GET':
	foreach($MAIN_CONF as $module => $arr) {
			if(!$arr['available']) continue;
			if($arr['required']) {
				$required_components[] = $arr;
			} else {
				$components[] = $arr;
			}
			if($arr['display']) $using_components[] = $arr;//debugs 서종석 display -> display[1]
		}

		
		////////////////////////////////////////////////////////////////////////////////////////////////
				
	$DB = &WebApp::singleton("DB");
	$code = "com";
	if(!$page = $_REQUEST['page']) $page = 1;
	$itemPerPage = 10;


$sql = "SELECT COUNT(*) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=1";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;
$PG = &WebApp::singleton('Paging',$total);
$dummy = $PG->__toString();
$offset = $PG->getOffset();

$sql = "SELECT * FROM (
			SELECT 
				/*+ INDEX_DESC(".TAB_MAIN_BOARD." ".PK_TAB_MAIN_BOARD.") */
				ROWNUM AS rnum,
				STR_CODE,
				NUM_SERIAL,
				STR_TITLE,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				NUM_HIT
			FROM ".TAB_MAIN_BOARD."
			WHERE
                str_code='$code' AND
				rownum<=$offset+$itemPerPage AND
				num_oid=1
		) WHERE rnum>$offset";

if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', WebApp::getTemplate('new_admin/main/compose.htm'));
		$tpl->assign('REQUIRED_COMPONENTS',$required_components);
		$tpl->assign('COMPONENTS',$components);
		$tpl->assign('USING_COMPONENTS',$using_components);
		$tpl->assign('use_attach',$THEME_CONF['attach']['use_attach']);

		
		break;
	case 'POST':
		$using_components = $_POST['using_components'];
		$INI = &WebApp::singleton('IniFile',$main_conf_path);

		foreach ($MAIN_CONF as $module=>$options) {
            $using = in_array($module,$using_components) || $options['required'];
            $INI->setVar('display',$using, $module);
		}
			
		$FTP = &WebApp::singleton('FtpClient', WebApp::getConf('account'));
		$FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$main_conf_path);
		WebApp::redirect($URL->setVar('act','.compose'));
		break;
}




?>