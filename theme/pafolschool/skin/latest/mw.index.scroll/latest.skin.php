<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$rows = count($list);
shuffle($list);
?>
<style type="text/css">
#mw-index-new { position:absolute; width:400px; height:25px; overflow:hidden; }
#mw-index-new-layer { position:absolute; left:0; top:0; height:25px; }
#mw-index-new-layer .item { height:25px; }
#mw-index-new-layer .item div { padding:5px 0 0 0; height:20px; }
#mw-index-new-layer .item a { color:#fff; color:#001e4a; }
#mw-index-new-layer .item a:hover { text-decoration:underline; }
</style>

<div id="mw-index-new">
<div id="mw-index-new-layer">
<? for ($i=0; $i<$rows; $i++) { ?>
<div class="item"><div><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></div></div>
<? } ?>
</div>
</div>

<script type="text/javascript">
var idx_new_time = null;
var idx_new_delay = 5000;
idx_new = document.getElementById("mw-index-new-layer");
idx_new.style.top = "0px";
function new_scroll() {
    var h = 25;
    var t = <?=$rows?>;
    var idx_new_top = parseInt(idx_new.style.top) - 1;
    idx_new.style.top = idx_new_top + "px";
    if (idx_new_top <= (((h * t)-10) * -1)) {
	idx_new_top = 20;
	idx_new.style.top = idx_new_top + "px";
    } else {
	idx_new.style.top = idx_new_top + "px";
    }
    if (idx_new_top % h == 0) {
	idx_new_time = setTimeout("new_scroll()", idx_new_delay);
<? //global $is_admin; if ($is_admin) echo "alert(idx_new_top);" ?>
    } else {
	idx_new_time = setTimeout("new_scroll()", 10);
    }
}
function new_layer_on() {
    clearTimeout(idx_new_time);
}
function new_layer_out() {
    idx_new_time = setTimeout("new_scroll()", idx_new_delay);
}
idx_new_time = setTimeout("new_scroll()", idx_new_delay);
idx_new.onmouseover = function() { new_layer_on(); }
idx_new.onmouseout = function() { new_layer_out(); } 
</script>

