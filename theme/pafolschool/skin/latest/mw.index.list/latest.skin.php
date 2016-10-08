<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-list-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { border:1px solid #e1e1e1; text-align:left; }
.<?=$style_name?> .subject { background:url(<?=$latest_skin_path?>/img/box-bg.gif); height:24px; margin:0 0 7px 0; }
.<?=$style_name?> .subject .bo_table { margin:5px 0 0 5px; float:left; }
.<?=$style_name?> .subject .bo_table a { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> .subject .list { margin:5px 5px 0 0; float:right; }
.<?=$style_name?> .subject .list a { font-weight:normal; font-size:11px; letter-spacing:-1px; color:#555; }
.<?=$style_name?> ul { margin:0 0 5px 7px; padding:0; list-style:none; }
.<?=$style_name?> ul li { margin:0; padding:0 0 0 7px; background:url(<?=$latest_skin_path?>/img/dot.gif) no-repeat 0 5px; height:20px; }
.<?=$style_name?> ul li a:hover { color:#438A01; text-decoration:underline; }
.<?=$style_name?> .file-img { width:100px; height:65px; border:1px solid #e2e2e2; }
.<?=$style_name?> .file-subject { line-height:15px; font-size:11px; letter-spacing:-1px; width:100px; height:28px; margin:3px 0 0 0; overflow:hidden; }
.<?=$style_name?> .file a:hover { color:#438A01; text-decoration:underline; }
</style>

<div class="<?=$style_name?>">
<div style="border:1px solid #fff">
<div class="subject">
<div class="bo_table"><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><?=$board[bo_subject]?></a></div>
<div class="list"><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><img src="<?=$latest_skin_path?>/img/l.gif" aling="absmiddle"> 목록</a></div>
</div>

<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if ($is_img && $file[0]) { ?>
<td width=120 align=center class=file>
    <a href="<?=$file[0][href]?>"><div><img src="<?=$file[0][path]?>" class="file-img"></div> <div class="file-subject"><?=$file[0][subject]?></div></a>
</td>
<? }  ?>
<td valign=top>
    <ul>
    <?
    $r = rand(0, $rows-1);
    for ($i=0; $i<$rows; $i++) {
    if ($r == $i) $list[$i][subject] = "<strong>".$list[$i][subject]."</strong>";
    if ($list[$i][icon_secret]) $list[$i][subject] .= "&nbsp;&nbsp;" . $list[$i][icon_secret];
    if ($list[$i][icon_file]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_file];
    if ($list[$i][icon_new]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_new];
    //if ($list[$i][icon_hot]) $list[$i][subject] .= "&nbsp;" . $list[$i][icon_hot];
    ?>
    <li><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></li>
    <? } ?>
    </ul>
</td>
</tr>
</table>


</div>
</div>

