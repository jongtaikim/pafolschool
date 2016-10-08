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

if ($is_admin != "super")
    alert_close("접근 권한이 없습니다.");

$sql = "update $mw[basic_config_table] set
bo_table = '$bo_table'
,cf_type = '$cf_type'
,cf_thumb_width = '$cf_thumb_width'
,cf_thumb_height = '$cf_thumb_height'
,cf_thumb2_width = '$cf_thumb2_width'
,cf_thumb2_height = '$cf_thumb2_height'
,cf_thumb3_width = '$cf_thumb3_width'
,cf_thumb3_height = '$cf_thumb3_height'
,cf_attribute = '$cf_attribute'
,cf_ccl = '$cf_ccl'
,cf_hot = '$cf_hot'
,cf_hot_basis = '$cf_hot_basis'
,cf_related = '$cf_related'
,cf_link_blank = '$cf_link_blank'
,cf_comma = '$cf_comma'
,cf_zzal = '$cf_zzal'
,cf_zzal_must = '$cf_zzal_must'
,cf_source_copy = '$cf_source_copy'
,cf_relation = '$cf_relation'
,cf_comment_editor = '$cf_comment_editor'
,cf_comment_emoticon = '$cf_comment_emoticon'
,cf_comment_write = '$cf_comment_write'
,cf_singo = '$cf_singo'
,cf_singo_id = '$cf_singo_id'
,cf_email = '$cf_email'
,cf_sms_id = '$cf_sms_id'
,cf_sms_pw = '$cf_sms_pw'
,cf_hp = '$cf_hp'
,cf_file_head = '$cf_file_head'
,cf_file_tail = '$cf_file_tail'
,cf_content_head = '$cf_content_head'
,cf_content_tail = '$cf_content_tail'
,cf_comment_notice = '$cf_comment_notice'
,cf_download_comment = '$cf_download_comment'
,cf_uploader_day = '$cf_uploader_day'
,cf_uploader_point = '$cf_uploader_point'
,cf_norobot_image = '$cf_norobot_image'
,cf_comment_secret = '$cf_comment_secret'
,cf_desc_len = '$cf_desc_len'
,cf_write_button = '$cf_write_button'
,cf_subject_link = '$cf_subject_link'
,cf_comment_ban = '$cf_comment_ban'
,cf_comment_ban_level = '$cf_comment_ban_level'
,cf_download_log = '$cf_download_log'
,cf_post_history = '$cf_post_history'
,cf_delete_log = '$cf_delete_log'
,cf_post_history_level = '$cf_post_history_level'
,cf_comment_default = '$cf_comment_default'
,cf_link_board = '$cf_link_board'
,cf_list_shuffle = '$cf_list_shuffle'
,cf_notice_name = '$cf_notice_name'
,cf_notice_date = '$cf_notice_date'
,cf_notice_hit = '$cf_notice_hit'
,cf_post_name = '$cf_post_name'
,cf_post_date = '$cf_post_date'
,cf_post_hit = '$cf_post_hit'
,cf_post_num = '$cf_post_num'
,cf_img_1_noview = '$cf_img_1_noview'
,cf_only_one = '$cf_only_one'
,cf_contents_shop = '$cf_contents_shop'
,cf_admin_dhtml = '$cf_admin_dhtml'
,cf_write_notice = '$cf_write_notice'
,cf_thumb_keep = '$cf_thumb_keep'
,cf_thumb2_keep = '$cf_thumb2_keep'
,cf_thumb3_keep = '$cf_thumb3_keep'
,cf_css = '$cf_css'
,cf_exif = '$cf_exif'
,cf_print = '$cf_print'
,cf_umz = '$cf_umz'
,cf_shorten = '$cf_shorten'
,cf_board_member = '$cf_board_member'
,cf_board_member_list = '$cf_board_member_list'
,cf_include_view_head = '$cf_include_view_head'
,cf_include_view_tail = '$cf_include_view_tail'
,cf_include_file_head = '$cf_include_file_head'
,cf_include_file_tail = '$cf_include_file_tail'
,cf_subject_style = '$cf_subject_style'
,cf_subject_style_level = '$cf_subject_style_level'
,cf_guploader = '$cf_guploader'
where bo_table = '$bo_table'";
sql_query($sql);

// 배추 베이직 스킨을 사용하는 모든 게시판을 찾아 환경설정 정보를 입력
// (환경설정 정보가 기존에 없던 것들만!)
$sql = "select * from $g4[board_table] where bo_skin = '$board[bo_skin]'";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry)) {
    $sql = "insert into $mw[basic_config_table] set gr_id = '$row[gr_id]', bo_table = '$row[bo_table]'";
    $qry = sql_query($sql, false);
}

// 전체 적용
$sql = "update $mw[basic_config_table] set bo_table = bo_table ";

if ($chk[cf_type]) $sql .= ", cf_type = '$cf_type' ";
if ($chk[cf_thumb]) $sql .= ", cf_thumb_width = '$cf_thumb_width', cf_thumb_height = '$cf_thumb_height', cf_thumb_keep = '$cf_thumb_keep'";
if ($chk[cf_thumb2]) $sql .= ", cf_thumb2_width = '$cf_thumb2_width', cf_thumb2_height = '$cf_thumb2_height', cf_thumb2_keep = '$cf_thumb2_keep' ";
if ($chk[cf_thumb3]) $sql .= ", cf_thumb3_width = '$cf_thumb3_width', cf_thumb3_height = '$cf_thumb3_height', cf_thumb3_keep = '$cf_thumb3_keep' ";
if ($chk[cf_attribute]) $sql .= ", cf_attribute = '$cf_attribute' ";
if ($chk[cf_ccl]) $sql .= ", cf_ccl = '$cf_ccl' ";
if ($chk[cf_hot]) $sql .= ", cf_hot = '$cf_hot', cf_hot_basis = '$cf_hot_basis' ";
if ($chk[cf_related]) $sql .= ", cf_related = '$cf_related' ";
if ($chk[cf_zzal]) $sql .= ", cf_zzal = '$cf_zzal', cf_zzal_must = '$cf_zzal_must' ";
if ($chk[cf_link_blank]) $sql .= ", cf_link_blank = '$cf_link_blank' ";
if ($chk[cf_comma]) $sql .= ", cf_comma = '$cf_comma' ";
if ($chk[cf_source_copy]) $sql .= ", cf_source_copy = '$cf_source_copy' ";
if ($chk[cf_relation]) $sql .= ", cf_relation = '$cf_relation' ";
if ($chk[cf_comment_editor]) $sql .= ", cf_comment_editor = '$cf_comment_editor' ";
if ($chk[cf_comment_emoticon]) $sql .= ", cf_comment_emoticon = '$cf_comment_emoticon' ";
if ($chk[cf_comment_write]) $sql .= ", cf_comment_write = '$cf_comment_write' ";
if ($chk[cf_singo]) $sql .= ", cf_singo = '$cf_singo' ";
if ($chk[cf_singo_id]) $sql .= ", cf_singo_id = '$cf_singo_id' ";
if ($chk[cf_email]) $sql .= ", cf_email = '$cf_email' ";
if ($chk[cf_hp]) $sql .= ", cf_hp = '$cf_hp', cf_sms_id = '$cf_sms_id', cf_sms_pw = '$cf_sms_pw' ";
if ($chk[cf_file_head]) $sql .= ", cf_file_head = '$cf_file_head' ";
if ($chk[cf_file_tail]) $sql .= ", cf_file_tail = '$cf_file_tail' ";
if ($chk[cf_content_head]) $sql .= ", cf_content_head = '$cf_content_head' ";
if ($chk[cf_content_tail]) $sql .= ", cf_content_tail = '$cf_content_tail' ";
if ($chk[cf_comment_notice]) $sql .= ", cf_comment_notice = '$cf_comment_notice' ";
if ($chk[cf_download_comment]) $sql .= ", cf_download_comment = '$cf_download_comment' ";
if ($chk[cf_uploader_point]) $sql .= ", cf_uploader_day = '$cf_uploader_day', cf_uploader_point = '$cf_uploader_point' ";
if ($chk[cf_norobot_image]) $sql .= ", cf_norobot_image = '$cf_norobot_image' ";
if ($chk[cf_desc_len]) $sql .= ", cf_desc_len = '$cf_desc_len' ";
if ($chk[cf_write_button]) $sql .= ", cf_write_button = '$cf_write_button' ";
if ($chk[cf_subject_link]) $sql .= ", cf_subject_link = '$cf_subject_link' ";
if ($chk[cf_comment_ban]) $sql .= ", cf_comment_ban = '$cf_comment_ban' ";
if ($chk[cf_comment_ban_level]) $sql .= ", cf_comment_ban_level = '$cf_comment_ban_level' ";
if ($chk[cf_download_log]) $sql .= ", cf_download_log = '$cf_download_log' ";
if ($chk[cf_post_history]) $sql .= ", cf_post_history = '$cf_post_history' ";
if ($chk[cf_delete_log]) $sql .= ", cf_delete_log = '$cf_delete_log' ";
if ($chk[cf_post_history_level]) $sql .= ", cf_post_history_level = '$cf_post_history_level' ";
if ($chk[cf_link_board]) $sql .= ", cf_link_board = '$cf_link_board' ";
if ($chk[cf_comment_default]) $sql .= ", cf_comment_default = '$cf_comment_default' ";
if ($chk[cf_list_shuffle]) $sql .= ", cf_list_shuffle = '$cf_list_shuffle' ";
if ($chk[cf_notice_name]) $sql .= ", cf_notice_name = '$cf_notice_name' ";
if ($chk[cf_notice_date]) $sql .= ", cf_notice_date = '$cf_notice_date' ";
if ($chk[cf_notice_hit]) $sql .= ", cf_notice_hit = '$cf_notice_hit' ";
if ($chk[cf_post_name]) $sql .= ", cf_post_name = '$cf_post_name' ";
if ($chk[cf_post_date]) $sql .= ", cf_post_date = '$cf_post_date' ";
if ($chk[cf_post_hit]) $sql .= ", cf_post_hit = '$cf_post_hit' ";
if ($chk[cf_post_num]) $sql .= ", cf_post_num = '$cf_post_num' ";
if ($chk[cf_img_1_noview]) $sql .= ", cf_img_1_noview = '$cf_img_1_noview' ";
if ($chk[cf_only_one]) $sql .= ", cf_only_one = '$cf_only_one' ";
if ($chk[cf_contents_shop]) $sql .= ", cf_contents_shop = '$cf_contents_shop' ";
if ($chk[cf_admin_dhtml]) $sql .= ", cf_admin_dhtml = '$cf_admin_dhtml' ";
if ($chk[cf_write_notice]) $sql .= ", cf_write_notice = '$cf_write_notice' ";
if ($chk[cf_css]) $sql .= ", cf_css = '$cf_css' ";
if ($chk[cf_exif]) $sql .= ", cf_exif = '$cf_exif' ";
if ($chk[cf_print]) $sql .= ", cf_print = '$cf_print' ";
if ($chk[cf_umz]) $sql .= ", cf_umz = '$cf_umz' ";
if ($chk[cf_shorten]) $sql .= ", cf_shorten = '$cf_shorten' ";
if ($chk[cf_include_view_head]) $sql .= ", cf_include_view_head = '$cf_include_view_head' ";
if ($chk[cf_include_view_tail]) $sql .= ", cf_include_view_tail = '$cf_include_view_tail' ";
if ($chk[cf_include_file_head]) $sql .= ", cf_include_file_head = '$cf_include_file_head' ";
if ($chk[cf_include_file_tail]) $sql .= ", cf_include_file_tail = '$cf_include_file_tail' ";
if ($chk[cf_subject_style]) $sql .= ", cf_subject_style = '$cf_subject_style', cf_subject_style_level = '$cf_subject_style_level' ";
if ($chk[cf_guploader]) $sql .= ", cf_guploader = '$cf_guploader' ";
//if ($chk[cf_star]) $sql .= ", cf_star = '$cf_star' ";

$sql .= " where gr_id = '$gr_id' ";

sql_query($sql);


alert("설정을 저장하였습니다.", "mw.config.php?bo_table=$bo_table");
?>
