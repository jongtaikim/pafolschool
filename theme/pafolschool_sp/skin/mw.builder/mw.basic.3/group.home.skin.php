<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style type="text/css">
.group-title { color:#7B7B7B; font-size:11px; height:20px; border-bottom:1px solid #d8d8d8; margin-bottom:10px; font-weight:bold; }
</style>

<table width=100% border=0 cellpadding=0 cellspacing=0 style="margin-top:10px;">
<tr>
    <td width=180 valign=top>
	<div style="margin-bottom:10px;"><?=outlogin("mw.outlogin3")?></div>
	<div class="latest-block"><?=poll("mw.poll")?></div>
	<div class="latest-block"><img src="<?=$mw_group_skin_head_path?>/img/freelancer.gif"></div>
	<div class="latest-block"><img src="<?=$mw_group_skin_head_path?>/img/lsy.gif"></div>
	&nbsp;
    </td>
    <td width=10></td>
    <td valign=top>
	<!--<div class="group-title"><?=$group[gr_subject]?>홈</div>-->
	<?=mw_latest_group("mw.group", $gr_id, 30, 58, 1, $group[gr_cache])?>
	&nbsp;
    </td>
    <td width=10></td>
    <td width=240 valign=top align=center bgcolor="#fafafa" style="border-left:1px solid #e1e1e1;">
	<?=mw_latest_rand("mw.side.img", "B10", 10, 28, 0, $group[gr_cache] )?></div>
	<div class="latest-block"><?=mw_latest("mw.side.list", "B11", 5, 35, 0, $group[gr_cache])?></div>
	<div class="latest-block"><?=mw_latest_tab("mw.tab", "B12, B13, B14", 5, 32, 0, 0)?></div>
	<div class="latest-block"><?=mw_latest_rand("mw.side2.list", "B15", 10, 35, 0, $group[gr_cache])?></div>
	&nbsp;
    </td>
</tr>
<tr>
    <td colspan="5" height="1" bgcolor="#e1e1e1"></td>
</tr>
</table>

</div>

