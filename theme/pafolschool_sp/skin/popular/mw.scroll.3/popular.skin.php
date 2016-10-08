<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

global $mwus;
?>
<style type="text/css">
#mw-scroll-layer { width:196px; height:25px; position:relative; overflow:hidden; }
#mw-popular-scroll { position:absolute; }
#mw-popular-scroll table { margin:0; padding:0; width:190px; }
#mw-popular-scroll td { margin:0; height:25px; }
#mw-popular-scroll a { color:#fff; }
#mw-popular-scroll a:hover { color:#fff; text-decoration:underline; }
#mw-popular-scroll .gap { color:#fff; font-size:11px; letter-spacing:-1px;  }
#mw-popular-scroll .word { width:120px; height:16px; overflow:hidden; margin:2px 0 0 5px; }

#mw-popular-hidden { position:absolute; display:none; background-color:#fff; width:206px; background-color:#d0d7f1; z-index:200; }
#mw-popular-hidden table { width:180px; }
#mw-popular-hidden td { margin:0; height:20px; }
#mw-popular-hidden .gap { color:#444; font-size:11px; letter-spacing:-1px;  }
#mw-popular-hidden .word { width:120px; height:16px; overflow:hidden; margin:2px 0 0 5px; }
#mw-popular-hidden .word a { color:#444; }
#mw-popular-hidden .word a:link { color:#444; }
#mw-popular-hidden .word a:visited { color:#444; }
#mw-popular-hidden .word a:active { color:#444; }
#mw-popular-hidden .word a:hover { color:#444; text-decoration:underline; }
</style>

<div id="mw-scroll-layer">
<div id="mw-popular-scroll">
<table border=0 cellpadding=0 cellspacing=0>
<? for ($i=0; $i<$pop_cnt; $i++) { ?>
<? if (!is_array($list[$i])) continue; ?>
<tr>
<td width="15"><img src="<?=$popular_skin_path?>/img/<?=sprintf("%02d", $i+1)?>.gif"></td>
<td>
    <div class="word"><a href="<?=$mwus[path]?>/?stx=<?=urlencode($list[$i][pp_word])?>"><?=$list[$i][pp_word]?></a></div>
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

<div id="mw-popular-hidden">
<div style="margin:3px; background-color:#fff; padding:5px 0 10px 10px;">
<table border=0 cellpadding=0 cellspacing=0>
<? for ($i=0; $i<$pop_cnt; $i++) { ?>
<? if (!is_array($list[$i])) continue; ?>
<tr onmouseover="this.style.backgroundColor='#f1f1f1'" onmouseout="this.style.backgroundColor='#ffffff'">
<td width="15"><img src="<?=$popular_skin_path?>/img/<?=sprintf("%02d", $i+1)?>.gif"></td>
<td>
    <div class="word"><a href="<?=$mwus[path]?>/?stx=<?=urlencode($list[$i][pp_word])?>"><?=$list[$i][pp_word]?></a></div>
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

<script type="text/javascript">
var phtime = null;
var kstime = null;
var d = 2000;
sl = document.getElementById("mw-scroll-layer");
ks = document.getElementById("mw-popular-scroll");
ph = document.getElementById("mw-popular-hidden");
ks.style.top = "0px";
function keyword_scroll() {
    if (phtime) { 
	clearTimeout(phtime);
	ph.style.display = "none";
	phtime = null;
    }
    var h = 25;
    var t = <?=$pop_cnt?>;
    var kst = parseInt(ks.style.top) - 1;
    ks.style.top = kst + "px";
    if (kst <= (((h * t)-10) * -1)) {
	kst = 20;
	ks.style.top = kst + "px";
    } else {
	ks.style.top = kst + "px";
    }
    if (kst % h == 0) {
	kstime = setTimeout("keyword_scroll()", d);
    } else {
	kstime = setTimeout("keyword_scroll()", 10);
    }
}
function keyword_layer() {
    clearTimeout(kstime);
    clearTimeout(phtime);
    kstime = phtime = null;
    ph.style.display = "block";
    ph.style.top = get_top_pos(sl);
}
function keyword_layer_on() {
    clearTimeout(phtime);
    clearTimeout(kstime);
    kstime = phtime = null;
}
function keyword_layer_out() {
    phtime = setTimeout("keyword_scroll()", 100);
}
setTimeout("keyword_scroll()", d);
ks.onmouseover = function() { keyword_layer(); }
ks.onmouseout = function() { keyword_layer_out(); }
ph.onmouseover = function() { keyword_layer_on(); } 
ph.onmouseout = function() { keyword_layer_out(); } 
</script>

