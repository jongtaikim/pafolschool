<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-side-img-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { border:0px solid #e1e1e1; text-align:left; }
.<?=$style_name?> .subject { height:24px; margin:0 0 7px 0; border-bottom:1px solid #e1e1e1; }
.<?=$style_name?> .subject div { margin:5px 0 0 10px;}
.<?=$style_name?> .subject a { font-size:12px; color:#555; font-weight:bold; letter-spacing:-1px; text-decoration:none; }
.<?=$style_name?> .item { clear:both; height:60px; }
.<?=$style_name?> .file { width:80px; height:60px; float:left; }
.<?=$style_name?> .file div { margin:0 0 0 5px; }
.<?=$style_name?> .file-img { width:70px; height:50px; border:1px solid #e2d2e2; }
.<?=$style_name?> .post-subject { padding:5px 5px 0 0; }
.<?=$style_name?> .post-subject a:hover { color:#438A01; text-decoration:underline; }
</style>

<div class="<?=$style_name?>">
<div style="border:1px">
<div class="subject"><div><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>"><?=$board[bo_subject]?></a></div></div>
<? for ($i=0; $i<$rows; $i++) { ?>
<?
$img = "$g4[path]/data/file/$bo_table/thumb/{$list[$i][wr_id]}";
if (!@file_exists($img)) $img = "$g4[path]/data/file/$bo_table/thumbnail/{$list[$i][wr_id]}";
//if (!@file_exists($img)) $img = "{$list[$i][file][0][path]}/{$list[$i][file][0][file]}";
if (!@file_exists($img)) $img = "$latest_skin_path/img/noimage.gif";
if (!$list[$i][wr_id]) $img = "$latest_skin_path/img/noimage.gif";
?>
<div class="item">
    <div class="file"><div><a href="<?=$list[$i][href]?>"><img src="<?=$img?>" class="file-img"></a></div></div>
    <div class="post-subject"><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></div>
</div>
<? } ?>
</div>
</div>

