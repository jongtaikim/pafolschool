<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-12
* 작성자: 김종태
* 설   명: 팝업오픈
*****************************************************************
* 
*/

include dirname(__FILE__).'/__init__.php';

$http_r = $_SERVER['HTTP_REFERER'];
$popup_file = "/hosts/".HOST."/files/popup/popup.js";
if(!$function_name = $param['function_name']) $function_name = 'openPopup';

$DB = &WebApp::singleton("DB");


switch (_STYPE) {
	case "E":
	$psql = " and str_e = 'Y' ";
	 break;
	case "M":
	$psql = " and str_m = 'Y' ";
	break;
	case "H":
	$psql = " and str_h = 'Y' ";
	break;

	}





//개별팝업 Start
$sql = "SELECT * FROM ".TAB_POPUP." 
			WHERE  DT_START_DATE<=".mktime(0,0,0,date("m"),date("d"),date("Y"))." AND DT_END_DATE>=".mktime(0,0,0,date("m"),date("d"),date("Y"))." 
			and str_open in('A','Z')  and str_view='Y'
			order by num_serial desc";
$data1 = $DB -> sqlFetchAll($sql);




$row =  $data1;

if($row) {
?>

<script type="text/javascript">
// <![CDATA[
$('.btn_ly_close').show();
$('#layer_popup_title').hide();
// ]]>
</script>


<script language="Javascript" type="text/javascript">
$(document).ready(function(){
	$('#layer_popup').m3popup('/popup.view?boid=<?=$row[0][num_oid]?>&id=<?=$row[0][num_serial]?>', {'type':'ifr3','width':'<?=$row[0][num_width]?>','height':'<?=$row[0][num_height]?>','closer':'true','position':'fixed'});
	$('#layer_popup_title').text('팝업창 안내 공지').show();
});
</script>

<?}//개별팝업 End?>


