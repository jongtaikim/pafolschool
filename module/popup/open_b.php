<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ÀÛ¼ºÀÏ: 2009-08-12
* ÀÛ¼ºÀÚ: ±èÁ¾ÅÂ
* ¼³   ¸í: ÆË¾÷¿ÀÇÂ
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





//°³º°ÆË¾÷ Start
$sql = "SELECT * FROM ".TAB_POPUP." 
			WHERE  DT_START_DATE<=".mktime(0,0,0,date("m"),date("d"),date("Y"))." AND DT_END_DATE>=".mktime(0,0,0,date("m"),date("d"),date("Y"))." 
			and str_open in('B','Z')  and str_view='Y'
			order by num_serial desc";
$data1 = $DB -> sqlFetchAll($sql);




for($ii=0; $ii<count($data1); $ii++) {
	$t1 = $data1[$ii];
?>

<script language="Javascript" type="text/javascript">
$(document).ready(function(){
	if(!$.cookie('ck-<?=$t1[num_serial]?>')){
		$('#m3pop-m3pop').css('margin-left','<?=$t1[num_width]/4?>px');
		$('#layer_popup,#layer_popup_ifr,#m3pop-m3pop').width('<?=$t1[num_width]?>').height('<?=$t1[num_height]?>').show();
		$('#layer_popup_ifr').attr('src','/popup.view?boid=<?=$t1[num_width]?>&id=<?=$t1[num_serial]?>');
		$('.btn_ly_close').click(function(){
			$('#m3pop-m3pop').hide();
		});

		$('#num_kill_t').text('<?=$t1[num_kill]?>');
		$('#layer_popup').height('1px');
		$('#chkagree').click(function(){
			$.cookie('ck-<?=$t1[num_serial]?>', '1', { expires : parseInt(<?=$t1[num_kill]?>) });
			$('#m3pop-m3pop').hide();
		});
	}

});
</script>

<? } ?>


