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

// 로그남김
if ($w == "cu" && $mw_basic[cf_post_history]) {
    $write2 = sql_fetch("select * from $write_table where wr_id = '$comment_id'");
    $wr_name2 = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $sql = "insert into $mw[post_history_table]
               set bo_table = '$bo_table'
                   ,wr_id = '$comment_id'
                   ,wr_parent = '$write2[wr_parent]'
                   ,mb_id = '$member[mb_id]'
                   ,ph_name = '$wr_name2'
                   ,ph_option = '$write2[wr_option]'
                   ,ph_subject = '".addslashes($write2[wr_subject])."'
                   ,ph_content = '".addslashes($write2[wr_content])."'
                   ,ph_ip = '$_SERVER[REMOTE_ADDR]'
                   ,ph_datetime = '$g4[time_ymdhis]'";
    sql_query($sql);
}

$sql_option = "";

if ($mw_basic[cf_comment_editor]) {
    //$wr_option .= "html1";
    $wr_option .= $html;
}

if ($wr_secret) {
    $wr_option .= $wr_option ? "," : "";
    $wr_option .= "$wr_secret";
}

?>
