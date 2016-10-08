<?
/**
 * Bechu-Basic Skin for Gnuboard4
 *
 * Copyright (c) 2008 Choi Jae-Young <www.miwit.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$board_skin_path/mw.lib/mw.skin.basic.lib.php");

// 링크게시판
if ($mw_basic[cf_link_board] && !$is_admin) {
    goto_url("board.php?bo_table=$bo_table$qstr");
}

$prev_wr_subject = str_replace("\"", "'", $prev_wr_subject);
$next_wr_subject = str_replace("\"", "'", $next_wr_subject);

if ($is_admin && strstr($write[wr_option], "secret")) {
    // 잠금 해제 버튼
    $nosecret_href = "javascript:btn_nosecret();";
} else if ($is_admin) {
    // 잠금 버튼
    $secret_href = "javascript:btn_secret();";
}

// 파일로그
if ($mw_basic[cf_download_log] && $is_admin) {
    $download_log_href = "javascript:btn_download_log()";
}

// 로그버튼
if ($mw_basic[cf_post_history] && $member[mb_level] >= $mw_basic[cf_post_history_level]) {
    $history_href = "javascript:btn_history($wr_id)";
}

// 신고 버튼
if ($mw_basic[cf_singo]) {
    $singo_href = "javascript:btn_singo($wr_id, $wr_id)";
}

// 인쇄 버튼
if ($mw_basic[cf_print]) {
    $print_href = "javascript:btn_print()";
}

// 쓰기버튼 항상 출력
if ($mw_basic[cf_write_button])
    $write_href = "./write.php?bo_table=$bo_table";

// 글쓰기 버튼 공지
if ($write_href && $mw_basic[cf_write_notice]) {
    $write_href = "javascript:btn_write_notice('$write_href');";
}

// RSS 버튼
$rss_href = "";
if ($board[bo_use_rss_view])
    $rss_href = "./rss.php?bo_table=$bo_table";

// 파일 출력
ob_start();
for ($i=0; $i<=$view[file][count]; $i++) {
    if ($mw_basic[cf_img_1_noview] && $i==0) continue;
    if ($view[file][$i][view]) {
        if ($board[bo_image_width] < $view[file][$i][image_width]) { // 이미지 크기 조절
            $img_width = $board[bo_image_width];
        } else {
            $img_width = $view[file][$i][image_width];
        }
        $view[file][$i][view] = str_replace("<img", "<img width=\"{$img_width}\"", $view[file][$i][view]);

	if ($mw_basic[cf_exif]) {
	    $view[file][$i][view] = str_replace("image_window(this)", "show_exif($i, this, event)", $view[file][$i][view]);
	    $view[file][$i][view] = str_replace("title=''", "title='클릭하면 메타데이터를 보실 수 있습니다.'", $view[file][$i][view]);
	} else {
	    $view[file][$i][view] = str_replace("onclick='image_window(this);'", 
		"onclick='mw_image_window(this, {$view[file][$i][image_width]}, {$view[file][$i][image_height]});'", $view[file][$i][view]);
	    // 제나빌더용 (그누보드 원본수정으로 인해 따옴표' 가 없음;)
	    $view[file][$i][view] = str_replace("onclick=image_window(this);", 
		"onclick='mw_image_window(this, {$view[file][$i][image_width]}, {$view[file][$i][image_height]});'", $view[file][$i][view]); 
	}
        echo $view[file][$i][view] . "<br/><br/>";
    }
}
$file_viewer = ob_get_contents();
ob_end_clean();

$view[rich_content] = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view[content]);

// 웹에디터 이미지 클릭시 원본 사이즈 조정
$data = $view[rich_content];
preg_match_all("/<img\s+name='target_resize_image\[\]' onclick='image_window\(this\)'.*src=\"(.*)\"/iUs", $data, $matchs);
for ($i=0; $i<count($matchs[1]); $i++) {
    $match = $matchs[1][$i];
    if (strstr($match, $g4[url])) { // 웹에디터로 첨부한 이미지 뿐 아니라 다양한 상황을 고려함.
        $path = str_replace($g4[url], "..", $match);
    } elseif (substr($match, 0, 1) == "/") {
        $path = $_SERVER[DOCUMENT_ROOT].$match;
    } else {
        $path = $match;
    }
    $size = @getimagesize($path);
    if ($size[0] && $size[1]) {
        $match = str_replace("/", "\/", $match);
        $match = str_replace(".", "\.", $match);
        $match = str_replace("+", "\+", $match);
        $pattern = "/(onclick=[\'\"]{0,1}image_window\(this\)[\'\"]{0,1}) (.*)(src=\"$match\")/iU";
        $replacement = "onclick='mw_image_window(this, $size[0], $size[1])' $2$3";
        if ($size[0] > $board[bo_image_width])
            $replacement .= " width=\"$board[bo_image_width]\"";
        $data = preg_replace($pattern, $replacement, $data);
    }
}
$view[rich_content] = $data;

// 추천링크 방지
$view[rich_content] = preg_replace("/bbs\/good\.php\?/i", "#", $view[rich_content]);

$view[rich_content] = mw_set_sync_tag($view[rich_content]);

// 조회수, 추천수, 비추천수 컴마
if ($mw_basic[cf_comma]) {
    $view[wr_hit] = number_format($view[wr_hit]);
    $view[wr_good] = number_format($view[wr_good]);
    $view[wr_nogood] = number_format($view[wr_nogood]);
}

// 컨텐츠샵
$mw_price = "";
if ($mw_basic[cf_contents_shop]) {
    if (!$view[wr_contents_price])
	$mw_price = "무료";
    else
	$mw_price = $mw_cash[cf_cash_name] . " " . number_format($view[wr_contents_price]).$mw_cash[cf_cash_unit];
}
?>

<script type="text/javascript" src="<?="$board_skin_path/mw.js/jquery-1.3.2.min.js"?>"></script>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/jquery-ui.js"?>"></script>

<link rel="stylesheet" href="<?=$board_skin_path?>/style.common.css?<?=time()?>" type="text/css">

<? if ($mw_basic[cf_source_copy]) { // 출처 자동 복사 ?>
<? $copy_url = set_http("{$g4[url]}/{$g4[bbs]}/board.php?bo_table={$bo_table}&wr_id={$wr_id}"); ?>
<script type="text/javascript" src="<?=$board_skin_path?>/mw.js/autosourcing.open.compact.js"></script>
<style type="text/css">
DIV.autosourcing-stub { display:none }
DIV.autosourcing-stub-extra { position:absolute; opacity:0 }
</style>
<script type="text/javascript">
AutoSourcing.setTemplate("<p style='margin:11px 0 7px 0;padding:0'> <a href='{link}' target='_blank'> [출처] {title} - {link}</a> </p>");
AutoSourcing.setString(<?=$wr_id?> ,"<?=$config[cf_title];//$view[wr_subject]?>", "<?=$view[wr_name]?>", "<?=$copy_url?>");
AutoSourcing.init( 'view_%id%' , true);
</script>
<? } ?>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td id=mw_basic>

<? include_once("$board_skin_path/mw.proc/mw.list.hot.skin.php"); ?>

<!-- 링크 버튼 -->
<?
ob_start();
?>
<table width=100%>
<tr height=35>
    <td>
        <? if ($search_href) { echo "<a href=\"$search_href\"><img src='$board_skin_path/img/btn_search_list.gif' border='0' align='absmiddle'></a> "; } ?>
        <? echo "<a href=\"$list_href\"><img src='$board_skin_path/img/btn_list.gif' border='0' align='absmiddle'></a> "; ?>

        <? if ($write_href) { echo "<a href=\"$write_href\"><img src='$board_skin_path/img/btn_write.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($reply_href) { echo "<a href=\"$reply_href\"><img src='$board_skin_path/img/btn_reply.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($update_href) { echo "<a href=\"$update_href\"><img src='$board_skin_path/img/btn_update.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($delete_href) { echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_delete.gif' border='0' align='absmiddle'></a> "; } ?>

        <? //if ($good_href) { echo "<a href=\"$good_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_good.gif' border='0' align='absmiddle'></a> "; } ?>
        <? //if ($nogood_href) { echo "<a href=\"$nogood_href\" target='hiddenframe'><img src='$board_skin_path/img/btn_nogood.gif' border='0' align='absmiddle'></a> "; } ?>

        <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle'></a> "; } ?>

    </td>
    <td align=right>
        <? if ($prev_href) { echo "<input type=image src=\"$board_skin_path/img/btn_prev.gif\" onclick=\"location.href='$prev_href'\" title=\"$prev_wr_subject\" accesskey='b'>&nbsp;"; } ?>
        <? if ($next_href) { echo "<input type=image src=\"$board_skin_path/img/btn_next.gif\" onclick=\"location.href='$next_href'\" title=\"$next_wr_subject\" accesskey='n'>&nbsp;"; } ?>
    </td>
</tr>
</table>
<?
$link_buttons = ob_get_contents();
ob_end_flush();
?>

<!-- 제목, 글쓴이, 날짜, 조회, 추천, 비추천 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td height=2 class=mw_basic_line_color></td></tr>
<tr>
    <td class=mw_basic_view_subject>
        <? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?>
        <?=cut_hangul_last(get_text($view[wr_subject]))?> <?=$view[icon_secret]?>
    </td>
</tr>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td height=30 class=mw_basic_view_title>
	<? if ($mw_basic[cf_contents_shop]) { // 배추 컨텐츠샵 ?>
	<strong>가격</strong> : 
	<span class="mw_basic_contents_price"><?=$mw_price?></span>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<? } ?>
        <? if ($mw_basic[cf_attribute] != "anonymous") { ?>
        글쓴이 : 
	<span class=mw_basic_view_name> <?=$view[name]?>
	<? if ($is_ip_view) { ?>
	&nbsp;(<?=$ip?>)
        <? if ($is_admin) { ?> <img src="<?=$board_skin_path?>/img/btn_ip.gif" align=absmiddle title='IP조회' style="cursor:pointer" onclick="btn_ip('<?=$view[wr_ip]?>')"> <? } ?>
	<? } ?>
	</span>
        <? } ?>
        날짜 : <span class=mw_basic_view_datetime><?=substr($view[wr_datetime],0,10)." (".get_yoil($view[wr_datetime]).") ".substr($view[wr_datetime],11,5)?></span>
        조회 : <span class=mw_basic_view_hit><?=$view[wr_hit]?></span>
        <? if ($is_good) { ?>추천 : <span class=mw_basic_view_good><?=$view[wr_good]?></span><?}?>
        <? if ($is_nogood) { ?>비추천 : <span class=mw_basic_view_nogood><?=$view[wr_nogood]?></span><?}?>
        <? if ($singo_href) { ?><a href="<?=$singo_href?>" class=mw_basic_view_singo><img src="<?=$board_skin_path?>/img/btn_singo2.gif" align=absmiddle title='신고'></a><?}?>
        <? if ($print_href) { ?><a href="<?=$print_href?>"><img src="<?=$board_skin_path?>/img/btn_print.gif" align=absmiddle title='인쇄'></a><?}?>
    </td>
</tr>

<?
if ($mw_basic[cf_umz]) { // 짧은 글주소 사용 
    if ($write[wr_umz] == "") {
	$url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id";
	$umz = umz_get_url($url);
	sql_query("update $write_table set wr_umz = '$umz' where wr_id = '$wr_id'");
	$view[wr_umz] = $umz;
    }
?>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td height=30 class=mw_basic_view_title>
        글주소 : <input type="text" class="umz_url" onclick="get_umz_url(this)" value="<?=$view[wr_umz]?>">
	<script type="text/javascript">
	function get_umz_url(obj) {
	    obj.select();
	    if (g4_is_ie) {
		document.selection.createRange().execCommand("copy");
		alert("글주소가 복사되었습니다.");
	    }
	}
	</script>
    </td>
</tr>

<? } ?>

<?
if ($mw_basic[cf_shorten]) { // 짧은 글주소 사용 - 자체도메인
    $shorten = "$g4[url]/$bo_table/$wr_id";
?>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td height=30 class=mw_basic_view_title>
        글주소 : <input type="text" class="shorten" onclick="get_shorten(this)" value="<?=$shorten?>">
	<script type="text/javascript">
	function get_shorten(obj) {
	    obj.select();
	    if (g4_is_ie) {
		document.selection.createRange().execCommand("copy");
		alert("글주소가 복사되었습니다.");
	    }
	}
	</script>
    </td>
</tr>
<? } ?>


<? if ($mw_basic[cf_include_file_head]) { echo "<tr><td>"; @include_once($mw_basic[cf_include_file_head]); echo "</td></tr>"; } ?>

<? if ($mw_basic[cf_file_head]) { echo "<tr><td>$mw_basic[cf_file_head]</td></tr>"; } ?>
<?
// 가변 파일
$cnt = 0;
for ($i=0; $i<count($view[file]); $i++) {
    if ($view[file][$i][source] && !$view[file][$i][view]) {
        $cnt++;
?>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td class=mw_basic_view_file>
        <img src="<?=$board_skin_path?>/img/icon_file_down.gif" align=absmiddle>
        <a href="javascript:file_download('<?=$view[file][$i][href]?>', '<?=$view[file][$i][source]?>');" title="<?=$view[file][$i][content]?>"><?=$view[file][$i][source]?></a>
        <span class=mw_basic_view_file_info> (<?=$view[file][$i][size]?>), Down : <?=$view[file][$i][download]?>, <?=$view[file][$i][datetime]?></span>
    </td>
</tr>
<?
    }
}

// 링크
$cnt = 0;
for ($i=1; $i<=$g4[link_count]; $i++) {
    if ($view[link][$i]) {
        $cnt++;
        $link = cut_str($view[link][$i], 70);
?>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td class=mw_basic_view_link>
        <img src='<?=$board_skin_path?>/img/icon_link.gif' align=absmiddle>
        <a href='<?=$view[link_href][$i]?>' target=_blank><?=$link?></a>
        <span class=mw_basic_view_link_info>(<?=$view[link_hit][$i]?>)</span>
    </td>
</tr>
<?
    }
}
?>

<? if ($mw_basic[cf_file_tail]) { echo "<tr><td>$mw_basic[cf_file_tail]</td></tr>"; } ?>

<? if ($mw_basic[cf_include_file_tail]) { echo "<tr><td>"; @include_once($mw_basic[cf_include_file_tail]); echo "</td></tr>"; } ?>

<? if ($is_admin || $mw_basic[cf_contents_shop]) { ?>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr>
    <td height=40>
	<? if ($mw_basic[cf_contents_shop]) { // 배추컨텐츠샵 ?>
	<script type="text/javascript" src="<?=$mw_cash[path]?>/cybercash.js"></script>
	<script type="text/javascript">
	var mw_cash_path = "<?=$mw_cash[path]?>";
	</script>
	<img src="<?=$board_skin_path?>/img/icon_cash2.gif" style="cursor:pointer;" onclick="buy_contents('<?=$bo_table?>', '<?=$wr_id?>')" align="absmiddle">
	<? } ?>

	<? if ($is_admin) { ?>
        <? ob_start(); ?>
        <? if ($download_log_href) { echo "<a href=\"$download_log_href\"><img src='$board_skin_path/img/btn_download_log.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($history_href) { echo "<a href=\"$history_href\"><img src='$board_skin_path/img/btn_history.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($copy_href) { echo "<a href=\"$copy_href\"><img src='$board_skin_path/img/btn_copy.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($move_href) { echo "<a href=\"$move_href\"><img src='$board_skin_path/img/btn_move.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($nosecret_href) { echo "<a href=\"$nosecret_href\"><img src='$board_skin_path/img/btn_nosecret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($secret_href) { echo "<a href=\"$secret_href\"><img src='$board_skin_path/img/btn_secret.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($is_admin) { echo "<a href=\"javascript:btn_now()\"><img src='$board_skin_path/img/btn_now.gif' border='0' align='absmiddle'></a> "; } ?>
        <? if ($is_admin) { echo "<a href=\"javascript:btn_intercept('$view[mb_id]')\"><img src='$board_skin_path/img/btn_intercept.gif' border='0' align='absmiddle'></a> "; } ?>
        <? $mw_admin_button = ob_get_contents(); ob_end_flush(); ?>
	<? } ?>
    </td>
</tr>
<? } ?>

<tr>
    <td class=mw_basic_view_content>
        <div id=view_<?=$wr_id?>>

        <? @include_once($mw_basic[cf_include_view_head])?>

        <?=$mw_basic[cf_content_head]?>

        <div id=view_content>
        <? if (!$mw_basic[cf_zzal] && !strstr($view[content], "{이미지:")) echo $file_viewer; // 파일 출력  ?>
        <?//echo $view[content]; // 내용출력?>
        <?echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우?>
        </div>

        <? if ($mw_basic[cf_zzal] && $file_viewer) { ?>
        <div class=mw_basic_view_zzal>
            <input type=button id=zzbtn value="<?=$view[wr_zzal]?> 보기" onclick="zzalview()" class=mw_basic_view_zzal_button>

            <script language=javascript>
            function zzalview()
            {
                var zzb = document.getElementById("zzb");
                var btn = document.getElementById("zzbtn");
                if (zzb.style.display == "none")
                {
                    zzb.style.display = "block";
                    btn.value = "<?=$view[wr_zzal]?> 가리기";
                    //resizeBoardImage(650);
                }
                else
                {
                    zzb.style.display = "none";
                    btn.value = "<?=$view[wr_zzal]?> 보기";
                }
            }
            </script>

            <div id=zzb style="display:none; margin-top:20px;"><?=$file_viewer?></div>
        </div>
        <? } ?>

        <!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>

        <? if ($mw_basic[cf_ccl] && $view[wr_ccl][by]) { ?>
        <div class=mw_basic_ccl>
        <a rel="license" href="<?=$view[wr_ccl][link]?>" title="<?=$view[wr_ccl][msg]?>" target=_blank>
        <img src="<?=$board_skin_path?>/mw.ccl/ccls_by.gif">
        <? if ($view[wr_ccl][nc] == "nc") { ?><img src="<?=$board_skin_path?>/mw.ccl/ccls_nc.gif"><? } ?>
        <? if ($view[wr_ccl][nd] == "nd") { ?><img src="<?=$board_skin_path?>/mw.ccl/ccls_nd.gif"><? } ?>
        <? if ($view[wr_ccl][nd] == "sa") { ?><img src="<?=$board_skin_path?>/mw.ccl/ccls_sa.gif"><? } ?>
        </a>
        </div>
        <? } ?>

        <? if ($good_href || $nogood_href) {?>
        <div style="height:55px; clear:both; margin:10px 0 10px 0;">
        <? if ($good_href) {?>
        <div style="width:72px; height:55px; background:url(<?=$board_skin_path?>/img/good_bg.gif) no-repeat; text-align:center; float:left;">
        <div style="color:#888; margin:7px 0 5px 0;"><span style='color:crimson;'>추천 : <?=number_format($view[wr_good])?></span></div>
        <div><a href="<?=$good_href?>" target="hiddenframe"><img src="<?=$board_skin_path?>/img/icon_good.gif" align="absmiddle"></a></div>
        </div>
        <? } ?>
        <? if ($nogood_href) {?>
        <div style="width:72px; height:55px; background:url(<?=$board_skin_path?>/img/good_bg.gif) no-repeat; text-align:center; float:left;">
        <div style="color:#888; margin:7px 0 5px 0;">비추천 : <?=number_format($view[wr_nogood])?></div>
        <div><a href="<?=$nogood_href?>" target="hiddenframe"><img src="<?=$board_skin_path?>/img/icon_nogood.gif" align="absmiddle"></a></div>
        </div>
        <? } ?>
        </div>
        <? } ?>

        <? if ($is_signature) { echo "<br>$signature<br><br>"; } // 서명 출력 ?>

        <?=$mw_basic[cf_content_tail]?>

        <? @include_once($mw_basic[cf_include_view_tail])?>

        </div>
    </td>
</tr>
<? if ($mw_basic[cf_related] && $view[wr_related]) { ?>
<? $rels = mw_related($view[wr_related], $mw_basic[cf_related]); ?>
<? if (count($rels)) {?>
<tr>
    <td class=mw_basic_view_related>
        <h3>관련글</h3>
    </td>
</tr>
<tr>
    <td class="mw_basic_view_content mw_basic_view_related">
        <ul>
        <? for ($i=0; $i<count($rels); $i++) { ?>
        <li> <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&wr_id=<?=$rels[$i][wr_id]?>"> <?=$rels[$i][wr_subject]?> </a> </li>
        <? } ?>
        </ul>
    </td>
</tr>
<? } ?>
<? } ?>

</table>
<? if ($is_admin) { ?>
<div style="padding:10px 0 0 0;">
<?=$mw_admin_button?>
</div>
<? } ?>
<br>

<? include_once("./view_comment.php"); // 코멘트 입출력 ?>

<?=$link_buttons?>

</td></tr></table><br>

<? if ($mw_basic[cf_exif]) { ?>
<script type="text/javascript">
function show_exif(no, obj, event) {
    var url = "<?=$board_skin_path?>/mw.proc/mw.exif.show.php";

    if (g4_is_ie) {
	x = window.event.clientX; 
	y = window.event.clientY + document.body.scrollTop;
    } else {
	x = event.clientX;
	y = event.clientY + document.body.scrollTop;
    }

    $.post (url, { bo_table:'<?=$bo_table?>', wr_id:'<?=$wr_id?>', bf_no:no }, function (req) {
            var exif = document.getElementById("exif-info");
            exif.style.left = x;
            exif.style.top = y;
            exif.style.display = "block";
            exif.innerHTML = req;
            exif.onclick = function () { this.style.display = "none"; }
	}
    );
}
</script>
<style type="text/css">
#exif-info { display:none; position:absolute; width:350px; height:200px; }
#exif-info { cursor:pointer; color:#bfbfbf;  }
#exif-info { background:url(<?=$board_skin_path?>/img/exif.png) no-repeat; }
*html #exif-info { background:; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=$board_skin_path?>/img/exif.png',sizingMethod='crop'); }
#exif-info table { margin:55px 0 0 20px; }
#exif-info td { color:#ddd; height:18px;  }
</style>

<div id="exif-info" title='클릭하면 창이 닫힙니다.'></div>
<? } ?>

<? if ($download_log_href) { ?>
<script type="text/javascript">
function btn_download_log() {
    win_open("<?=$board_skin_path?>/mw.proc/mw.download.log.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>", "mw_download_log", "width=500, height=300, scrollbars=yes");
}
</script>
<? } ?>

<? if ($history_href) { ?>
<script type="text/javascript">
function btn_history(wr_id) {
    win_open("<?=$board_skin_path?>/mw.proc/mw.history.list.php?bo_table=<?=$bo_table?>&wr_id=" + wr_id, "mw_history", "width=500, height=300, scrollbars=yes");
}
</script>
<? } ?>

<? if ($singo_href) { ?>
<script type="text/javascript">
function btn_singo(wr_id, parent_id) {
    if (confirm("이 게시물을 정말 신고하시겠습니까?")) {
        hiddenframe.location.href = "<?=$board_skin_path?>/mw.proc/mw.btn.singo.php?bo_table=<?=$bo_table?>&wr_id=" + wr_id + "&parent_id=" + parent_id;
    }
}
</script>
<? } ?>

<? if ($print_href) { ?>
<script type="text/javascript">
function btn_print() {
    win_open("<?=$board_skin_path?>/mw.proc/mw.print.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>", "print", "width=800,height=600,scrollbars=yes");
}
</script>
<? } ?>



<? if ($secret_href || $nosecret_href) { ?>
<script type="text/javascript">
function btn_secret() {
    if (confirm("이 게시물을 비밀글로 설정하시겠습니까?")) {
        hiddenframe.location.href = "<?=$board_skin_path?>/mw.proc/mw.btn.secret.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>";
    }
}
function btn_nosecret() {
    if (confirm("이 게시물의 비밀글 설정을 해제하시겠습니까?")) {
        hiddenframe.location.href = "<?=$board_skin_path?>/mw.proc/mw.btn.secret.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&flag=no";
    }
}

</script>
<? } ?>

<? if ($is_admin) { ?>
<script type="text/javascript">
function btn_now() {
    var renum = 0;
    if (confirm("이 게시물의 작성시간을 현재로 변경하시겠습니까?")) {
        if (confirm("날짜순으로 정렬 하시겠습니까?")) renum = 1;

        $.get("<?=$board_skin_path?>/mw.proc/mw.time.now.php", { "bo_table":"<?=$bo_table?>", "wr_id":"<?=$wr_id?>", "renum":renum }, function () {
            location.reload();
        });
    }
}
function btn_intercept(mb_id) {
    win_open("<?=$board_skin_path?>/mw.proc/mw.intercept.php?mb_id=" + mb_id, "intercept", "width=500,height=300,scrollbars=yes");
}
function btn_ip(ip) {
    win_open("<?=$board_skin_path?>/mw.proc/mw.whois.php?ip=" + ip, "whois", "width=700,height=600,scrollbars=yes");
}
</script>
<? } ?>

<script type="text/javascript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/mw_image_window.js"?>"></script>

<? if ($mw_basic[cf_write_notice]) { ?>
<script type="text/javascript">
// 글쓰기버튼 공지
function btn_write_notice(url) {
    var msg = "<?=$mw_basic[cf_write_notice]?>";
    if (confirm(msg))
	location.href = url;
}
</script>
<? } ?>

<? if ($mw_basic[cf_link_blank]) { // 본문 링크를 새창으로 ?>
<script type="text/javascript">
if (document.getElementById('view_content')) {
    var target = '_blank';
    var link = document.getElementById('view_content').getElementsByTagName("a");
    for(i=0;i<link.length;i++) {
        link[i].target = target;
    }
}
</script>
<? } ?>

<? if ($mw_basic[cf_source_copy]) { // 출처 자동 복사 ?>
<script type="text/javascript">
function mw_copy()
{
    if (window.event)
    {
        window.event.returnValue = true;
        window.setTimeout('mw_add_source()', 10);
    }
}
function mw_add_source()
{
    if (window.clipboardData) {
        txt = window.clipboardData.getData('Text');
        txt = txt + "\r\n[출처 : <?=$g4[url]?>]\r\n";
        window.clipboardData.setData('Text', txt);
    }
}
//document.getElementById("view_content").oncopy = mw_copy;
</script>
<? } ?>

<style type="text/css">
<?=$mw_basic[cf_css]?>
</style>


