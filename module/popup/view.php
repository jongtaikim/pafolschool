<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : view.php
* : 2005-03-15
* : 
*   : 
*****************************************************************
* 
*/

?>

<style type="text/css" title="">
body{margin:0px;padding:0px}
</style> 

<?

if(!$id = $_REQUEST['id']) exit;

	$DB = &WebApp::singleton('DB');
	$sql = "SELECT  * FROM ".TAB_POPUP." WHERE NUM_OID='"._OID."'  AND NUM_SERIAL=$id ";
	
	if($data = $DB->sqlFetch($sql)) {
		$data['id'] = &$data['num_serial'];
		$skin = $data['str_skin'];
		echo $data[str_text];


	} else {
		$content = "";
	}

?>

   