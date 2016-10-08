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

if (!$is_member && !$is_comment_write && $mw_basic[cf_comment_write]) {
    $write_error = "readonly onclick=\"alert('로그인 하신 후 코멘트를 작성하실 수 있습니다.'); return false;\"";
}

if ($is_comment_write) {
    if ($mw_basic[cf_comment_ban] && $write[wr_comment_ban]) {
        $is_comment_write = false;
    }
}

if ($cwin==1) {
    echo "<link rel='stylesheet' href='$board_skin_path/style.common.css' type='text/css'>";
    echo "<style type='text/css'> #mw_basic { width:98%; padding:10px; } </style>";
    echo "<div id=mw_basic>";
}

?>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
</script>

<? if ($cwin==1) { ?><table width=100% cellpadding=10 align=center><tr><td><?}?>

<!-- 코멘트 리스트 -->
<div id="commentContents">

<? if ($mw_basic[cf_comment_notice]) { ?>

<table width=100% cellpadding=0 cellspacing=0>
<tr>
    <td></td>
    <td width="100%">
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <!-- 이름, 아이피 -->
            <td>
                <span class=mw_basic_comment_name><img src="<?=$board_skin_path?>/img/icon_notice.gif"></span>
            </td>
            <!-- 링크 버튼, 코멘트 작성시간 -->
            <td align=right>
                <span class=mw_basic_comment_datetime><?=substr($view[wr_datetime],0,10)." (".get_yoil($view[wr_datetime]).") ".substr($view[wr_datetime],11,5)?></span>
            </td>
        </tr>
        </table>
        <table width=100% cellpadding=0 cellspacing=0 class=mw_basic_comment_notice>
        <tr>
            <td colspan=2>
                <div><?=get_text($mw_basic[cf_comment_notice], 1)?></div>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>
<br/>

<? } ?>

<?
for ($i=0; $i<count($list); $i++) {
    $comment_id = $list[$i][wr_id];
    if ($mw_basic[cf_singo]) {
        $list[$i][singo_href] = "javascript:btn_singo($comment_id, $view[wr_parent])";
    }

    $html = 0;
    if (strstr($list[$i]['wr_option'], "html1")) $html = 1;
    if (strstr($list[$i]['wr_option'], "html2")) $html = 2;

    if ($html > 0) {
        $list[$i][content] = $list[$i][content1]= "비밀글 입니다.";
        if (!strstr($list[$i][wr_option], "secret") ||
            $is_admin ||
            ($write[mb_id]==$member[mb_id] && $member[mb_id]) ||
            ($list[$i][mb_id]==$member[mb_id] && $member[mb_id])) {
            $list[$i][content1] = $list[$i][wr_content];
            $list[$i][content] = conv_content($list[$i][wr_content], $html, 'wr_content');
            $list[$i][content] = search_font($stx, $list[$i][content]);
        }
    }

    // 코멘트 비밀 리플 보이기
    if ($list[$i][content] == "비밀글 입니다.") {
        for ($j=$i-1; $j>=0; $j--) {
            if ($list[$j][wr_comment] == $list[$i][wr_comment] && $list[$j][wr_comment_reply] == substr($list[$i][wr_comment_reply], 0, strlen($list[$i][wr_comment_reply])-1)) {
                if ($list[$j][mb_id] == $member[mb_id]) {
                    $list[$i][content] = conv_content($list[$i][wr_content], $html, 'wr_content');
                    $list[$i][content] = search_font($stx, $list[$i][content]);
                }
                break;
            }
        }
    }

    // 로그버튼
    $history_href = "";
    if ($mw_basic[cf_post_history] && $member[mb_level] >= $mw_basic[cf_post_history_level]) {
        $history_href = "javascript:btn_history({$list[$i][wr_id]})";
    }

    if ($mw_basic[cf_attribute] == "anonymous") $list[$i][name] = "익명"; 

    if (!$is_comment_write) {
	$list[$i][is_edit] = false;
	$list[$i][is_reply] = false;
    }

    $is_comment_image = false;
    $comment_image = "$board_skin_path/img/noimage.gif";
    if ($list[$i][mb_id] && file_exists("$comment_image_path/{$list[$i][mb_id]}")) {
        $comment_image = "$comment_image_path/{$list[$i][mb_id]}";
        $is_comment_image = true;
    }
?>
<a name="c_<?=$comment_id?>"></a>

<table width=100% height="1" cellpadding=0 cellspacing=0 style="margin-bottom:5px;">
<tr>
    <td style="line-height:0;"><? for ($k=0; $k<strlen($list[$i][wr_comment_reply]); $k++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?></td>
    <td width="100%" height="1" bgcolor="#dddddd"></td>
</tr>
</table>

<table width=100% cellpadding=0 cellspacing=0>
<tr>
    <td><? for ($k=0; $k<strlen($list[$i][wr_comment_reply]); $k++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?></td>

    <td valign="top" style="text-align:left;">
        <? if ($is_member && $list[$i][mb_id] == $member[mb_id]) { ?><!--
        --><a href="javascript:mw_member_photo()" onfocus="this.blur()"><? } ?><img src="<?=$comment_image?>" 
            style="width:58px; height:58px; border:3px solid #f2f2f2; margin:0 10px 5px 0;"></a>
        <? if ($is_member && $list[$i][mb_id] == $member[mb_id] && !$is_comment_image) { ?>
        <div style="margin:0 0 0 10px;"><a href="javascript:mw_member_photo()" style="font-size:11px; color:#aaa; text-decoration:none;">사진등록</a></div>
        <? } ?>
        <script type="text/javascript">
        function mw_member_photo() {
            win_open('<?=$board_skin_path?>/mw.proc/mw.comment.image.php?bo_table=<?=$bo_table?>','comment_image','width=500,height=280');
        }
        </script>
    </td>
    <td width="2" bgcolor="#dedede"><div style="width:2px;"></div></td>
    <td><div style="width:10px;"></div></td>

    <td width="100%" valign="top">
        <table width=100% height="28" cellpadding=0 cellspacing=0 style="background:url(<?=$board_skin_path?>/img/co_title_bg.gif);">
        <tr>
            <!-- 이름, 아이피 -->
            <td>
                <span class=mw_basic_comment_name><?=$list[$i][name]?></span>
                <? if ($is_ip_view) { ?> <span class=mw_basic_comment_ip>(<?=$list[$i][ip]?>)</span> <?}?>
            </td>
            <!-- 링크 버튼, 코멘트 작성시간 -->
            <td align=right>
                <? if ($history_href) { echo "<a href=\"$history_href\"><img src=\"$board_skin_path/img/btn_comment_history.gif\" align=absmiddle title=\"변경기록\"></a>"; } ?>
                <? if ($list[$i][is_reply]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'c');\"><img src='$board_skin_path/img/btn_comment_reply.gif' border=0 align=absmiddle title='답변'></a> "; } ?>
                <? if ($list[$i][is_edit]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'cu');\"><img src='$board_skin_path/img/btn_comment_update.gif' border=0 align=absmiddle title='수정'></a> "; } ?>
                <? if ($list[$i][is_del])  { echo "<a href=\"javascript:comment_delete('{$list[$i][del_link]}');\"><img src='$board_skin_path/img/btn_comment_delete.gif' border=0 align=absmiddle title='삭제'></a> "; } ?>
                <? if ($list[$i][singo_href]) { ?><a href="<?=$list[$i][singo_href]?>"><img src="<?=$board_skin_path?>/img/btn_singo.gif" align=absmiddle title='신고'></a><?}?>
		<? if ($is_admin) { ?>
		<img src="<?=$board_skin_path?>/img/btn_intercept_small.gif" align=absmiddle title='접근차단' style="cursor:pointer" onclick="btn_intercept('<?=$list[$i][mb_id]?>')">
		<img src="<?=$board_skin_path?>/img/btn_ip.gif" align=absmiddle title='IP조회' style="cursor:pointer" onclick="btn_ip('<?=$list[$i][wr_ip]?>')">
		<? } ?>
                <span class=mw_basic_comment_datetime><?=substr($list[$i][wr_datetime],0,10)." (".get_yoil($list[$i][wr_datetime]).") ".substr($list[$i][wr_datetime],11,5)?></span>
            </td>
        </tr>
        </table>

        <table width=100% cellpadding=0 cellspacing=0 class=mw_basic_comment_content>
        <tr>
            <td valign="top">
                <!-- 코멘트 출력 -->
                <div id=view_<?=$list[$i][wr_id]?>>
                <?
                $str = $list[$i][content];
                if (strstr($list[$i][wr_option], "secret")) {
                    $str = "<span class='mw_basic_comment_secret'>* $str</span>";
                }
                $str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
                $str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
                $str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);'>", $str);
                echo $str;
                ?>
                </div>
                <? if ($list[$i][trackback]) { echo "<p>".$list[$i][trackback]."</p>"; } ?>
                <? if ($mw_basic[cf_source_copy]) { // 출처 자동 복사 ?>
                <? $copy_url = set_http("{$g4[url]}/{$g4[bbs]}/board.php?bo_table={$bo_table}&wr_id={$wr_id}#c_{$list[$i][wr_id]}"); ?>
                <script type="text/javascript">
                AutoSourcing.setString(<?=$list[$i][wr_id]?> ,"<?=$config[cf_title]?>", "<?=$list[$i][wr_name]?>", "<?=$copy_url?>");
                </script>
                <? } ?>
            </td>
        </tr>
        </table>
        <div id='edit_<?=$comment_id?>' style='display:none;'></div><!-- 수정 -->
        <div id='reply_<?=$comment_id?>' style='display:none;'></div><!-- 답변 -->

        <textarea id='save_comment_<?=$comment_id?>' style='display:none;'><?=get_text($list[$i][wr_content], 0)?></textarea></td>
</tr>
<tr>
    <td colspan="4" height="10"></td>
</tr>
</table>
<? } ?>
</div>
<!-- 코멘트 리스트 -->

<? if ($is_comment_write || $write_error) { ?>

<!-- 코멘트 입력 -->

<? if ($mw_basic[cf_comment_default] && $mw_basic[cf_comment_editor]) $mw_basic[cf_comment_default] = nl2br($mw_basic[cf_comment_default]); ?>

<div style="padding:5px 0 0 0;">
<a href="javascript:comment_box('', 'c');"><img src="<?=$board_skin_path?>/img/btn_comment_insert.gif" border=0></a>
</div>

<div id=mw_basic_comment_write>

<div id=mw_basic_comment_write_form>

<form name="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0;">
<input type=hidden name=w           id=w value='c'>
<input type=hidden name=bo_table    value='<?=$bo_table?>'>
<input type=hidden name=wr_id       value='<?=$wr_id?>'>
<input type=hidden name=comment_id  id='comment_id' value=''>
<input type=hidden name=sca         value='<?=$sca?>' >
<input type=hidden name=sfl         value='<?=$sfl?>' >
<input type=hidden name=stx         value='<?=$stx?>'>
<input type=hidden name=spt         value='<?=$spt?>'>
<input type=hidden name=page        value='<?=$page?>'>
<input type=hidden name=cwin        value='<?=$cwin?>'>
<? if ($mw_basic[cf_comment_editor]) { ?>
<input type=hidden name=html        value='html1'>
<? } ?>

<? if ($is_guest) { ?>
<div style="padding:0 0 2px 0;">
    이름 <input type=text maxlength=20 size=10 name="wr_name" itemname="이름" required class=mw_basic_text <?=$write_error?>>
    패스워드 <input type=password maxlength=20 size=10 name="wr_password" itemname="패스워드" required class=mw_basic_text <?=$write_error?>>
</div>
<?}?>

<div style="padding:2px 0 2px 0;">
    <? if (!$mw_basic[cf_comment_editor]) { ?>
    <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/btn_up.gif" align=absmiddle></span>
    <span style="cursor: pointer;" onclick="textarea_original('wr_content', 5);"><img src="<?=$board_skin_path?>/img/btn_init.gif" align=absmiddle></span>
    <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/btn_down.gif" align=absmiddle></span>
    <? } ?>

    <? if (!$mw_basic[cf_comment_editor] && ($comment_min || $comment_max)) { ?>
    <?
    if ($comment_min > 0) { echo "$comment_min 글자 이상 "; }
    if ($comment_max > 0) { echo "$comment_max 글자 까지 "; }
    echo " 작성하실수 있습니다. ";
    echo "(현재 <span id=char_count>0</span> 글자 작성하셧습니다.) ";
    ?>
    <?}?>
</div>

<table width=98% cellpadding=0 cellspacing=0>
<tr>
    <td>
        <textarea id="wr_content" name="wr_content" rows="5" itemname="내용" required
            <? if (!$write_error) { ?>
                <? if ($mw_basic[cf_comment_editor]) echo "geditor gtag=off "; //mode=off"; ?>
            <? } else echo $write_error?>
            <? if (!$mw_basic[cf_comment_editor] && ($comment_min || $comment_max)) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style='width:100%; word-break:break-all;' class=mw_basic_textarea><?=$mw_basic[cf_comment_default]?></textarea>
            <? if (!$mw_basic[cf_comment_editor] && ($comment_min || $comment_max)) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
    </td>
    <td width=60 align=center>
        <input type="image" src="<?=$board_skin_path?>/img/btn_comment_ok.gif" border=0 accesskey='s' <?=$write_error?>>
    </td>
</tr>
</table>

<div style="padding:2px 0 2px 0;">
    <input type=checkbox id="wr_secret" name="wr_secret" value="secret" <? if ($mw_basic[cf_comment_secret]) echo "checked" ?>>비밀글 (체크하면 글쓴이만 내용을 확인할 수 있습니다.)
    <? if ($mw_basic[cf_comment_emoticon] && !$mw_basic[cf_comment_editor] && !$write_error) {?>
    <span class=mw_basic_comment_emoticon><a href="javascript:win_open('<?=$board_skin_path?>/mw.proc/mw.emoticon.skin.php?bo_table=<?=$bo_table?>','emo','width=600,height=400,scrollbars=yes')">☞ 이모티콘 입력 ☜</a></span>
    <? } ?>
</div>

<? if (file_exists("$g4[bbs_path]/kcaptcha_session.php") && $is_guest) { ?>
<script type="text/javascript"> var md5_norobot_key = ''; </script>
<table border=0 cellpadding=0 cellspacing=0 style="padding:2px 0 2px 0;">
<tr>
    <td width=85>
	<img id='kcaptcha_image' border='0' width=120 height=60 onclick="imageClick();" style="cursor:pointer;"
	     title="글자가 잘안보이는 경우 클릭하시면 새로운 글자가 나옵니다.">
    </td>
    <td>
	<input title="왼쪽의 글자를 입력하세요." type="input" name="wr_key" size="10" itemname="자동등록방지" required class=ed>
	왼쪽의 글자를 입력하세요.
    </td>
</tr>
</table>
<? } elseif ($is_norobot) { ?>
<table border=0 cellpadding=0 cellspacing=0 style="padding:2px 0 2px 0;">
<tr>
    <td width=85>
        <?
        // 이미지 생성이 가능한 경우 자동등록체크코드를 이미지로 만든다.
        if (function_exists("imagecreate") && $mw_basic[cf_norobot_image]) {
            echo "<img src=\"$g4[bbs_path]/norobot_image.php?{$g4['server_time']}\" border=0 align=absmiddle>";
            $norobot_msg = "* 왼쪽의 자동등록방지 코드를 입력하세요.";
        }
        else {
            echo $norobot_str;
            $norobot_msg = "* 왼쪽의 글자중 <FONT COLOR='red'>빨간글자</font>만 순서대로 입력하세요.";
        }
        ?>
    </td>
    <td>
        <input title="왼쪽의 글자중 빨간글자만 순서대로 입력하세요." type=text size=10 name=wr_key itemname="자동등록방지" required class=mw_basic_text <?=$write_error?>>
        <?=$norobot_msg?>
    </td>
</tr>
</table>
<?}?>

</form>

</div>
</div>

<script type="text/javascript">
function imageClick() {
    $.get ("<?=$g4[bbs_path]?>/kcaptcha_session.php", imageClickResult);
}

function imageClickResult(req) { 
    var result = req;
    var img = document.createElement("IMG");
    img.setAttribute("src", "<?=$g4[bbs_path]?>/kcaptcha_image.php?t=" + (new Date).getTime());
    document.getElementById('kcaptcha_image').src = img.getAttribute('src');

    md5_norobot_key = result;
}

var save_before = '';
var save_html = document.getElementById('mw_basic_comment_write').innerHTML;
function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    var s;
    if (s = word_filter_check(document.getElementById('wr_content').value))
    {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        //document.getElementById('wr_content').focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    <? if (!$mw_basic[cf_comment_editor] && ($comment_min || $comment_max)) { ?>
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("코멘트는 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("코멘트는 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else <? } ?> if (!document.getElementById('wr_content').value)
    {
        alert("코멘트를 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('패스워드가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    if (typeof(f.wr_key) != 'undefined')
    {
        if (hex_md5(f.wr_key.value) != md5_norobot_key)
        {
	    alert(hex_md5(f.wr_key.value) + ', ' + md5_norobot_key);
            alert('자동등록방지용 글자가 순서대로 입력되지 않았습니다.');
            f.wr_key.select();
            f.wr_key.focus();
            return false;
        }
    }

    var geditor_status = document.getElementById("geditor_wr_content_geditor_status");
    if (geditor_status != null) {
        if (geditor_status.value == "TEXT") {
            f.html.value = "html2";
        }
        else if (geditor_status.value == "WYSIWYG") {
            f.html.value = "html1";
        }
    }

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 코멘트 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'mw_basic_comment_write';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).innerHTML = save_html;
        // 코멘트 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            <? if (!$mw_basic[cf_comment_editor] && ($comment_min || $comment_max)) { ?>
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            <? } ?>
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        save_before = el_id;
    }
    if (typeof geditor_textareas != "undefined") {
        geditor_load();
    }

    if (work == 'c') {
	<? if (file_exists("$g4[bbs_path]/kcaptcha_session.php") && $is_guest) { ?>
        imageClick();<? } ?>
    }

}


comment_box('', 'c');
</script>


<? } ?>


<script type="text/javascript">
function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}
</script>


<? if ($mw_basic[cf_comment_editor]) { ?>
<script type="text/javascript">
var g4_skin_path = "<?=$board_skin_path?>";
</script>
<script type="text/javascript" src="<?=$board_skin_path?>/mw.geditor/geditor.js"></script>
<? } ?>


<? if($cwin==1) { ?>
</td><tr></table><p align=center><a href="javascript:window.close();"><img src="<?=$board_skin_path?>/img/btn_close.gif" border="0"></a><br><br></div>
<?}?>

