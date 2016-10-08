<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-list-img-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { border:1px solid #e1e1e1; }
.<?=$style_name?> .subject { background:url(<?=$latest_skin_path?>/img/box-bg.gif); height:24px; margin:0 0 7px 0; }
.<?=$style_name?> .subject .bo_table { margin:5px 0 0 5px; float:left; }
.<?=$style_name?> .subject .bo_table a { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> .subject .list { margin:5px 5px 0 0; float:right; }
.<?=$style_name?> .subject .list a { font-weight:normal; font-size:11px; letter-spacing:-1px; color:#555; }
.<?=$style_name?> .file { width:130px; height:80px; padding-bottom:5px; }
.<?=$style_name?> .file-img { width:120px; height:80px; border:1px solid #e2e2e2; }
.<?=$style_name?> .post-subject { width:115px; height:35px; overflow:hidden; padding:5px 5px 0 0; letter-spacing:-1px; font-size:11px; }
.<?=$style_name?> .post-subject a:hover { color:#438A01; text-decoration:underline; }
</style>

<div class="<?=$style_name?>">
<div style="border:1px solid #fff">
<div class="subject">
<div class="bo_table"><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><?=$board[bo_subject]?></a></div>
<div class="list"><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><img src="<?=$latest_skin_path?>/img/l.gif" aling="absmiddle"> 목록</a></div>
</div>
<table border=0 cellpadding=0 cellspacing=0 align=center>
<tr>
<? for ($i=0; $i<$rows; $i++) { ?>
<?
$img = "$g4[path]/data/file/$bo_table/thumb/{$list[$i][wr_id]}";
if (!@file_exists($img)) $img = "$g4[path]/data/file/$bo_table/thumbnail/{$list[$i][wr_id]}";
if (!@file_exists($img)) $img = "{$list[$i][file][0][path]}/{$list[$i][file][0][file]}";
if (!@file_exists($img)) $img = "$latest_skin_path/img/noimage.gif";
if (!$list[$i][wr_id]) $img = "$latest_skin_path/img/noimage.gif";
if (@is_dir($img)) $img = "$latest_skin_path/img/noimage.gif";
?>
<td align=center valign=top class=file>
    <div class="post-img"><a href="<?=$list[$i][href]?>"><img src="<?=$img?>" class="file-img"></a></div>
    <div class="post-subject"><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></div>
</td>
<? } ?>
</tr>
</table>
</div>
</div>

