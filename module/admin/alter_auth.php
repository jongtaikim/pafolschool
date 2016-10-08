<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : alter_auth.php
* : 2005-02-14
* : 
*   : 
*****************************************************************
* 
*/

function check_edumark_ip() {
	$except = array(
		'1','4'
	);

	$REMOTE_ADDR = getenv('REMOTE_ADDR');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	if ($ipbase == '125.7.183' && ($iptail >= 1 && $iptail <= 10)) return (!in_array($iptail,$except));
	return false;
}
if(check_edumark_ip()) $_SESSION['ADMIN'] = true;
return $_SESSION['ADMIN'];
?>
