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

$write = sql_fetch(" select * from $write_table where wr_id = '$comment_id' ");

if ($mw_basic[cf_download_comment] && !$is_admin) {
    $sql = "select * from $mw[download_log_table] where bo_table = '$bo_table' and wr_id = '$write[wr_parent]' and mb_id = '$member[mb_id]'";
    $row = sql_fetch($sql);
    if ($row) {
        alert("첨부파일을 다운로드했기 때문에 코멘트를 삭제할 수 없습니다.");
    }
}

if ($mw_basic[cf_delete_log]) {
    if (!$write[wr_id] || !$write[wr_is_comment])
        alert("등록된 코멘트가 없거나 코멘트 글이 아닙니다.");

    if ($is_admin == "super") // 최고관리자 통과
        ;
    else if ($is_admin == "group") { // 그룹관리자
        $mb = get_member($write[mb_id]);
        if ($member[mb_id] == $group[gr_admin]) { // 자신이 관리하는 그룹인가?
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert("그룹관리자의 권한보다 높은 회원의 코멘트이므로 삭제할 수 없습니다.");
        } else
            alert("자신이 관리하는 그룹의 게시판이 아니므로 코멘트를 삭제할 수 없습니다.");
    } else if ($is_admin == "board") { // 게시판관리자이면
        $mb = get_member($write[mb_id]);
        if ($member[mb_id] == $board[bo_admin]) { // 자신이 관리하는 게시판인가?
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert("게시판관리자의 권한보다 높은 회원의 코멘트이므로 삭제할 수 없습니다.");
        } else
            alert("자신이 관리하는 게시판이 아니므로 코멘트를 삭제할 수 없습니다.");
    } else if ($member[mb_id]) {
        if ($member[mb_id] != $write[mb_id])
            alert("자신의 글이 아니므로 삭제할 수 없습니다.");
    } else {
        if (sql_password($wr_password) != $write[wr_password])
            alert("패스워드가 틀립니다.");
    }

    $len = strlen($write[wr_comment_reply]);
    if ($len < 0) $len = 0;
    $comment_reply = substr($write[wr_comment_reply], 0, $len);

    $sql = " select count(*) as cnt from $write_table
              where wr_comment_reply like '$comment_reply%'
                and wr_id <> '$comment_id'
                and wr_parent = '$write[wr_parent]'
                and wr_comment = '$write[wr_comment]'
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($row[cnt] && !$is_admin)
        alert("이 코멘트와 관련된 답변코멘트가 존재하므로 삭제 할 수 없습니다.");

    // 코멘트 삭제
    if (!delete_point($write[mb_id], $bo_table, $comment_id, '코멘트'))
        insert_point($write[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_parent]}-{$comment_id} 코멘트삭제");

    // 코멘트 삭제
    //sql_query(" delete from $write_table where wr_id = '$comment_id' ");
    if ($mw_basic[cf_post_history]) {
        $wr_name2 = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
        $sql = "insert into $mw[post_history_table]
                   set bo_table = '$bo_table'
                       ,wr_id = '$comment_id'
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
              where wr_id = '$comment_id'";
    sql_query($sql);


    // 코멘트가 삭제되므로 해당 게시물에 대한 최근 시간을 다시 얻는다.
    $sql = " select max(wr_datetime) as wr_last from $write_table where wr_parent = '$write[wr_parent]' ";
    $row = sql_fetch($sql);

    if ($is_admin == "super") {
	// 코멘트 삭제
	sql_query(" delete from $write_table where wr_id = '$comment_id' ");

	// 원글의 코멘트 숫자를 감소
	sql_query(" update $write_table set wr_comment = wr_comment - 1, wr_last = '$row[wr_last]' where wr_id = '$write[wr_parent]' ");

	// 코멘트 숫자 감소
	sql_query(" update $g4[board_table] set bo_count_comment = bo_count_comment - 1 where bo_table = '$bo_table' ");

	// 새글 삭제
	sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_id = '$comment_id' ");
    }

    // 사용자 코드 실행
    @include_once("$board_skin_path/delete_comment.skin.php");
    // 4.1
    @include_once("$board_skin_path/delete_comment.tail.skin.php");

    goto_url("./board.php?bo_table=$bo_table&wr_id=$write[wr_parent]&cwin=$cwin&page=$page" . $qstr);
    exit;
}
?>
