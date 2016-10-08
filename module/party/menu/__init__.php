<?

if(!function_exists('getVarURL')) {
function getVarURL($alter="", $flag = true) {
	$buff = array();

	if (ereg('^(\.+)',$alter['act'],&$reg)) {
		$len = $i = strlen($reg[1]);
		$curr = MODULE;

		while ($i-- > 0) {
			$curr = substr($curr,0,strrpos($curr,'.'));
		}
		$alter['act'] = $curr.'.'.substr($alter['act'],$len);
	}

	if (defined('HUMAN_URI')) {
		//unset($alter['act']);
	}

	foreach ($alter as $_key=>$_val){
		if ($_key != 'act') $buff[] = "$_key=$_val";
	}

	return $alter['act'] . (($qs = implode("&",$buff)) ? "?$qs" : '');
}
}
?>