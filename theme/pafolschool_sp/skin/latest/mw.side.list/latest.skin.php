<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-side-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { text-align:left; border:0px solid #e1e1e1; }
.<?=$style_name?> .subject { margin:0; }
.<?=$style_name?> .subject div { margin:5px 0 0 10px;}
.<?=$style_name?> .subject a { font-size:12px; color:#555; color:#145daa; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> ul { margin:0 5px 5px 5px; padding:7px 0 5px 0; list-style:none; border:1px solid #e1e1e1; background-color:#fff; }
.<?=$style_name?> ul li { margin:0 0 0 7px; padding:0 0 0 7px; background:url(<?=$latest_skin_path?>/img/dot.gif) no-repeat 0 7px; height:20px; }
.<?=$style_name?> ul li a:hover { color:#438A01; text-decoration:underline; }
.<?=$style_name?> .comment { font-size:10px; color:#FF6600; font-family:dotum; }
</style>

<div class="<?=$style_name?>">
<div class="subject"><div><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><?=$board[bo_subject]?></a></div></div>
<ul>
<? for ($i=0; $i<$rows; $i++) { ?>
<li><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?> <span class="comment"><?=$list[$i][comment_cnt]?></span></a></li>
<? } ?>
</ul>
</div>

