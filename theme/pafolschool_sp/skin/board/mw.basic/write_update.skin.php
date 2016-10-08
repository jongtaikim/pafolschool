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

// CCL 정보 업데이트
$wr_ccl = "";
if ($wr_ccl_by == "by") { $wr_ccl .= "by"; }
if ($wr_ccl_nc == "nc") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "nc"; }
if ($wr_ccl_nd == "nd") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "nd"; }
if ($wr_ccl_nd == "sa") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "sa"; }
sql_query("update $write_table set wr_ccl = '$wr_ccl' where wr_id = '$wr_id'");

// 짤방 업데이트
if ($mw_basic[cf_zzal]) {
    sql_query("update $write_table set wr_zzal = '$wr_zzal' where wr_id = '$wr_id'");
}

// 관련글 업데이트
if ($mw_basic[cf_related]) {
    sql_query("update $write_table set wr_related = '$wr_related' where wr_id = '$wr_id'");
}

// 코멘트 허락
if ($mw_basic[cf_comment_ban] && $mw_basic[cf_comment_ban_level] <= $member[mb_level]) {
    sql_query("update $write_table set wr_comment_ban = '$wr_comment_ban' where wr_id = '$wr_id'");
}

// 로그남김
if ($w == "u" && $mw_basic[cf_post_history]) {
    $wr_name2 = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $sql = "insert into $mw[post_history_table]
               set bo_table = '$bo_table'
                   ,wr_id = '$wr_id'
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

// 지업로더
if ($mw_basic[cf_guploader] == "1" && $is_member) // 싱글모드
{
    $sql = "select * from $mw[guploader_table] where bo_table = '$bo_table' and mb_id = '$member[mb_id]' and bf_ip = '$_SERVER[REMOTE_ADDR]' order by bf_no";
    $qry = sql_query($sql, false);
    for ($i=0; $row=sql_fetch_array($qry); $i++) {
        $source = "$g4[path]/data/guploader/$row[bf_file]";
        $dest = "$g4[path]/data/file/$bo_table/$row[bf_file]";
        @copy($source, $dest);
        @unlink($source);
        sql_query("insert into $g4[board_file_table]
                   set bo_table = '$bo_table'
                     , wr_id = '$wr_id'
                     , bf_no = '$i'
                     , bf_source = '$row[bf_source]'
                     , bf_file = '$row[bf_file]'
                     , bf_filesize = '$row[bf_filesize]'
                     , bf_width = '$row[bf_width]'
                     , bf_height = '$row[bf_height]'
                     , bf_type = '$row[bf_type]'
                     , bf_datetime = '$row[bf_datetime]'");
    }
    sql_query("delete from $mw[guploader_table] where bo_table = '$bo_table' and mb_id = '$member[mb_id]' and bf_ip = '$_SERVER[REMOTE_ADDR]'", false);
}

// 섬네일 생성, 무조건 생성으로 변경 (1.0.6)
//if ($mw_basic[cf_type] != "list") {

// 첫번째 첨부이미지 본문 출력 안할시 (1.1.2);
if ($mw_basic[cf_img_1_noview]) {
    $file = mw_get_first_file($bo_table, $wr_id, true);
    if (!empty($file)) {
        $source_file = "$file_path/{$file[bf_file]}";
        $dest_file = "$thumb_path/{$wr_id}"; 
        @copy($source_file, $dest_file);
    }
}
else
{
    $thumb_file = "";
    $file = mw_get_first_file($bo_table, $wr_id, true);
    if (!empty($file)) {
        $source_file = "$file_path/{$file[bf_file]}";
        $thumb_file = "$thumb_path/{$wr_id}";
        mw_make_thumbnail($mw_basic[cf_thumb_width], $mw_basic[cf_thumb_height], $source_file, $thumb_file, $mw_basic[cf_thumb_keep]);
        if ($mw_basic[cf_thumb2_width])
            @mw_make_thumbnail($mw_basic[cf_thumb2_width], $mw_basic[cf_thumb2_height], $source_file, "{$thumb2_path}/{$wr_id}", $mw_basic[cf_thumb2_keep]);
        if ($mw_basic[cf_thumb3_width])
            @mw_make_thumbnail($mw_basic[cf_thumb3_width], $mw_basic[cf_thumb3_height], $source_file, "{$thumb3_path}/{$wr_id}", $mw_basic[cf_thumb3_keep]);
    } else {
        $thumb_file = "$thumb_path/{$wr_id}";
        preg_match("/<img.*src=\"(.*)\"/iU", $wr_content, $match);
        if ($match[1]) {
            mw_make_thumbnail($mw_basic[cf_thumb_width], $mw_basic[cf_thumb_height], $thumb_file, $thumb_file, $mw_basic[cf_thumb_keep]);
        } else {
            @unlink($thumb_file);
        }
    }
}
//}

// 메일발송 사용 (수정글은 발송하지 않음)
if (!($w == "u" || $w == "cu") && $config[cf_email_use])
{
    $emails = explode("\n", $mw_basic[cf_email]);

    if (count($emails) > 0)
    {
        $wr_subject = get_text(stripslashes($wr_subject));

        $tmp_html = 0;
        if (strstr($html, "html1"))
            $tmp_html = 1;
        else if (strstr($html, "html2"))
            $tmp_html = 2;

        $wr_content = conv_content(stripslashes($wr_content), $tmp_html);

        $warr = array( ""=>"입력", "u"=>"수정", "r"=>"답변", "c"=>"코멘트", "cu"=>"코멘트 수정" );
        $str = $warr[$w];

        $subject = "'{$board[bo_subject]}' 게시판에 {$str}글이 올라왔습니다.";
        $link_url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id&$qstr";

        include_once("$g4[path]/lib/mailer.lib.php");

        ob_start();
        include ("$g4[bbs_path]/write_update_mail.php");
        $content = ob_get_contents();
        ob_end_clean();

        foreach ($emails as $email)
        {
            $email = trim($email);
            if (!$email) continue;
            if ($email == "test@test.com") continue;
            mailer($wr_name, $wr_email, $email, $subject, $content, 1);
	    write_log("$g4[path]/data/mail.log", "$email\n");
        }
    }
}

// SMS 전송
if ($w == "" && $mw_basic[cf_sms_id] && $mw_basic[cf_sms_pw] && trim($mw_basic[cf_hp]) && $is_admin != "super")
{
    $strDest = array();
    $hps = explode("\r\n", $mw_basic[cf_hp]);
    foreach ($hps as $hp) {
        $hp = mw_get_hp($hp, 0);
        if (trim($hp)) {
            $strDest[] = $hp;
        }
    }
    $strCallBack = "0000";
    $strData = "{$board[bo_subject]} 게시판에 {$wr_name} 님이 글을 올리셨습니다.";
    include("$board_skin_path/mw.proc/mw.proc.sms.php");
}


//컨텐츠 가격 및 사용도메인
if ($mw_basic[cf_contents_shop]) {
    sql_query("update $write_table set wr_contents_price = '$wr_contents_price', wr_contents_domain = '$wr_contents_domain' where wr_id = '$wr_id'");
}

// 짧은 글주소 사용
if ($mw_basic[cf_umz]) {
    $url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id";
    $umz = umz_get_url($url);
    sql_query("update $write_table set wr_umz = '$umz' where wr_id = '$wr_id'");
}

// 제목 스타일
if ($mw_basic[cf_subject_style] && $mw_basic[cf_subject_style_level] >= $member[mb_level]) {
    sql_query("update $write_table set wr_subject_font = '$wr_subject_font', wr_subject_color = '$wr_subject_color' where wr_id = '$wr_id'");
}


?>
