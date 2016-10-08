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
?>

<style type="text/css">
#mw_basic #mw_basic_hot_list li.hot_icon_1 {
    background:url(<?=$board_skin_path?>/img/icon_hot_1.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_2 {
    background:url(<?=$board_skin_path?>/img/icon_hot_2.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_3 {
    background:url(<?=$board_skin_path?>/img/icon_hot_3.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_4 {
    background:url(<?=$board_skin_path?>/img/icon_hot_4.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_5 {
    background:url(<?=$board_skin_path?>/img/icon_hot_5.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_6 {
    background:url(<?=$board_skin_path?>/img/icon_hot_6.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_7 {
    background:url(<?=$board_skin_path?>/img/icon_hot_7.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_8 {
    background:url(<?=$board_skin_path?>/img/icon_hot_8.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_9 {
    background:url(<?=$board_skin_path?>/img/icon_hot_9.gif) no-repeat left 2px;
}
#mw_basic #mw_basic_hot_list li.hot_icon_10 {
    background:url(<?=$board_skin_path?>/img/icon_hot_10.gif) no-repeat left 2px;
}
</style>

<? if ($mw_basic[cf_hot]) { ?>
<?
switch ($mw_basic[cf_hot]) {
    case "1": $hot_start = ""; $hot_title = "실시간"; break;
    case "2": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24*7); $hot_title = "주간"; break;
    case "3": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24*30); $hot_title = "월간"; break;
    case "4": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24); $hot_title = "일간"; break;
}
$sql_between = 1;
if ($mw_basic[cf_hot] > 1) {
    $sql_between = " wr_datetime between '$hot_start' and '$g4[time_ymdhis]' ";
}
$sql = "select * 
          from $write_table 
         where wr_is_comment = 0 
           and $sql_between
         order by wr_{$mw_basic[cf_hot_basis]} desc 
         limit 10";
$qry = sql_query($sql);
?>
<div id=mw_basic_hot_list>
<h3> <?=$hot_title?> 인기 게시물 </h3>
<ul class=mw_basic_hot_dot>
<? for ($i=0; $row = sql_fetch_array($qry); $i++) { ?>
<li class=hot_icon_<?=($i+1)?>> 
    <a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$bo_table?>&wr_id=<?=$row[wr_id]?>">
    <?=cut_str($row[wr_subject], 40)?>
    </a>
</li>
<? if (($i+1)%5==0) echo "</ul><ul>"; ?>
<? } ?>
</ul>
</div>
<? } ?>
