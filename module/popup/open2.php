<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : open.php
* : 2005-03-04
* : 
*   :  
*****************************************************************
* : 
<wa:applet module="popup.open"></wa>
*/
include dirname(__FILE__).'/__init__.php';

$http_r = $_SERVER['HTTP_REFERER'];

$popup_file = "/hosts/".HOST."/files/popup/popup.js";

if(!$function_name = $param['function_name']) $function_name = 'openPopup';

	$DB = &WebApp::singleton('DB');
	$sql = "SELECT count(*) FROM ".TAB_POPUP." WHERE NUM_OID="._OID." AND CHR_OPEN='Y' and CHR_TOP_OPEN = 'N'  ";

	$row = $DB -> sqlFetchOne($sql);
	
	if($row > 0) {
		echo "<script type=\"text/javascript\" src=\"/html/popup/open.js\"></script>";
	}
	
	$DB = &WebApp::singleton('DB');
	$sql = "SELECT * FROM ".TAB_POPUP." WHERE NUM_OID="._OID." AND ".mktime()." < DT_END_DATE AND CHR_TOP_OPEN='Y' and  CHR_OPEN in ('N','Y') order by num_serial asc";

	$row = $DB -> sqlFetchAll($sql);

if($row) {
	?>

<script>
function setCookie( name, value, expiredays ) 

{ 

var todayDate = new Date(); 

todayDate.setDate( todayDate.getDate() + expiredays ); 

document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 

} 

function getCookie( name ) 

{ 

var nameOfCookie = name + "="; 

var x = 0; 

while ( x <= document.cookie.length ) 

{ 

var y = (x+nameOfCookie.length); 

if ( document.cookie.substring( x, y ) == nameOfCookie ) { 

if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 

endOfCookie = document.cookie.length; 

return unescape( document.cookie.substring( y, endOfCookie ) ); 

} 

x = document.cookie.indexOf( " ", x ) + 1; 

if ( x == 0 ) 

break; 

} 

return ""; 

} 
	
</script>

	<?
}

for($ii=0; $ii<count($row); $ii++) {
	?>
<script>
if ( getCookie( "popup<?=$row[$ii][num_serial]?>" ) != "done" ) { 



<? if($ii <5) { ?>
	


fensterT('<?=$ii+1?>','<?=$row[$ii][str_title]?>','/popup.view?id=<?=$row[$ii][num_serial]?>&pid=<?=$ii+1?>','<?=5*($ii)+10?>%','<?=5*($ii)+10?>%','<?=$row[$ii][num_width]?>','<?=$row[$ii][num_height]?>')

<? } ?>




} 
	
</script>

<?
}


?>