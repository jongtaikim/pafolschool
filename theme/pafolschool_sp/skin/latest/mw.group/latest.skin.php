<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-group-$bo_table-$rows-$subject_len";
?>
<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<style type="text/css">
.<?=$style_name?> { border:0px solid #e1e1e1; text-align:left; }
.<?=$style_name?> .top-box { border:4px solid #76c4de; border:4px solid #eee; margin:0 0 15px 0; }
.<?=$style_name?> .top-box .in { border:1px solid #ddd; padding:10px 0 5px 10px; }
.<?=$style_name?> .subject { background:url(<?=$latest_skin_path?>/img/box-bg.gif); height:24px; margin:0 0 7px 0; }
.<?=$style_name?> .subject .bo_table { margin:5px 0 0 5px; float:left; }
.<?=$style_name?> .subject .bo_table a { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> .subject .list { margin:5px 5px 0 0; float:right; }
.<?=$style_name?> .subject .list a { font-weight:normal; font-size:11px; letter-spacing:-1px; color:#555; }
.<?=$style_name?> ul { margin:5px 0 0 7px; padding:0; list-style:none; }
.<?=$style_name?> ul li { margin:0; padding:0 0 0 7px; background:url(<?=$latest_skin_path?>/img/dot.gif) no-repeat 0 7px; height:25px; }
.<?=$style_name?> ul li { font-size:13px;  }
.<?=$style_name?> ul li a { font-size:13px; }
.<?=$style_name?> ul li a:hover { color:#438a01; text-decoration:underline; }
.<?=$style_name?> .file-img { width:120px; height:90px; border:1px solid #e2e2e2; }
.<?=$style_name?> .file-subject { line-height:15px; font-size:11px; letter-spacing:-1px; width:100px; height:28px; margin:3px 0 0 0; overflow:hidden; }
.<?=$style_name?> .file a:hover { color:#438A01; text-decoration:underline; }
.<?=$style_name?> .line { font-size:1px; line-height:1px; height:1px; border-bottom:1px dotted #e1e1e1; margin-bottom:10px; }
.<?=$style_name?> .bo_table { font-size:11px; color:#eee; }
.<?=$style_name?> .bo_table a { font-size:11px; color:#aaa; }
.<?=$style_name?> .comment { color:#ff6600; font-size:10px; letter-spacing:-1px; }
</style>

<div class="<?=$style_name?>">

<?
for ($a=0; $a<$rows/5; $a++) {
    if ($a > 1) echo "<div class='line'></div>"; 
    if ($a == 0) echo "<div class='top-box'><div class='in'>";
?>

<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if ($is_img && $a==0 && $file[0]) { ?>
<td width=140 align=center class=file>
    <a href="<?=$file[$a][href]?>"><div><img src="<?=$file[$a][path]?>" class="file-img"></div> <div class="file-subject"><?=$file[$a][subject]?></div></a>
</td>
<? }  ?>
<td valign=top>
    <ul>
    <?
    $s = $a*5;
    $e = ($a+1)*5;
    $r = rand($s, $e-1);
    for ($i=$s; $i<$e; $i++) {
    if ($a==0 && strlen($list[$i][subject]) > 36) $list[$i][subject] = cut_str($list[$i][subject], 36); 
    //if ($r == $i) $list[$i][subject] = "<strong>".$list[$i][subject]."</strong>"; // 랜덤 bold
    $list[$i][subject] = "<strong>".$list[$i][subject]."</strong>";
    //if ($list[$i][wr_comment]) $list[$i][subject] .= "&nbsp;<span class='comment'>[{$list[$i][wr_comment]}]</span>"; // 코멘트 수
    if ($list[$i][icon_secret]) $list[$i][subject] .= "&nbsp;&nbsp;" . $list[$i][icon_secret];
    if ($list[$i][icon_file]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_file];
    if ($list[$i][icon_new]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_new];
    if ($list[$i][icon_hot]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_hot];
    if ($i % 2) $cls = "class='bg'"; else $cls = "";
    ?>
    <li><?//=$list[$i][name]?> <a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a>
	<span class="bo_table"> | <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$list[$i][bo_table]?>"><?=$list[$i][bo_subject]?></a></span></li>
    <? } ?>
    </ul>
</td>
</tr>
</table>

<?
    if ($a == 0) echo "</div></div>";
}
?>


</div>

