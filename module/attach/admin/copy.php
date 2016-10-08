<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-02-13
* 작성자: 김종태
* 설  명: 스킨선택프로그램
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");

$_css_file = '/hosts/'.HOST.'/'.$a.'_'.$_CSS.'_css.htm';
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.$_css_file);
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$a.'_'.$_CSS.'_align.htm');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$a.'_'.$_CSS.'_Pcss.htm');

$_css_file = '/hosts/'.HOST.'/'.$b.'_'.$_CSS.'_css.htm';

$FTP->delete(_DOC_ROOT.$_css_file);
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$b.'_'.$_CSS.'_align.htm');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$b.'_'.$_CSS.'_Pcss.htm');




$sql = "delete from TAB_CSS  where num_oid = '$_OID' and num_serial = '"._CSS."' and str_layout = '".$a."' ";
 $DB->query($sql);
 $DB->commit();


$sql = "delete from TAB_ATTACH_CONFIG  where num_oid = '$_OID' and num_css = '"._CSS."' and str_layout = '".$a."' ";
 $DB->query($sql);
 $DB->commit();



$sql = "select * from TAB_CSS where num_oid = '$_OID' and num_serial = '"._CSS."' and str_layout = '".$b."' ";
$one_data = $DB -> sqlFetchAll($sql);


$sql = "select * from TAB_ATTACH_CONFIG where num_oid = '$_OID' and num_css = '"._CSS."' and str_layout = '".$b."' ";
$one_data2 = $DB -> sqlFetchAll($sql);


$one_data[0][str_layout] = $a;
$DB-> insertQuery("TAB_CSS",$one_data[0]);
 $DB->commit();


for($ii=0; $ii<count($one_data2); $ii++) {
$one_data2[$ii][str_layout] = $a;	
$DB-> insertQuery("TAB_ATTACH_CONFIG",$one_data2[$ii]);
 $DB->commit();

}




 include dirname(__FILE__).'/makelayer.php';
makelayer($layout);
WebApp::moveBack('레이아웃을 반드시 저장해주시기 바랍니다.');

?>