<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : module/filehost/get.php
* : 2005-03-14
* : 
*   : FCKeditor йк   
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
WebApp::import('FileHost');
$phpsessid = $_REQUEST['phpsessid'];
$timestamp = $_REQUEST['timestamp'];
$sect = $_REQUEST['sect'];
$code = $_REQUEST['code'];
$ym_dir = date('Ym',$timestamp);

$sql = "SELECT NUM_SERIAL,STR_FTYPE FROM ".TAB_FILES."
		WHERE
			NUM_OID=$_OID AND
			STR_SECT='$sect' AND
			STR_CODE='$code' AND
			NUM_MAIN=-2 AND
			STR_REFILE='$phpsessid.$timestamp'";
$fdata = $DB->sqlFetch($sql);
$id = $fdata['num_serial'];
$ftype = $fdata['str_ftype'];
$str_refile = "$ym_dir/$code.-1.$id.$timestamp.$ftype";
$sql = "UPDATE ".TAB_FILES." SET STR_REFILE='$str_refile'
		WHERE
			NUM_OID=$_OID AND
			STR_SECT='$sect' AND
			STR_CODE='$code' AND
			NUM_MAIN=-2 AND
			NUM_SERIAL=$id";

if(!$DB->query($sql)) {
	$FH = &WebApp::singleton('FileHost',$sect);
	$FH->delete($str_refile);
	$FH->close();

	$sql = "DELETE FROM ".TAB_FILES."
			WHERE
				NUM_OID=$_OID AND
				STR_SECT='$sect' AND
				STR_CODE='$code' AND
				NUM_MAIN=-2 AND
				NUM_SERIAL=$id";
	$DB->query($sql);
	$DB->commit();
	echo "alert('Upload Failed');";
} else {
	$DB->commit();
	echo "parent.maxImageWidth=650;\n	parent.setImage('http://".$_REQUEST['FILE_HOST']."/hosts/$_OID/$sect/$str_refile');";
}
?>