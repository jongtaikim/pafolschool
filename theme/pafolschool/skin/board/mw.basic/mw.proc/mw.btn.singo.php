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

include_once("_common.php");
include_once("$board_skin_path/mw.lib/mw.skin.basic.lib.php");

function alert_only($msg) 
{
	global $g4;
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
    echo "<script language='javascript'> alert('$msg'); </script>";
    exit;
}

if (!$is_member)
    alert_only("회원만 이용하실 수 있습니다.");

if ($write[wr_singo])
    alert_only("이미 신고된 게시물 입니다.");

$me_recv_mb_id = $mw_basic[cf_singo_id];

if ($wr_id != $parent_id)
    $comment = "#c_$wr_id";

$me_memo = "게시물 신고가 접수되었습니다.\n\n
{$g4[url]}/{$g4[bbs]}/board.php?bo_table=$bo_table&wr_id=$parent_id$comment";

$tmp_list = explode(",", $me_recv_mb_id);
$me_recv_mb_id_list = "";
$msg = "";
$comma1 = $comma2 = "";
$mb_list = array();
$mb_array = array();
for ($i=0; $i<count($tmp_list); $i++) {
    if (!$tmp_list[$i]) continue;
    $row = get_member($tmp_list[$i]);
    if ((!$row[mb_id] || !$row[mb_open] || $row[mb_leave_date] || $row[mb_intercept_date]) && !$is_admin) {
        $msg .= "$comma1$tmp_list[$i]";
        $comma1 = ",";
    } else {
        $me_recv_mb_id_list .= "$comma2$row[mb_nick]";
        $mb_list[] = $tmp_list[$i];
        $mb_array[] = $row;
        $comma2 = ",";
    }
}

for ($i=0; $i<count($mb_list); $i++) {
    if (trim($mb_list[$i])) {
        $tmp_row = sql_fetch(" select max(me_id) as max_me_id from $g4[memo_table] ");
        $me_id = $tmp_row[max_me_id] + 1;

        // 쪽지 INSERT
        $sql = " insert into $g4[memo_table]
                        ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo )
                 values ( '$me_id', '$mb_list[$i]', '$member[mb_id]', '$g4[time_ymdhis]', '$me_memo' ) ";
        sql_query($sql);

        // 실시간 쪽지 알림 기능
        $sql = " update $g4[member_table]
                    set mb_memo_call = '$member[mb_id]'
                  where mb_id = '$mb_list[$i]' ";
        sql_query($sql);

        if (!$is_admin) {
            $recv_mb_nick = get_text($mb_array[$i][mb_nick]);
            $recv_mb_id = $mb_array[$i][mb_id];
        }
    }
}


$sql = "update $write_table set wr_singo = 1 where wr_id = '$wr_id'";
sql_query($sql);

alert_only("신고하였습니다.");
?>