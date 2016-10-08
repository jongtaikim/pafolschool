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
include_once("$board_skin_path/mw.lib/mw.sms.lib.php");
include_once("$g4[path]/lib/etc.lib.php");

// 한 사람당 글 한개만 등록가능
if ($w == "" && $mw_basic[cf_only_one]) {
    if ($is_member)
	$sql = "select * from $write_table where wr_is_comment = 0 and mb_id = '$member[mb_id]'";
    else
	$sql = "select * from $write_table where wr_is_comment = 0 and wr_ip = '$_SERVER[REMOTE_ADDR]'";
    $row = sql_fetch($sql);
    if ($row)
	alert("이 게시판은 한 사람당 글 한개만 등록 가능합니다.");
}

?>
