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

$mw_is_list = true;

include_once("$board_skin_path/mw.lib/mw.skin.basic.lib.php");

// 지업로더로 업로드한 파일
// 하루지난 데이터 삭제 (글작성 완료되지 않은..)
if ($mw_basic[cf_guploader]) {
    $gup_old = date("Y-m-d H:i:s", $g4[server_time] - 86400);
    $sql = "select * from $mw[guploader_table] where bf_datetime <= '$gup_old'";
    $qry = sql_query($sql, false);
    while ($row = sql_fetch_array($qry)) {
        @unlink("$g4[path]/data/guploader/$row[bf_file]");
    }
    sql_query("delete from $mw[guploader_table] where bf_datetime <= '$gup_old'", false);
}

// 카테고리
$is_category = false;
if ($board[bo_use_category]) 
{
    $is_category = true;
    $category_location = "./board.php?bo_table=$bo_table&sca=";
    $category_option = mw_get_category_option($bo_table); // SELECT OPTION 태그로 넘겨받음
}

// page 변수 중복 제거
$qstr = preg_replace("/(\&page=.*)/", "", $qstr);
$write_pages = get_paging($config[cf_write_pages], $page, $total_page, "./board.php?bo_table=$bo_table".$qstr."&page=");

// 이전,다음 검색시 페이지 번호 제거
$prev_part_href = preg_replace("/(\&page=.*)/", "", $prev_part_href);
$next_part_href = preg_replace("/(\&page=.*)/", "", $next_part_href);

// 1:1 게시판
if ($mw_basic[cf_attribute] == "1:1" && $is_admin != 'super') {
    require("$board_skin_path/mw.proc/mw.list.1n1.php");
}

// 익명 게시판
if ($mw_basic[cf_attribute] == "anonymous") {
    if (strstr($sfl, "mb_id") || strstr($sfl, "wr_name")) {
        alert("익명게시판에서는 아이디 또는 이름으로 검색하실 수 없습니다.");
    }
}

// 쓰기버튼 항상 출력
if ($mw_basic[cf_write_button])
    $write_href = "./write.php?bo_table=$bo_table";

// 글쓰기 버튼 공지
if ($write_href && $mw_basic[cf_write_notice]) {
    $write_href = "javascript:btn_write_notice('$write_href');";
}

// 스킨설정버튼
$config_href = "javascript:mw_config()";

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
if ($mw_basic[cf_contents_shop]) $colspan++;
if ($mw_basic[cf_type] == "thumb") $colspan++;
if ($mw_basic[cf_type] == "gall") $colspan = $board[bo_gallery_cols];

// 목록 셔플
if ($mw_basic[cf_list_shuffle]) shuffle($list);

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>
?>

<? if ($mw_basic[cf_type] == "desc" || $mw_basic[cf_type] == "thumb") { // 요약형, 썸네일형일경우 제목 볼드 ?>
<style type="text/css">
#mw_basic .mw_basic_list_subject a { font-size:13px; font-weight:bold; }
</style>
<? } ?>

<link rel="stylesheet" href="<?=$board_skin_path?>/style.common.css" type="text/css">

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center><tr><td id=mw_basic>

<? include_once("$board_skin_path/mw.proc/mw.list.hot.skin.php"); ?>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table width="100%">
<tr height="25">
    <td width="50%">
        <form name="fcategory" method="get" style="margin:0;">
        <? if ($is_category) { ?>
            <select name=sca onchange="location='<?=$category_location?>'+this.value;">
            <option value=''>전체</option>
            <?=$category_option?>
            </select>
        <? } ?>
        <? if ($mw_basic[cf_type] == "gall" && $is_checkbox) { ?><input onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox><?}?>
        </form>
    </td>
    <td align="right">
        <span class=mw_basic_total>게시물 <?=number_format($total_count)?>건</span>
        <? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border=0 align=absmiddle></a><?}?>
        <? if ($admin_href) { ?><a href="<?=$config_href?>"><img src="<?=$board_skin_path?>/img/btn_config.gif" title="스킨설정" border="0" align="absmiddle"></a><?}?>
        <? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/btn_admin.gif" title="관리자" width="63" height="22" border="0" align="absmiddle"></a><?}?>
    </td>
</tr>
<tr><td height=5></td></tr>
</table>

<!-- 제목 -->
<form name="fboardlist" method="post">
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='sfl'  value='<?=$sfl?>'>
<input type='hidden' name='stx'  value='<?=$stx?>'>
<input type='hidden' name='spt'  value='<?=$spt?>'>
<input type='hidden' name='page' value='<?=$page?>'>
<input type='hidden' name='sw'   value=''>
<table width=100%>
<tr><td colspan=<?=$colspan?> height=2 class=mw_basic_line_color></td></tr>
<? if ($mw_basic[cf_type] != "gall") { ?>
<tr class=mw_basic_list_title>
    <? if (!$mw_basic[cf_post_num]) { ?><td width=50>번호</td><? } ?>
    <? if ($is_checkbox) { ?><td width=40><input onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></td><?}?>
    <? if ($mw_basic[cf_type] == "thumb") { ?><td width=<?=$mw_basic[cf_thumb_width]+20?>> 이미지 </td><?}?>
    <td>제목</td>
    <? if ($mw_basic[cf_contents_shop]) { ?> <td width=80><?=$mw_cash[cf_cash_name]?></td> <?}?>
    <? if (!$mw_basic[cf_post_name]) { ?> <? if ($mw_basic[cf_attribute] != "anonymous") { ?> <td width=110>글쓴이</td> <?}?> <?}?>
    <? if (!$mw_basic[cf_post_date]) { ?> <td width=40>날짜</td> <?}?>
    <? if (!$mw_basic[cf_post_hit]) { ?> <td width=40><?=subject_sort_link('wr_hit', $qstr2, 1)?>조회</a></td> <?}?>
    <? if ($is_good) { ?><td width=40><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></td><?}?>
    <? if ($is_nogood) { ?><td width=40><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></td><?}?>
</tr>
<tr><td colspan=<?=$colspan?> height=1 class=mw_basic_line_color></td></tr>
<? } ?>
<? if ($mw_basic[cf_type] == "gall") { ?> <tr><td colspan=<?=$colspan?> height=10></td></tr> <? } ?>

<!-- 목록 -->
<? for ($i=0; $i<count($list); $i++) { ?>
<?
// 컨텐츠샵
$mw_price = "";
if ($mw_basic[cf_contents_shop]) {
    if (!$list[$i][wr_contents_price])
	$mw_price = "무료";
    else
	$mw_price = number_format($list[$i][wr_contents_price]).$mw_cash[cf_cash_unit];
}

// 링크게시판
if ($mw_basic[cf_link_board]) {
    if (!$is_admin) $list[$i][href] = "javascript:void(window.open('{$list[$i][link_href][1]}'))";    
    $list[$i][wr_hit] = $list[$i][link_hit][1];    
}
// 공지사항 출력 항목
if ($mw_basic[cf_post_name]) $list[$i][name] = "";
if ($mw_basic[cf_post_date]) $list[$i][datetime2] = "";
if ($mw_basic[cf_post_hit]) $list[$i][wr_hit] = "";

if ($list[$i][is_notice]) {
    if ($mw_basic[cf_notice_name]) $list[$i][name] = "";
    if ($mw_basic[cf_notice_date]) $list[$i][datetime2] = "";
    if ($mw_basic[cf_notice_hit]) $list[$i][wr_hit] = "";
}

if ($mw_basic[cf_type] != "list")
{
    $set_width = $mw_basic[cf_thumb_width];
    $set_height = $mw_basic[cf_thumb_height];

    // 섬네일 생성
    $thumb_file = "";
    $file = mw_get_first_file($bo_table, $list[$i][wr_id], true);
    if (!empty($file)) {
        $source_file = "$file_path/{$file[bf_file]}";
        $thumb_file = "$thumb_path/{$list[$i][wr_id]}";
        if (!file_exists($thumb_file)) {
            mw_make_thumbnail($set_width, $set_height, $source_file, $thumb_file, $mw_basic[cf_thumb_keep]);
        } else {
            if (!$mw_basic[cf_img_1_noview]) {
                if ($mw_basic[cf_thumb_keep]) {
                    $size = @getImageSize($source_file);
                    $size = mw_thumbnail_keep($size, $set_width, $set_height);
                    $set_width = $size[0];
                    $set_height = $size[1];
                } else
                    $size = @getImageSize($thumb_file);

                if ($size[0] != $set_width || $size[1] != $set_height) {
                    mw_make_thumbnail($mw_basic[cf_thumb_width], $mw_basic[cf_thumb_height], $source_file, $thumb_file, $mw_basic[cf_thumb_keep]);
                }
            }
        }
    } else {
        $thumb_file = "$thumb_path/{$list[$i][wr_id]}";
        if (!file_exists($thumb_file)) {
            preg_match("/<img.*src=\"(.*)\"/iU", $list[$i][wr_content], $match);
            if ($match[1]) {
                $match[1] = str_replace($g4[url], "..", $match[1]);
                if (file_exists($match[1])) {
                    mw_make_thumbnail($mw_basic[cf_thumb_width], $mw_basic[cf_thumb_height], $match[1], $thumb_file, $mw_basic[cf_thumb_keep]);
                }
            }
        }
    }
}
?>
<? if ($mw_basic[cf_type] == "gall") { ?>

    <? if (!file_exists($thumb_file) || $list[$i][icon_secret]) {
        $thumb_file = "$board_skin_path/img/noimage.gif";
        $thumb_width = "width='$mw_basic[cf_thumb_width]'";
        $thumb_height = "height='$mw_basic[cf_thumb_height]'";
    } else {
        $thumb_width = "";
        $thumb_height = "";
    } ?>

    <? if (($i+1)%$colspan==1) echo "<tr>"; ?>
    <td class=mw_basic_list_gall>
        <!--<div><a href="<?=$list[$i][href]?>"><img src="<?=$thumb_file?>" width=<?=$mw_basic[cf_thumb_width]?> height=<?=$mw_basic[cf_thumb_height]?> align=absmiddle></a></div>-->
        <div><a href="<?=$list[$i][href]?>"><img src="<?=$thumb_file?>" <?=$thumb_width?> <?=$thumb_height?> align=absmiddle></a></div>
        <div class=mw_basic_list_subject_gall style="width:<?=$set_width?>px;">
            <? if ($is_checkbox) { ?> <input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"> <? } ?>
            <? if ($is_category && $list[$i][ca_name]) { ?>  <a href="<?=$list[$i][ca_name_href]?>" class=mw_basic_list_category>[<?=$list[$i][ca_name]?>]</a> <? } ?>
            <a href="<?=$list[$i][href]?>"><?=$list[$i][subject]?></a>
            <? if ($list[$i][comment_cnt]) { ?> <span class=mw_basic_list_comment_count><?=$list[$i][comment_cnt]?></span> <? } ?>
        </div>
    </td>
    <? if (($i+1)%$colspan==0) echo "</tr>"; ?>

<? } else { ?>

<tr align=center <? if ($list[$i][is_notice]) echo "bgcolor='#f8f8f9'"; ?>>

    <!-- 글번호 -->
    <? if (!$mw_basic[cf_post_num]) { ?>
    <td>
        <?
        if ($mw_basic[cf_comma]) {
            $list[$i][num] = number_format($list[$i][num]);
            $list[$i][wr_hit] = number_format($list[$i][wr_hit]);
            $list[$i][wr_good] = number_format($list[$i][wr_good]);
            $list[$i][wr_nogood] = number_format($list[$i][wr_nogood]);
        }
	if ($list[$i][is_notice] && $mw_basic[cf_notice_hit]) $list[$i][wr_hit] = "";

        if ($list[$i][is_notice]) // 공지사항
            echo "<img src=\"$board_skin_path/img/icon_notice.gif\" width=30 height=16>";
        else if ($wr_id == $list[$i][wr_id]) // 현재위치
            echo "<span class=mw_basic_list_num_select>{$list[$i][num]}</span>";
        else // 일반
            echo "<span class=mw_basic_list_num>{$list[$i][num]}</span>";
        ?>
    </td>
    <? } ?>

    <? if ($is_checkbox) { ?>
    <!-- 관리자용 체크박스 -->
    <td> <input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"> </td>
    <? } ?>

    <? if ($mw_basic[cf_type] == "thumb") { ?>
    <? if (!file_exists($thumb_file) || $list[$i][icon_secret]) $thumb_file = "$board_skin_path/img/noimage.gif"; ?>

    <!-- 썸네일 -->
    <td class=mw_basic_list_thumb><!-- 여백제거
        --><a href="<?=$list[$i][href]?>"><img src="<?=$thumb_file?>" width=<?=$mw_basic[cf_thumb_width]?> height=<?=$mw_basic[cf_thumb_height]?> align=absmiddle></a><!--
    --></td>
    <? } ?>

    <!-- 글제목 -->
    <td class=mw_basic_list_subject>
        <?
        if ($mw_basic[cf_type] == "desc" && file_exists($thumb_file)) {
            echo "<div class=mw_basic_list_thumb>";
            echo "<a href=\"{$list[$i][href]}\"><img src=\"{$thumb_file}\" width={$mw_basic[cf_thumb_width]} height={$mw_basic[cf_thumb_height]} align=absmiddle></a>";
            echo "</div>";
        }
        if ($mw_basic[cf_type] == "desc") {
            echo "<div class=mw_basic_list_subject_desc>";
        }
        echo $list[$i][reply];
        echo $list[$i][icon_reply];
        if ($is_category && $list[$i][ca_name]) {
            echo "<a href=\"{$list[$i][ca_name_href]}\" class=mw_basic_list_category>[{$list[$i][ca_name]}]</a>&nbsp;";
        }

        $style = "";
        if ($list[$i][is_notice]) $style = " class=mw_basic_list_notice";

        if ($mw_basic[cf_type] == "list") {
            echo "<img src=\"$board_skin_path/img/icon_subject.gif\" align=absmiddle style=\"border-bottom:2px solid #fff;\">&nbsp;";
        }
        if (!$mw_basic[cf_subject_link] || $board[bo_read_level] <= $member[mb_level]) {
            if (!$mw_basic[cf_board_member] || $mw_is_board_member || $is_admin) {
                echo "<a href=\"{$list[$i][href]}\">";
            }
        }

        // 제목스타일
        if ($mw_basic[cf_subject_style])
            $style .= " style='font-family:{$list[$i][wr_subject_font]}; color:{$list[$i][wr_subject_color]}'";

        echo "<span{$style}>{$list[$i][subject]}</span></a>";

        if ($list[$i][comment_cnt])
            echo " <a href=\"{$list[$i][comment_href]}\" class=mw_basic_list_comment_count>{$list[$i][comment_cnt]}</a>";
            //echo " <span class=mw_basic_list_comment_count>{$list[$i][comment_cnt]}</span>";

        echo " " . $list[$i][icon_new];
        echo " " . $list[$i][icon_file];
        echo " " . $list[$i][icon_link];
        echo " " . $list[$i][icon_hot];
        echo " " . $list[$i][icon_secret];

        if ($mw_basic[cf_type] == "desc") {
            echo "</div>";
            $desc = strip_tags($list[$i][wr_content]);
            $desc = cut_str($desc, $mw_basic[cf_desc_len]);
            echo "<div class=mw_basic_list_desc> $desc </div>";
        }
        ?>
    </td>
    <? if ($mw_basic[cf_contents_shop]) { ?>
    <td class=mw_basic_list_contents_price><span><?=$mw_price?></span></td><?}?>
    <? if (!$mw_basic[cf_post_name]) { ?>
    <? if ($mw_basic[cf_attribute] != "anonymous") { ?> <td><nobr class=mw_basic_list_name><?=$list[$i][name]?></nobr></td> <?}?> <?}?>
    <? if (!$mw_basic[cf_post_date]) { ?> <td class=mw_basic_list_datetime><?=$list[$i][datetime2]?></span></td> <?}?>
    <? if (!$mw_basic[cf_post_hit]) { ?> <td class=mw_basic_list_hit><?=$list[$i][wr_hit]?></span></td> <?}?>
    <? if ($is_good) { ?><td class=mw_basic_list_good><?=$list[$i][wr_good]?></td><? } ?>
    <? if ($is_nogood) { ?><td class=mw_basic_list_nogood><?=$list[$i][wr_nogood]?></td><? } ?>
</tr>
<? if ($i<count($list)-1) { // 마지막 라인 출력 안함 ?>
<!--<tr><td colspan=<?=$colspan?> height=1 bgcolor=#E7E7E7></td></tr>-->
<tr><td colspan=<?=$colspan?> height=1 style="border-top:1px dotted #e7e7e7"></td></tr>
<?}?>
<?}?>
<?}?>


<? if (count($list) == 0) { echo "<tr><td colspan={$colspan} class=mw_basic_nolist>게시물이 없습니다.</td></tr>"; } ?>
<tr><td colspan=<?=$colspan?> class=mw_basic_line_color height=1></td></tr>
</table>
</form>

<!-- 페이지 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
    <td class=mw_basic_page>
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/page_begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/page_prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/page_next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/page_end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        echo $write_pages;
        ?>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
    </td>
</tr>
</table>

<!-- 링크 버튼, 검색 -->
<form name=fsearch method=get>
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca value="<?=$sca?>">
<table width=100%>
<tr>
    <td height="40">
        <? if ($list_href) { ?><a href="<?=$list_href?>"><img src="<?=$board_skin_path?>/img/btn_list.gif" border="0"></a><? } ?>
        <? if ($write_href) { ?><a href="<?=$write_href?>"><img src="<?=$board_skin_path?>/img/btn_write.gif" border="0"></a><? } ?>
        <? if ($is_checkbox) { ?>
            <a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" border="0"></a>
            <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" border="0"></a>
            <a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" border="0"></a>
            <a href="javascript:mw_move_cate();"><img src="<?=$board_skin_path?>/img/btn_select_cate.gif" border="0"></a>
        <? } ?>
    </td>
    <td align="right">
        <select name=sfl>
            <option value='wr_subject'>제목</option>
            <option value='wr_content'>내용</option>
            <option value='wr_subject||wr_content'>제목+내용</option>
            <? if ($mw_basic[cf_attribute] != "anonymous") { ?>
            <option value='mb_id,1'>회원아이디</option>
            <option value='mb_id,0'>회원아이디(코)</option>
            <option value='wr_name,1'>이름</option>
            <option value='wr_name,0'>이름(코)</option>
            <? } ?>
        </select>
        <input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=$stx?>'>
        <select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=image src="<?=$board_skin_path?>/img/btn_search.gif" border=0 align=absmiddle></td>
</tr>
</table>
</form>

</td></tr></table>

<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}
</script>

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


<? if ($is_checkbox) { ?>
<script type="text/javascript">

function mw_config() {
    win_open("<?=$board_skin_path?>/mw.adm/mw.config.php?bo_table=<?=$bo_table?>", "config", "width=800, height=700, scrollbars=yes");
}

function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

// 선택한 게시물 분류 변경
function mw_move_cate() {
    var f = document.fboardlist;

    if (!check_confirm("분류이동"))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.target = "move";
    f.action = "<?=$board_skin_path?>/mw.proc/mw.move.cate.php";
    f.submit();
}

</script>
<? } ?>

<style type="text/css">
<?=$mw_basic[cf_css]?>
</style>


<!-- 게시판 목록 끝 -->
