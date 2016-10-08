<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$style_name = "mw-latest-list-img-$bo_table-$rows-$subject_len";
?>
<style type="text/css">
.<?=$style_name?> { border:0px solid #000; padding:0; margin:0; }
.<?=$style_name?> .item { display:inline; float:left; width:50px; height:90px; border:0px solid #000; margin:5px 0 0 7px; }
.<?=$style_name?> .file-img { width:49px; height:49px; border:1px solid #e2e2e2; }
.<?=$style_name?> .post-subject { width:50px; height:40px; overflow:hidden; }
.<?=$style_name?> .post-subject a { font-family:dotum; letter-spacing:-1px; font-size:10px; }
.<?=$style_name?> .post-subject a:hover { color:#438A01; text-decoration:underline; }
</style>

<div class="<?=$style_name?>">
<div style="clear:both"></div>
<? for ($i=0; $i<$rows; $i++) { ?>
<?
$img = "$g4[path]/data/file/$bo_table/thumb/{$list[$i][wr_id]}";
if (!@file_exists($img)) $img = "$g4[path]/data/file/$bo_table/thumbnail/{$list[$i][wr_id]}";
if (!@file_exists($img)) {
    $img = "{$list[$i][file][0][path]}/{$list[$i][file][0][file]}";
    $ext = strtolower(substr($img, strlen($img)-3, 3));
    if (!($ext == "gif" || $ext == "jpg" || $ext == "png")) $img = "";
}
if (!@file_exists($img)) $img = "$latest_skin_path/img/noimage.gif";
if (!$list[$i][wr_id]) $img = "$latest_skin_path/img/noimage.gif";
if (@is_dir($img)) $img = "$latest_skin_path/img/noimage.gif";
?>
    <div class="item">
        <div class="post-img"><a href="<?=$list[$i][href]?>"><img src="<?=$img?>" class="file-img"></a></div>
        <div class="post-subject"><a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a></div>
    </div>
<? } ?>
<div style="clear:both"></div>
</div>

