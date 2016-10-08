<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<style type="text/css">
.mw-popular { border:1px solid #e1e1e1; text-align:center; }
.mw-popular a:hover { text-decoration:underline; }
.mw-popular .subject { background:url(<?=$popular_skin_path?>/img/box-bg.gif); height:24px; margin:0 0 7px 0; }
.mw-popular .subject { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; text-align:left; }
.mw-popular .subject div { margin:5px 0 0 10px;}
.mw-popular table { margin:0 0 0 5px;}
.mw-popular .word { width:105px; height:16px; overflow:hidden; margin:2px 0 0 5px; }
.mw-popular .gap { letter-spacing:-1px; font-size:11px; }
</style>

<div class="mw-popular">
<div style="border:1px solid #fff;">
<div class="subject"><div>인기검색어</div></div>
<table border=0 cellpadding=0 cellspacing=0>
<? for ($i=0; $i<$pop_cnt; $i++) { ?>
<? if (!is_array($list[$i])) continue; ?>
<tr>
<td width="20" height="20"><img src="<?=$popular_skin_path?>/img/<?=sprintf("%02d", $i+1)?>.gif"></td>
<td width="110">
    <div class="word"><a href="<?=$g4[bbs_path]?>/search.php?sfl=wr_subject&sop=and&stx=<?=urlencode($list[$i][pp_word])?>"><?=$list[$i][pp_word]?></a></div>
</td>
<td width="35">
    <img src="<?=$popular_skin_path?>/img/<?=$list[$i][icon]?>.gif" align=absmiddle>
    <span class="gap"><? if ($list[$i][icon] != "new" && $list[$i][icon] != "nogap") { echo abs($list[$i][rank_gap]); }?></span>
</td>
</tr>
<? } ?>
</table>
</div>
</div>

