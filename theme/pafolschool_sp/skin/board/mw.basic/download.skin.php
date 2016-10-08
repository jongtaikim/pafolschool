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

if ($mw_basic[cf_contents_shop]) { // 배추컨텐츠샵
    if (!$is_member)
	alert("로그인 해주세요.");

    if (!mw_is_buy_contents($member[mb_id], $bo_table, $wr_id) && $is_admin != "super")
	alert("결제 후 다운로드 하실 수 있습니다.");
}

if ($mw_basic[cf_download_comment] && !$is_admin) { // 코멘트 남겨야 다운로드 가능
    if ($is_member) {
	$sql = "select wr_id from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 and mb_id = '$member[mb_id]'";
    } else {
	$sql = "select wr_id from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 and wr_ip = '$_SERVER[REMOTE_ADDR]'";
    }
    $row = sql_fetch($sql);
    if (!$row) {
        alert("코멘트를 남겨야 다운로드가 가능합니다.");
    }
}

if ($mw_basic[cf_uploader_point]) { // 업로더 포인트 제공
    $wr_name = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $eval = 'insert_point($write[mb_id], $mw_basic[cf_uploader_point], "{$wr_name}님이 $board[bo_subject] $wr_id 파일 다운로드", $bo_table, $wr_id, "$member[mb_id] 다운로드");';
    if ($mw_basic[cf_uploader_day] > 0) { //기간제한
        $old = strtotime($write[wr_datetime]);
        $now = $g4[server_time];
        $gap = (int)(($now - $old) / 86400);
        if ($gap <= $mw_basic[cf_uploader_day]) {
            eval($eval);
        }
    } else {
        eval($eval);
    }
}

if ($mw_basic[cf_download_log]) { // 다운로드 기록
    $dl_name = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $sql = "insert into $mw[download_log_table]
               set bo_table = '$bo_table'
                   , wr_id = '$wr_id'
                   , bf_no = '$no'
                   , mb_id = '$member[mb_id]'
                   , dl_name = '$dl_name'
                   , dl_ip = '$_SERVER[REMOTE_ADDR]'
                   , dl_datetime = '$g4[time_ymdhis]'";
    $qry = sql_query($sql, false);
    if (!$qry) { // 테이블 생성시 dl_name 필드가 빠져서 추가함 v.1.0.2 버그
        sql_query("alter table $mw[download_log_table] add dl_name varchar(20) not null after mb_id", false);
        sql_query($sql);
    }
}

?>
