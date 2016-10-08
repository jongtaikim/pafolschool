<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-side-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { text-align:left; border:0px solid #e1e1e1; }
.<?=$style_name?> .subject { height:24px; margin:0 0 7px 0; border-bottom:1px solid #e1e1e1; }
.<?=$style_name?> .subject div { margin:5px 0 0 10px;}
.<?=$style_name?> .subject a { font-size:12px; color:#555; color:#145daa; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> ul { margin:0 0 7px 7px; padding:0; list-style:none; }
.<?=$style_name?> ul li { margin:0; padding:0 0 0 7px; background:url(<?=$latest_skin_path?>/img/dot.gif) no-repeat 0 7px; line-height:20px; }
.<?=$style_name?> ul li a:hover { color:#438A01; text-decoration:underline; }
.<?=$style_name?> .file-img { width:100px; height:65px; border:1px solid #e2d2e2; }
.<?=$style_name?> .file-subject { line-height:15px; font-size:11px; letter-spacing:-1px; width:100px; height:27px; margin:3px 0 0 0; overflow:hidden; }
.<?=$style_name?> .file a:hover { color:#438A01; text-decoration:underline; }
</style>

<div class="<?=$style_name?>">
<div style="border:0px solid #fff">
<div class="subject"><div><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><?=$board[bo_subject]?></a></div></div>
<table border=0 cellpadding=0 cellspacing=0>
<tr>
<? if ($is_img && $file[0]) { ?>
<td width=120 align=center class=file>
<a href="<?=$file[0][href]?>"><div><img src="<?=$file[0][path]?>" class="file-img"></div>
<div class="file-subject"><?=$file[0][subject]?></div></a>
</td>
<? }  ?>
<td valign=top>
<ul>
<? for ($i=0; $i<$rows; $i++) { ?>
<li><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></li>
<? } ?>
</ul>
</td>
</tr>
</table>
</div>
</div>

