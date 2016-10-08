<?
/**
 * Bechu basic skin for gnuboard4
 *
 * copyright (c) 2008 Choi Jae-Young <www.miwit.com>
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

// gr_id 입력 안된것 보완 v.1.0.1
if (!$mw_basic[gr_id])
    sql_query("update $mw[basic_config_table] set gr_id = '$gr_id' where bo_table = '$bo_table'", false);

// gr_id 변경 체크 v.1.0.3
if ($mw_basic[gr_id] != $gr_id) {
    $sql = "update $mw[basic_config_table] set gr_id = '$gr_id' where bo_table = '$bo_table'";
    $res = sql_query($sql, false);
}

if (!$mw_basic)
{
    $sql = "insert into $mw[basic_config_table] set gr_id = '$gr_id', bo_table = '$bo_table'";
    $res = sql_query($sql, false);
    if (!$res)
    {
        // 스킨 설정 테이블 자동생성
        $sql = "create table $mw[basic_config_table] (
        gr_id varchar(20) default '' not null,
        bo_table varchar(20) default '' not null,
        cf_type varchar(5) default 'list' not null,
        cf_thumb_width smallint default '80' not null,
        cf_thumb_height smallint default '50' not null,
        cf_attribute varchar(10) default 'basic' not null,
        cf_ccl tinyint default '1' not null,
        cf_hot tinyint default '0' not null,
        cf_hot_basis varchar(5) default 'hit' not null,
        cf_related tinyint default '0' not null,
        cf_link_blank tinyint default '1' not null,
        cf_zzal tinyint default '0' not null,
        cf_zzal_must tinyint default '0' not null,
        cf_source_copy tinyint default '1' not null,
        cf_relation tinyint default '1' not null,
        cf_comment_editor tinyint default '1' not null,
        cf_comment_emoticon tinyint default '1' not null,
        cf_comment_write tinyint default '1' not null,
        cf_singo tinyint default '1' not null,
        cf_singo_id text not null,
        cf_email text not null,
        cf_sms_id varchar(100) not null,
        cf_sms_pw varchar(100) not null,
        cf_hp text not null,
        cf_content_head text not null,
        cf_content_tail text not null,
        primary key (gr_id, bo_table));";
        sql_query($sql, false);

        $sql = "insert into $mw[basic_config_table] set gr_id = '$gr_id', bo_table = '$bo_table'";
        $res = sql_query($sql);
    }

    $sql = "select * from $mw[basic_config_table] where bo_table = '$bo_table'";
    $mw_basic = sql_fetch($sql);
}
// 게시판 테이블에 CCL 항목 자동 추가
if (is_null($write[wr_ccl])) {
    $sql = "alter table $write_table add wr_ccl varchar(10) default '' not null";
    sql_query($sql, false);
}

// 게시판 테이블에 신고 항목 자동 추가
if (is_null($write[wr_singo])) {
    $sql = "alter table $write_table add wr_singo tinyint default '0' not null";
    sql_query($sql, false);
}

// 게시판 테이블에 짤방 항목 자동 추가
if (is_null($write[wr_zzal])) {
    $sql = "alter table $write_table add wr_zzal varchar(255) default '짤방' not null";
    sql_query($sql, false);
}

// 게시판 테이블에 관련글 항목 자동 추가
if (is_null($write[wr_related])) {
    $sql = "alter table $write_table add wr_related varchar(255) default '' not null";
    sql_query($sql, false);
}

// 스킨환경정보에 글번호, 조회수등 컴마설정 자동추가 v.1.0.1
if (is_null($mw_basic[cf_comma])) {
    $sql = "alter table $mw[basic_config_table] add cf_comma tinyint default '0' not null";
    sql_query($sql, false);
}

// 코멘트 공지 자동추가 v.1.0.1
if (is_null($mw_basic[cf_comment_notice])) {
    $sql = "alter table $mw[basic_config_table] add cf_comment_notice text default '' not null";
    sql_query($sql, false);
}

// 다운로드 제한(코멘트 강제) 자동추가 v.1.0.1
if (is_null($mw_basic[cf_download_comment])) {
    $sql = "alter table $mw[basic_config_table] add cf_download_comment tinyint default '0' not null";
    sql_query($sql, false);
}

// 업로더 포인트 제공 자동추가 v.1.0.1
if (is_null($mw_basic[cf_uploader_point])) {
    $sql = "alter table $mw[basic_config_table] add cf_uploader_point tinyint default '0' not null";
    $sql .= ", add cf_uploader_day tinyint default '0' not null";
    sql_query($sql, false);
}

// 자동등록방지 코드 이미지 사용 - 그누보드4 최신버전과 이전버전의 호환성 v.1.0.1
if (is_null($mw_basic[cf_norobot_image])) {
    $sql = "alter table $mw[basic_config_table] add cf_norobot_image tinyint default '1' not null";
    sql_query($sql, false);
}

// 코멘트 입력시 비밀글 체크 기본설정기능 자동추가 v.1.0.1
if (is_null($mw_basic[cf_comment_secret])) {
    $sql = "alter table $mw[basic_config_table] add cf_comment_secret tinyint default '0' not null";
    sql_query($sql, false);
}

// 요약형 본문 글자수 설정 자동추가 v.1.0.1
if (is_null($mw_basic[cf_desc_len])) {
    $sql = "alter table $mw[basic_config_table] add cf_desc_len int default '150' not null";
    sql_query($sql, false);
}

// 권한에 따른 쓰기버튼 출력 옵션 v.1.0.2
if (is_null($mw_basic[cf_write_button])) {
    $sql = "alter table $mw[basic_config_table] add cf_write_button tinyint default '1' not null";
    sql_query($sql, false);
}

// 권한별 제목링크 v.1.0.2
if (is_null($mw_basic[cf_subject_link])) {
    $sql = "alter table $mw[basic_config_table] add cf_subject_link tinyint default '0' not null";
    sql_query($sql, false);
}

// 코멘트 금지 기능 v.1.0.2
if (is_null($mw_basic[cf_comment_ban])) {
    $sql = "alter table $mw[basic_config_table] add cf_comment_ban tinyint default '0' not null";
    sql_query($sql, false);
}
if (is_null($write[wr_comment_ban])) {
    $sql = "alter table $write_table add wr_comment_ban char(1) not null";
    sql_query($sql, false);
}

// 링크 게시판 
if (is_null($mw_basic[cf_link_board])) {
    $sql = "alter table $mw[basic_config_table] add cf_link_board tinyint default '0' not null";
    sql_query($sql, false);
}

// 공지사항 이름, 날짜, 조회수 출력 여부 
if (is_null($mw_basic[cf_notice_name])) {
    sql_query("alter table $mw[basic_config_table] add cf_notice_name tinyint default '0' not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_notice_date tinyint default '0' not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_notice_hit tinyint default '0' not null", false);
}

// 일반게시물 이름, 날짜, 조회수 출력 여부 
if (is_null($mw_basic[cf_notice_name])) {
    sql_query("alter table $mw[basic_config_table] add cf_post_name tinyint default '0' not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_post_date tinyint default '0' not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_post_hit tinyint default '0' not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_post_num tinyint default '0' not null", false);
}

// 코멘트 금지 레벨설정 기능 v.1.0.2
if (is_null($mw_basic[cf_comment_ban_level])) {
    $sql = "alter table $mw[basic_config_table] add cf_comment_ban_level tinyint default '10' not null";
    sql_query($sql, false);
}

// 게시글 히스토리 v.1.0.2
if (is_null($mw_basic[cf_post_history])) {
    $sql = "alter table $mw[basic_config_table] add cf_post_history char(1) not null";
    sql_query($sql, false);

    $sql = "alter table $mw[basic_config_table] add cf_post_history_level tinyint default '10' not null";
    sql_query($sql, false);

    $sql = "alter table $mw[basic_config_table] add cf_delete_log char(1) not null";
    sql_query($sql, false);

    $sql = "create table $mw[post_history_table] (
            ph_id int unsigned auto_increment not null
            ,bo_table varchar(20) not null
            ,wr_id int not null
            ,wr_parent int not null
            ,mb_id varchar(20) not null
            ,ph_name varchar(255)
            ,ph_option set('html1', 'html2', 'secret', 'mail') not null
            ,ph_subject varchar(255) not null
            ,ph_content text not null
            ,ph_ip varchar(20) not null
            ,ph_datetime datetime not null
            ,primary key(ph_id)
            ,index(bo_table, wr_id, mb_id));";
    sql_query($sql);
}

// 다운로드 기록 v.1.0.2
if (is_null($mw_basic[cf_download_log])) {
    $sql = "alter table $mw[basic_config_table] add cf_download_log char(1) not null";
    sql_query($sql, false);

    $sql = "create table $mw[download_log_table] (
            dl_id int auto_increment not null
            ,bo_table varchar(20) not null
            ,wr_id int not null
            ,bf_no int not null
            ,mb_id varchar(20) not null
            ,dl_ip varchar(20) not null
            ,dl_datetime datetime not null
            ,primary key(dl_id)
            ,index(bo_table, wr_id, bf_no, mb_id));";
    sql_query($sql);
}

// 접근권한 v.1.0.2
if (is_null($mw_basic[cf_board_member])) {
    $sql = "alter table $mw[basic_config_table] add cf_board_member char(1) not null";
    sql_query($sql);

    // 게시판 접근권한 테이블 자동생성 v.1.0.2
    $sql = "create table $mw[board_member_table] (
    bo_table varchar(20) not null
    ,mb_id varchar(20) not null
    ,bm_datetime datetime not null
    ,primary key (bo_table));";
    sql_query($sql);
}

// 접근권한 목록 v.1.0.2
if (is_null($mw_basic[cf_board_member_list])) {
    $sql = "alter table $mw[basic_config_table] add cf_board_member_list char(1) not null";
    sql_query($sql, false);
}

// 코멘트 기본 내용 v.1.0.2
if (is_null($mw_basic[cf_comment_default])) {
    $sql = "alter table $mw[basic_config_table] add cf_comment_default text not null";
    sql_query($sql, false);
}

// 접근권한 v.1.0.2
if ($mw_basic[cf_board_member] && !$is_admin) {
    $sql = "select mb_id from $mw[board_member_table] where bo_table = '$bo_table'";
    $qry = sql_query($sql, false);

    $mw_board_member = array();
    while ($row = sql_fetch_array($qry)) {
        array_push($mw_board_member, $row[mb_id]);
    }
    $mw_is_board_member = false;
    if (!in_array($member[mb_id], $mw_board_member)) {
        if (!($mw_basic[cf_board_member_list] && $mw_is_list)) {
            alert("게시판에 접근권한이 없습니다.");
        }
    } else {
        $mw_is_board_member = true;
    }
}

// 게시물 목록 셔플 
if (is_null($mw_basic[cf_list_shuffle])) {
    $sql = "alter table $mw[basic_config_table] add cf_list_shuffle char(1) not null";
    sql_query($sql, false);
}

// 첫번째 첨부 이미지 본문 출력 안함 (썸네일용) 
if (is_null($mw_basic[cf_img_1_noview])) {
    $sql = "alter table $mw[basic_config_table] add cf_img_1_noview char(1) not null";
    sql_query($sql, false);
}

// 첨부파일 상단 
if (is_null($mw_basic[cf_file_head])) {
    $sql = "alter table $mw[basic_config_table] add cf_file_head text not null";
    sql_query($sql, false);
}

// 첨부파일 하단 
if (is_null($mw_basic[cf_file_tail])) {
    $sql = "alter table $mw[basic_config_table] add cf_file_tail text not null";
    sql_query($sql, false);
}

// 한사람당 글 한개만 
if (is_null($mw_basic[cf_only_one])) {
    $sql = "alter table $mw[basic_config_table] add cf_only_one char(1) not null";
    sql_query($sql, false);
}

// 배추컨텐츠샵 솔루션 사용
if (is_null($mw_basic[cf_contents_shop])) {
    $sql = "alter table $mw[basic_config_table] add cf_contents_shop char(1) not null";
    sql_query($sql, false);
}

// 컨텐츠 가격
if (is_null($write[wr_contents_price])) {
    $sql = "alter table $write_table add wr_contents_price int not null";
    sql_query($sql, false);
}

// 컨텐츠 사용 도메인 입력
if (is_null($write[wr_contents_domain])) {
    $sql = "alter table $write_table add wr_contents_domain char(1) not null";
    sql_query($sql, false);
}

// 관리자만 dhtml editor 사용
if (is_null($mw_basic[cf_admin_dhtml])) {
    $sql = "alter table $mw[basic_config_table] add cf_admin_dhtml char(1) not null";
    sql_query($sql, false);
}

// 글쓰기 버튼 클릭시 공지
if (is_null($mw_basic[cf_write_notice])) {
    $sql = "alter table $mw[basic_config_table] add cf_write_notice text not null";
    sql_query($sql, false);
}

// 사용자 정의 css
if (is_null($mw_basic[cf_css])) {
    $sql = "alter table $mw[basic_config_table] add cf_css text not null";
    sql_query($sql, false);
}

// 썸네일 비율유지
if (is_null($mw_basic[cf_thumb_keep])) {
    $sql = "alter table $mw[basic_config_table] add cf_thumb_keep char(1) not null";
    sql_query($sql, false);
}

// 이미지 정보 
if (is_null($mw_basic[cf_exif])) {
    $sql = "alter table $mw[basic_config_table] add cf_exif char(1) not null";
    sql_query($sql, false);
}

// 인쇄 
if (is_null($mw_basic[cf_print])) {
    $sql = "alter table $mw[basic_config_table] add cf_print tinyint default '1' not null";
    sql_query($sql, false);
}

// 짧은글주소
if (is_null($mw_basic[cf_umz])) {
    $sql = "alter table $mw[basic_config_table] add cf_umz tinyint default '0' not null";
    sql_query($sql, false);
}
if (is_null($write[wr_umz])) {
    $sql = "alter table $write_table add wr_umz varchar(30) default '' not null";
    sql_query($sql, false);
}

// 짧은글주소 - 자체도메인
if (is_null($mw_basic[cf_shorten])) {
    $sql = "alter table $mw[basic_config_table] add cf_shorten tinyint default '0' not null";
    sql_query($sql, false);
}

// View 본문 상단 파일
if (is_null($mw_basic[cf_include_view_head])) {
    $sql = "alter table $mw[basic_config_table] add cf_include_view_head varchar(255) not null";
    sql_query($sql, false);
}

// View 본문 하단 파일
if (is_null($mw_basic[cf_include_view_tail])) {
    $sql = "alter table $mw[basic_config_table] add cf_include_view_tail varchar(255) not null";
    sql_query($sql, false);
}

// View 첨부파일 상단 파일
if (is_null($mw_basic[cf_include_file_head])) {
    $sql = "alter table $mw[basic_config_table] add cf_include_file_head varchar(255) not null";
    sql_query($sql, false);
}

// View 첨부파일 하단 파일
if (is_null($mw_basic[cf_include_file_tail])) {
    $sql = "alter table $mw[basic_config_table] add cf_include_file_tail varchar(255) not null";
    sql_query($sql, false);
}

// thumb 확장
if (is_null($mw_basic[cf_thumb2_width])) {
    sql_query("alter table $mw[basic_config_table] add cf_thumb2_width smallint not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_thumb2_height smallint not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_thumb3_width smallint not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_thumb3_height smallint not null", false);
}

// 제목스타일
if (is_null($mw_basic[cf_subject_style])) {
    sql_query("alter table $mw[basic_config_table] add cf_subject_style tinyint not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_subject_style_level tinyint not null", false);
}
if (is_null($write[wr_subject_font])) {
    sql_query("alter table $write_table add wr_subject_font varchar(10) not null", false);
    sql_query("alter table $write_table add wr_subject_color varchar(10) not null", false);
}

//sql_query("alter table $mw[basic_config_table] change cf_uploader_point cf_uploader_point int not null", false);
//sql_query("alter table $mw[basic_config_table] change cf_uploader_day cf_uploader_day int not null", false);

// 썸네일2,3 비율유지
if (is_null($mw_basic[cf_thumb2_keep])) {
    sql_query("alter table $mw[basic_config_table] add cf_thumb2_keep char(1) not null", false);
    sql_query("alter table $mw[basic_config_table] add cf_thumb3_keep char(1) not null", false);
}

// 지업로더
if (is_null($mw_basic[cf_guploader])) {
    sql_query("alter table $mw[basic_config_table] add cf_guploader char(1) not null", false);
}

?>
