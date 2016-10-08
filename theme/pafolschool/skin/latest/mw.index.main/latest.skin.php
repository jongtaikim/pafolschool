<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$top_line = 3;
$count = count($main) - 1;
?>

<style type="text/css">
.mw-latest-main-subject { clear:both; background:url(<?=$latest_skin_path?>/img/main-bar-bg.gif); height:25px; letter-spacing:-1px; }
.mw-latest-main-subject .today { float:left; margin:5px 0 0 5px; color:#444; letter-spacing:0; }
.mw-latest-main-subject div.tab { float:right; background:url(<?=$latest_skin_path?>/img/main-bar-off.gif); height:25px; }
.mw-latest-main-subject div.tab-on { float:right; background:url(<?=$latest_skin_path?>/img/main-bar-on.gif); height:25px; }
.mw-latest-main-subject div.link { margin:5px 5px 0 5px; } 
.mw-latest-main-subject div.div { float:right; height:25px; }
.mw-latest-main { clear:both; border-left:1px solid #e1e1e1; border-right:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; }
.mw-latest-main ul { margin:5px 0 5px 7px; padding:0; list-style:none; }
.mw-latest-main ul li { margin:0; padding:0 0 0 7px; background:url(<?=$latest_skin_path?>/img/dot.gif) no-repeat 0 5px; height:20px; }
.mw-latest-main ul li a:hover { color:#438A01; text-decoration:underline; }
.mw-latest-main .file-img { width:100px; height:65px; border:1px solid #e2e2e2; }
.mw-latest-main .file-subject { line-height:15px; font-size:11px; letter-spacing:-1px; width:100px; height:27px; margin:3px 0 0 0; overflow:hidden; }
.mw-latest-main .file a:hover { color:#438A01; text-decoration:underline; }
.mw-latest-main .line { font-size:1px; line-height:1px; background-color:#e1e1e1; margin-bottom:7px; }
</style>

<div class="mw-latest-main-subject">
<div class="today">
<img src="<?=$latest_skin_path?>/img/icon_clock.gif" align="absmiddle">
<span id="mw-today"></span><span id="mw-time"></span>
<!--&nbsp;<?=date("m.d", $g4[server_time])?> (<?=get_yoil($g4[server_time])?>)-->
</div><div class="div"><img src="<?=$latest_skin_path?>/img/main-bar-div.gif"></div>
<? for ($i=$count-1; $i>-1; $i--) { ?>
<div class="tab" id="main-<?=($i+1)?>" onmouseover="tab_over(<?=$i+1?>)" onmouseout="tab_over_cancel()">
<div class="link"><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_tables[$i]?>"><?=$main[$bo_tables[$i]]['board']['bo_subject']?></a></div>
</div><div class="div"><img src="<?=$latest_skin_path?>/img/main-bar-div.gif"></div>
<? } ?>
<div class="tab-on" id="main-0" onmouseover="tab_over(0)" onmouseout="tab_over_cancel()">
<div class="link"><a href="<?=$g4[bbs_path]?>/new.php">종합</a></div>
</div><div class="div"><img src="<?=$latest_skin_path?>/img/main-bar-div.gif"></div>
</div>

<div class="mw-latest-main">
<div style="border:1px solid #fff">

<div id="latest-main-0">
<?
$list = $main['main'];
$files = $main['main']['file'];

for ($i=0; $i<$multiple; $i++) { // 종합
    $file = $files[$i];
?>

<div id="main-sub-<?=$i?>" <? if ($i!=0) echo "style='display:none'";?> >

<div style="float:right; margin:10px 5px 0 0;">
<img src="<?=$latest_skin_path?>/img/btn_prev.gif" style="cursor:pointer;" onclick="main_sub_prev()">
<img src="<?=$latest_skin_path?>/img/btn_next.gif" style="cursor:pointer;" onclick="main_sub_next()">
</div>

<ul style="margin-top:5px;">
<?
$s = $rows * $i;
$e = ($rows * $i) + $top_line;
$r = rand($s, $e-1);
for ($j=$s; $j<$e; $j++) {
if ($r == $j) $list[$j][subject] = "<strong>".$list[$j][subject]."</strong>";
?>
<li><a href="<?=$list[$j][href]?>"><?=$list[$j][subject]?></a>&nbsp;</li>
<? } ?>
</ul>
<div class="line">&nbsp;</div>

<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if ($file) { ?>
<td width=120 align=center class=file>
<a href="<?=$file[href]?>"><div><img src="<?=$file[path]?>" class="file-img"></div><div class="file-subject"><?=$file[subject]?></div></a>
</td>
<? }  ?>
<td valign=top>
<ul> 
<?
$s = ($rows * $i) + $top_line;
$e = $rows * ($i + 1);
$r = rand($s, $e-1);
for ($j=$s; $j<$e; $j++) {
if ($r == $j) $list[$j][subject] = "<strong>".$list[$j][subject]."</strong>";?>
<li><a href="<?=$list[$j][href]?>"><?=$list[$j][subject]?></a></li>
<? } ?> 
</ul>
</td>
</tr>
</table>

</div>

<? } ?>
</div>

<? // 게시판 시작
$index = 1;
if ($count > 0) {
    foreach ($main as $bo_table => $list) {
	if ($bo_table == 'main') continue;
	$file = $main[$bo_table]['file'];
	$board = $main[$bo_table]['board'];
?>
<div id="latest-main-<?=$index?>" style="display:none;">
<ul style="margin-top:5px;">
<?
$r = rand(0, $top_line-1);
for ($i=0; $i<$top_line; $i++) {
if ($r == $i) $list[$i][subject] = "<strong>".$list[$i][subject]."</strong>";?>
<li><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></li><? } ?>
</ul>
<div class="line">&nbsp;</div>

<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if ($file) { ?>
<td width=120 align=center class=file>
<a href="<?=$file[href]?>"><div><img src="<?=$file[path]?>" class="file-img"></div><div class="file-subject"><?=$file[subject]?></div></a>
</td>
<? }  ?>
<td valign=top>
<ul> 
<?
$r = rand($top_line, $rows-1);
for ($i=$top_line; $i<$rows; $i++) {
if ($r == $i) $list[$i][subject] = "<strong>".$list[$i][subject]."</strong>";?>
<li><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></li>
<? } ?> 
</ul>
</td>
</tr>
</table>

</div>

<?
$index++; } }
?>

</div>
</div>

<script type="text/javascript">
function tab_over(i) {
    main_tab_val = setTimeout("tab_over_action(" + i + ")", 500);
}

function tab_over_cancel() {
    clearTimeout(main_tab_val);
}

function tab_over_action(i) {
<? for ($i=0; $i<=$count; $i++) { ?>
document.getElementById("main-<?=$i?>").className = "tab"; 
//document.getElementById("main-<?=$i?>").style.fontWeight = "normal"; 
document.getElementById("latest-main-<?=$i?>").style.display = "none"; 
<? } ?>
document.getElementById("main-" + i).className = "tab-on"; 
//document.getElementById("main-" + i).style.fontWeight = "bold"; 
document.getElementById("latest-main-" + i).style.display = "block"; 
}

var main_sub_auto_time = 3000;
var main_sub_idx = 0;

function main_sub_prev() {
    main_sub_next(-1);
}

function main_sub_next(val) {
var max = <?=$multiple-1?>;

if (val < 0)
    main_sub_idx--;
else
    main_sub_idx++;

if (main_sub_idx < 0)
    main_sub_idx = max;
else if (main_sub_idx > max)
    main_sub_idx = 0;

<? for ($s=0; $s<$multiple; $s++) { ?>
document.getElementById("main-sub-<?=$s?>").style.display = "none";
<? } ?>
document.getElementById("main-sub-" + main_sub_idx).style.display = "block";

}

function main_sub_auto() {
    sub_auto_val = setInterval("main_sub_next()", main_sub_auto_time);
}

main_sub_auto();
document.getElementById("latest-main-0").onmouseout = function() { main_sub_auto() };
document.getElementById("latest-main-0").onmouseover = function() { clearInterval(sub_auto_val) };

mw_timer_init = <?=time()*1000?>;
function mw_timer() {
    mw_timer_init += 1000;
    var date = new Date(mw_timer_init);
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var time = date.toLocaleTimeString();
    var wstr = "일월화수목금토";
    var week = wstr.substr(date.getDay(),1);
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    //var str = month + "월 " + day + "일 " + "(" + week + ") ";
    var str = month + "." + day + " (" + week + ") ";
    document.getElementById("mw-today").innerHTML =  str;
    document.getElementById("mw-time").innerHTML = time;
    setTimeout("mw_timer()", 1000);
}
mw_timer();
</script>

