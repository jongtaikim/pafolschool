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
$tpl = &WebApp::singleton('Display');
$template = Display::getTemplate("tpl.log.htm");

if($mode){
	 $sql = "delete from ".TAB_ORDER_DATA_LOG." WHERE num_oid = '"._OID."' and num_date=$date and str_code = '".$code."'";

	 if($DB->query($sql)){
		 $DB->commit();
		
	 }
	 WebApp::moveBack();
	 exit;
}

if($str_text){
	$indata[num_oid] = _OID;
	$indata[num_date] = mktime();
	$indata[str_code] = $code;
	$indata[str_text] = $str_text;
	$indata[str_name] = $str_name;
	$DB->insertQuery("TAB_ORDER_DATA_LOG",$indata);
	
	WebApp::moveBack();
	exit;
}	
	


	if(!$code) $code = $param[code];
	$tpl->assign(array('log_code'=>$code));
	
	

	if($code){
		$sql = "select * from  TAB_ORDER_DATA_LOG  where  num_oid = '"._OID."' and str_code = '".$code."' order by num_date desc ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('log_LIST'=>$row));
	}

	$tpl->define('log_W_',$template);
	$content = $tpl->fetch('log_W_');
	echo $content;

?>