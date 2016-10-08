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

// 로그남김
if ($mw_basic[cf_delete_log]) {

    // 나라오름님 수정 : 원글과 코멘트수가 정상적으로 업데이트 되지 않는 오류를 잡아 주셨습니다.
    //$sql = " select wr_id, mb_id, wr_comment from $write_table where wr_parent = '$write[wr_id]' order by wr_id ";
    $sql = " select wr_id, mb_id, wr_is_comment from $write_table where wr_parent = '$write[wr_id]' order by wr_id ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        // 원글이라면
        if (!$row[wr_is_comment])
        {
            // 원글 포인트 삭제
            if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '쓰기'))
                insert_point($row[mb_id], $board[bo_write_point] * (-1), "$board[bo_subject] $row[wr_id] 글삭제");

            // 업로드된 파일이 있다면 파일삭제
            $sql2 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            $result2 = sql_query($sql2);
            while ($row2 = sql_fetch_array($result2))
                @unlink("$g4[path]/data/file/$bo_table/$row2[bf_file]");

            // 파일테이블 행 삭제
            sql_query(" delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ");

            $count_write++;
        }
        else
        {
            // 코멘트 포인트 삭제
            if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
                insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{$row[wr_id]} 코멘트삭제");

            $count_comment++;
        }
    }

    // 게시글 삭제
    //sql_query(" delete from $write_table where wr_parent = '$write[wr_id]' ");
    if ($mw_basic[cf_post_history]) {
        $wr_name2 = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
        $sql = "insert into $mw[post_history_table]
                   set bo_table = '$bo_table'
                       ,wr_id = '$write[wr_id]'
                       ,wr_parent = '$write[wr_parent]'
                       ,mb_id = '$member[mb_id]'
                       ,ph_name = '$wr_name2'
                       ,ph_option = '$write[wr_option]'
                       ,ph_subject = '".addslashes($write[wr_subject])."'
                       ,ph_content = '".addslashes($write[wr_content])."'
                       ,ph_ip = '$_SERVER[REMOTE_ADDR]'
                       ,ph_datetime = '$g4[time_ymdhis]'";
        sql_query($sql);
    }
    $sql = " update $write_table
                set wr_subject = '삭제되었습니다.'
                    ,wr_content = '삭제되었습니다.'
                    ,wr_option = ''
                    ,wr_link1 = ''
                    ,wr_link2 = ''
              where wr_id = '$write[wr_id]'";
    sql_query($sql);

    if ($is_admin == "super") {
	// 게시글 삭제
	sql_query(" delete from $write_table where wr_parent = '$write[wr_id]' ");
    }

    // 최근게시물 삭제
    sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");

    // 스크랩 삭제
    sql_query(" delete from $g4[scrap_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]' ");

    // 공지사항 삭제
    $notice_array = explode("\n", trim($board[bo_notice]));
    $bo_notice = "";
    for ($k=0; $k<count($notice_array); $k++)
        if ((int)$write[wr_id] != (int)$notice_array[$k])
            $bo_notice .= $notice_array[$k] . "\n";
    $bo_notice = trim($bo_notice);
    sql_query(" update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");

    @include_once("$board_skin_path/delete.tail.skin.php");

    goto_url("./board.php?bo_table=$bo_table&page=$page" . $qstr);
    exit;
}
?>
