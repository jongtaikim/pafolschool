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

// 관리자만 dhtml 사용
if ($mw_basic[cf_admin_dhtml] && $is_admin) $is_dhtml_editor = true;

// TEXT 로 작성된 글 에디터로 수정할 때 한줄로 나오는 문제해결
$html = 0;
if (strstr($write['wr_option'], "html1")) $html = 1;
if (strstr($write['wr_option'], "html2")) $html = 2;

if (($html == 0 || $html == 2) && $is_dhtml_editor) {
    $content = nl2br($content);
}

if ($w != "u") {
    $write[wr_zzal] = "짤방";
}

// 글수정 페이지의 첨부파일명 길이 조정
//--------------------------------------------------------------------------
// 가변 파일
$file_script = "";
$file_length = -1;
// 수정의 경우 파일업로드 필드가 가변적으로 늘어나야 하고 삭제 표시도 해주어야 합니다.
if ($w == "u")
{
    for ($i=0; $i<$file[count]; $i++)
    {
        $row = sql_fetch(" select bf_file, bf_content from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
        if ($row[bf_file])
        {
            $file_script .= "add_file(\"<input type='checkbox' name='bf_file_del[$i]' value='1'><a href='{$file[$i][href]}'>".cut_str($file[$i][source], 20)."({$file[$i][size]})</a> 파일 삭제";
            if ($is_file_content)
                //$file_script .= "<br><input type='text' class=ed size=50 name='bf_content[$i]' value='{$row[bf_content]}' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
                // 첨부파일설명에서 ' 또는 " 입력되면 오류나는 부분 수정
                $file_script .= "<br><input type='text' class=ed size=50 name='bf_content[$i]' value='".addslashes(get_text($row[bf_content]))."' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
            $file_script .= "\");\n";
        }
        else
            $file_script .= "add_file('');\n";
    }
    $file_length = $file[count] - 1;
}
if ($file_length < 0)
{
    $file_script .= "add_file('');\n";
    $file_length = 0;
}
?>

<link rel="stylesheet" href="<?=$board_skin_path?>/style.common.css" type="text/css">
<script type="text/javascript" src="<?="$board_skin_path/mw.js/jquery-1.3.2.min.js"?>"></script>

<!-- 글작성 시작 -->
<table width="<?=$width?>" align=center><tr><td id=mw_basic>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$write_min?>); // 최소
var char_max = parseInt(<?=$write_max?>); // 최대
</script>

<form name="fwrite" method="post" action="javascript:fwrite_check(document.fwrite);" enctype="multipart/form-data">
<input type=hidden name=null>
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=wr_id    value="<?=$wr_id?>">
<input type=hidden name=sca      value="<?=$sca?>">
<input type=hidden name=sfl      value="<?=$sfl?>">
<input type=hidden name=stx      value="<?=$stx?>">
<input type=hidden name=spt      value="<?=$spt?>">
<input type=hidden name=sst      value="<?=$sst?>">
<input type=hidden name=sod      value="<?=$sod?>">
<input type=hidden name=page     value="<?=$page?>">

<?
// 익명게시판
if ($mw_basic[cf_attribute] == "anonymous" && $is_guest) {
    $is_name = $is_email = $is_homepage = false;
    echo "<input type=hidden name=wr_name value='익명'>\n";
} 
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<colgroup width=100>
<colgroup width=''>
<tr><td colspan=2 height=2 class=mw_basic_line_color></td></tr>
<tr><td style="padding-left:20px" colspan=2 height=30 bgcolor=#f8f8f9><strong><?=$title_msg?></strong></td></tr>

<? if ($is_name) { ?>
<tr>
    <td class=mw_basic_write_title>· 이름</td>
    <td><input maxlength=20 size=15 name=wr_name itemname="이름" required value="<?=$name?>" class=mw_basic_text></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_password) { ?>
<tr>
    <td class=mw_basic_write_title>· 패스워드</td>
    <td><input type=password maxlength=20 size=15 name=wr_password itemname="패스워드" <?=$password_required?> class=mw_basic_text></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_email) { ?>
<tr>
    <td class=mw_basic_write_title>· 이메일</td>
    <td><input maxlength=100 size=50 name=wr_email email itemname="이메일" value="<?=$email?>" class=mw_basic_text></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_homepage) { ?>
<tr>
    <td class=mw_basic_write_title>· 홈페이지</td>
    <td><input size=50 name=wr_homepage itemname="홈페이지" value="<?=$homepage?>" class=mw_basic_text></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_notice || $is_html || $is_secret || $is_mail) { ?>
<tr>
    <td class=mw_basic_write_title>· 옵션</td>
    <td><? if ($is_notice) { ?><input type=checkbox name=notice value="1" <?=$notice_checked?>>공지&nbsp;<? } ?>
        <? if ($is_dhtml_editor) { ?>
        <input type=hidden value="html1" name="html">
        <? } else { ?>
            <? if ($is_html) { ?>
            <input onclick="html_auto_br(this);" type=checkbox value="<?=$html_value?>" name="html" <?=$html_checked?>><span class=w_title>html</span>&nbsp;
            <? } ?>
        <? } ?>
        <? if ($is_secret) { ?>
            <? if ($is_admin || $is_secret==1) { ?>
            <input type=checkbox value="secret" name="secret" <?=$secret_checked?>><span class=w_title>비밀글</span>&nbsp;
            <? } else { ?>
            <input type=hidden value="secret" name="secret">
            <? } ?>
        <? } ?>
        <? if ($is_mail) { ?><input type=checkbox value="mail" name="mail" <?=$recv_email_checked?>>답변메일받기&nbsp;<? } ?></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_category) { ?>
<tr>
    <td class=mw_basic_write_title>· 분류</td>
    <td><select name=ca_name required itemname="분류"><option value="">선택하세요<?=$category_option?></select></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<tr>
    <td class=mw_basic_write_title>· 제목</td>
    <td><input style="width:100%;" name=wr_subject id="wr_subject" itemname="제목" required value="<?=$subject?>" class=mw_basic_text></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<? if ($mw_basic[cf_subject_style] && $mw_basic[cf_subject_style_level] <= $member[mb_level]) { ?>
<tr>
    <td class=mw_basic_write_title>· 제목 모양</td>
    <td>
        글꼴 : <select name="wr_subject_font" id="wr_subject_font">
        <option value="">글꼴</option>
        <option value="">----</option>
        <option value="굴림">굴림</option>
        <option value="돋움">돋움</option>
        <option value="바탕">바탕</option>
        <option value="궁서">궁서</option>
        </select>
        색상 : <select name="wr_subject_color" id="wr_subject_color">
        <option value="">색상</option>
        <option value="">----</option>
        <option value="#000000" style="color:#000000;">검정</option>
        <option value="#ff9900" style="color:#ff9900;">주황</option>
        <option value="#b3a14d" style="color:#b3a14d;">노랑</option>
        <option value="#3cb371" style="color:#3cb371;">초록</option>
        <option value="#0033ff" style="color:#0033ff;">파랑</option>
        <option value="#000099" style="color:#000099;">남색</option>
        <option value="#9900cc" style="color:#9900cc;">보라</option>
        </select>
        <script type="text/javascript">
        fwrite.wr_subject_font.value = "<?=$write[wr_subject_font]?>";
        fwrite.wr_subject_color.value = "<?=$write[wr_subject_color]?>";
        </script>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<tr>
    <td class=mw_basic_write_title>· 내용</td>
    <td style='padding:5 0 5 0;'>
        <? if (!$is_dhtml_editor) { ?>
        <table width=100%>
        <tr>
            <td width=50% align=left valign=bottom>
                <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/btn_up.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_original('wr_content', 10);"><img src="<?=$board_skin_path?>/img/btn_init.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/btn_down.gif"></span></td>
            <td width=50% align=right><? if ($write_min || $write_max) { ?><span id=char_count></span>글자<?}?></td>
        </tr>
        </table>
        <? } ?>
        <textarea id="wr_content" name="wr_content" style='width:100%; word-break:break-all;' rows=10 itemname="내용" required  class=mw_basic_textarea
        <? if ($is_dhtml_editor) echo "geditor"; ?>
        <? if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?>><?=$content?></textarea>
        <? if ($write_min || $write_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<? if ($mw_basic[cf_contents_shop]) { ?>
<tr>
    <td class=mw_basic_write_title>· <?=$mw_cash[cf_cash_name]?></td>
    <td class=mw_basic_write_content>
        <input type="text" size=10 name="wr_contents_price" required numeric itemname="컨텐츠 가격" value="<?=$write[wr_contents_price]?>" class=mw_basic_text>
	<?=$mw_cash[cf_cash_unit]?> (컨텐츠 가격)
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<tr>
    <td class=mw_basic_write_title>· 사용도메인 </td>
    <td class=mw_basic_write_content>
        <input type="checkbox" name="wr_contents_domain" id="wr_contents_domain" itemname="컨텐츠 사용도메인" value="1">
	<label for="wr_contents_domain">컨텐츠 구입시 사용도메인을 입력 받습니다.</label>
        <script type="text/javascript"> document.fwrite.wr_contents_domain.checked = "<?=$write[wr_contents_domain]?>" </script>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($mw_basic[cf_related]) { ?>
<tr>
    <td class=mw_basic_write_title>· 관련글 키워드</td>
    <td class=mw_basic_write_content height=50>
        <input type="text" size=50 name="wr_related" itemname="관련글 키워드" value="<?=$write[wr_related]?>" class=mw_basic_text> <br/>
        키워드를 , 컴마로 구분하여 입력해주세요. (예 : 한예슬, 얼짱, 몸짱)
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($mw_basic[cf_comment_ban] && $mw_basic[cf_comment_ban_level] <= $member[mb_level]) { ?>
<tr>
    <td class=mw_basic_write_title>· 코멘트 금지</td>
    <td class=mw_basic_write_content>
        <input type=checkbox name=wr_comment_ban value=1> (코멘트를 원하지 않을 경우 체크해주세요.)
        <script type="text/javascript"> document.fwrite.wr_comment_ban.checked = "<?=$write[wr_comment_ban]?>" </script>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($mw_basic[cf_ccl]) { ?>
<tr>
    <td class=mw_basic_write_title>· CCL</td>
    <td class=mw_basic_write_content>
        <select name="wr_ccl_by"><option value="">사용안함</option><option value="by">사용</option></select>
        영리목적 : <select name="wr_ccl_nc"><option value="nc">사용불가</option><option value="">사용가능</option></select>
        변경 : <select name="wr_ccl_nd"><option value="nd">변경불가</option><option value="sa">동일조건변경가능</option><option value="">변경가능</option></select>
        <a href="http://www.creativecommons.or.kr/info/about" target=_blank>CCL이란?</a>
        <? if ($w == "u") {?>
        <script type="text/javascript">
        document.fwrite.wr_ccl_by.value = "<?=$write[wr_ccl][by]?>";
        document.fwrite.wr_ccl_nc.value = "<?=$write[wr_ccl][nc]?>";
        document.fwrite.wr_ccl_nd.value = "<?=$write[wr_ccl][nd]?>";
        </script>
        <? } ?>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_link) { ?>
<? for ($i=1; $i<=$g4[link_count]; $i++) { ?>
<tr>
    <td class=mw_basic_write_title>· 링크 #<?=$i?></td>
    <td class=mw_basic_write_content><input type="text" size=50 name="wr_link<?=$i?>" itemname="링크 #<?=$i?>" value="<?=$write["wr_link{$i}"]?>" class=mw_basic_text></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>
<? } ?>

<? if ($mw_basic[cf_zzal]) { ?>
<tr>
    <td class=mw_basic_write_title>· 짤방 이름</td>
    <td class=mw_basic_write_content><input type="text" size=30 name="wr_zzal" itemname="짤방이름" value="<?=$write[wr_zzal]?>" <? if ($mw_basic[cf_zzal_must]) echo "required"; ?> class=mw_basic_text></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<!-- 지업로더 시작-->
<? if ($mw_basic[cf_guploader]) { ?>
<tr>
    <td class=mw_basic_write_title> 멀티업로더 </td>
    <td class=mw_basic_write_content>
        <script type="text/javascript" src="<?=$board_skin_path?>/mw.guploader/guploader.js"></script>
        <script type="text/javascript">
        var uploader = new guploader('uploader');

        uploader.set_path("<?=$board_skin_path?>/mw.guploader");

        // 업로드 파일 갯수 제한
        uploader.set_file_list_limit("<?=$board[bo_upload_count]?>");

        // 업로드 용량 제한
        uploader.set_file_size_limit("<?=$board[bo_upload_size]?>");

        // 업로드 경로
        <? if ($wr_id) { ?>
        uploader.set_file_path("<?="$g4[path]/data/file/$bo_table"?>");
        <? } else { ?>
        uploader.set_file_path("<?="$g4[path]/data/guploader"?>");
        <? } ?>

        // 업로드 파일경로
        uploader.set_file_action("<?=$g4[url]?>/skin/board/<?=$board[bo_skin]?>/mw.guploader/guploader.php?bo_table=<?=$bo_table?>&mb_id=<?=$member[mb_id]?>&wr_id=<?=$wr_id?>");

        // 업로드 완료 후 실행할 함수
        uploader.set_after_upload("uploader.after_upload");

        // 업로드 완료 후 실행할 함수의 인수
        uploader.set_after_upload_val("bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>");

        // 파일 삭제 함수 정의
        uploader.set_delete_file("uploader.delete_file");

        // 다운로드 실행 파일
        uploader.set_download_file("");

        // 이미지 가로사이즈 제한
        uploader.set_image_width("");

        // 업로더 실행
        uploader.draw_uploader();
        </script>
        <? } ?>
        <!-- 지업로더 끝 -->
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<? if ($is_file && !($mw_basic[cf_guploader] && $is_member)) { ?>
<tr>
    <td class=mw_basic_write_title>
        <table><tr><td style=" padding-top: 10px;">
        · <? if ($mw_basic[cf_zzal]) echo "짤방"; else echo "파일"; ?>
        <span onclick="add_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>+</span>
        <span onclick="del_file();" style='cursor:pointer; font-family:tahoma; font-size:12pt;'>-</span>
        </td></tr></table>
    </td>
    <td class=mw_basic_write_content>
        <table id="variableFiles"></table><?// print_r2($file); ?>
	<? if ($mw_basic[cf_img_1_noview]) { ?>
	첫번째 첨부파일은 썸네일로만 출력됩니다. 본문에 출력되지 않습니다. 
        <? } else if ($mw_basic[cf_zzal] && $mw_basic[cf_zzal_must]) { ?>
        반듯이 첫번째에 짤방 이미지를 첨부하셔야 합니다.
        <? } ?>
        <script type="text/javascript">
        var flen = 0;
        function add_file(delete_code)
        {
            var upload_count = <?=(int)$board[bo_upload_count]?>;
            if (upload_count && flen >= upload_count)
            {
                alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
                return;
            }

            var objTbl;
            var objRow;
            var objCell;
            if (document.getElementById)
                objTbl = document.getElementById("variableFiles");
            else
                objTbl = document.all["variableFiles"];

            objRow = objTbl.insertRow(objTbl.rows.length);
            objCell = objRow.insertCell(0);

            objCell.innerHTML = "<input type='file' id=bf_file_" + flen + " name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능' class=mw_basic_text>";

	    /*
	    str = "<input type='file' id=bf_file_" + flen + " name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능' class=mw_basic_text> ";
	    str+= " <input type='button' value='본문에 넣기' onclick=\"document.getElementById('wr_content').value += '{이미지:" + flen + "}'\"";
	    objCell.innerHTML = str;
	    */

            if (delete_code)
                objCell.innerHTML += delete_code;
            else
            {
                <? if ($is_file_content) { ?>
                objCell.innerHTML += "<br><input type='text' size=50 name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.' class=mw_basic_text>";
                <? } ?>
                ;
            }

            flen++;
        }

        <?=$file_script; //수정시에 필요한 스크립트?>

        function del_file()
        {
            // file_length 이하로는 필드가 삭제되지 않아야 합니다.
            var file_length = <?=(int)$file_length?>;
            var objTbl = document.getElementById("variableFiles");
            if (objTbl.rows.length - 1 > file_length)
            {
                objTbl.deleteRow(objTbl.rows.length - 1);
                flen--;
            }
        }
        </script></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_trackback) { ?>
<tr>
    <td class=mw_basic_write_title>· 트랙백주소</td>
    <td class=mw_basic_write_content><input type="text" size=50 name=wr_trackback itemname="트랙백" value="<?=$trackback?>" class=mw_basic_text>
        <? if ($w=="u") { ?><input type=checkbox name="re_trackback" value="1">핑 보냄<? } ?></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_norobot) { ?>
<tr>
    <td class=mw_basic_write_title>
        <?
        // 이미지 생성이 가능한 경우 자동등록체크코드를 이미지로 만든다.
        if (function_exists("imagecreate") && $mw_basic[cf_norobot_image]) {
            echo "<img src='$g4[bbs_path]/norobot_image.php?{$g4['server_time']}' border='0' align=absmiddle>";
            $norobot_msg = "* 왼쪽의 자동등록방지 코드를 입력하세요.";
        }
        else {
            echo $norobot_str;
            $norobot_msg = "* 왼쪽의 글자중 <FONT COLOR='red'>빨간글자</font>만 순서대로 입력하세요.";
        }
        ?>
    </td>
    <td><input type=input size=10 name=wr_key itemname="자동등록방지" required class=mw_basic_text>
        <span class=mw_basic_norobot><?=$norobot_msg?></span>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if (file_exists("$g4[bbs_path]/kcaptcha_session.php") && $is_guest) { ?>
<script type="text/javascript"> var md5_norobot_key = ''; </script>
<tr>
    <td class=write_head><img id='kcaptcha_image' border='0' width=120 height=60 onclick="imageClick();" style="cursor:pointer;" title="글자가 잘안보이는 경우 클릭하시면 새로운 글자가 나옵니다."></td>
    <td><input class='ed' type=input size=10 name=wr_key itemname="자동등록방지" required>&nbsp;&nbsp;왼쪽의 글자를 입력하세요.</td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>


<tr><td colspan=2 height=1 class=mw_basic_line_color></td></tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="100%" height="30" background="<?=$board_skin_path?>/img/write_down_bg.gif"></td>
</tr>
<tr>
    <td width="100%" align="center" valign="top">
        <input type=image id="btn_submit" src="<?=$board_skin_path?>/img/btn_write.gif" border=0 accesskey='s'>&nbsp;
        <a href="./board.php?bo_table=<?=$bo_table?>"><img id="btn_list" src="<?=$board_skin_path?>/img/btn_list.gif" border=0></a></td>
</tr>
</table>

</td></tr></table>
</form>

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

<? if (!$is_member) { ?>$(imageClick);<? } ?>

<?
// 관리자라면 분류 선택에 '공지' 옵션을 추가함
if ($is_admin)
{
    echo "
    if (typeof(document.fwrite.ca_name) != 'undefined')
    {
        document.fwrite.ca_name.options.length += 1;
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].value = '공지';
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].text = '공지';
    }";
}
?>

with (document.fwrite) {
    if (typeof(wr_name) != "undefined")
        wr_name.focus();
    else if (typeof(wr_subject) != "undefined")
        wr_subject.focus();
    else if (typeof(wr_content) != "undefined")
        wr_content.focus();

    if (typeof(ca_name) != "undefined")
        if (w.value == "u")
            ca_name.value = "<?=$write[ca_name]?>";
}

function html_auto_br(obj) {
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_check(f) {
    var s = "";
    if (s = word_filter_check(f.wr_subject.value)) {
        alert("제목에 금지단어('"+s+"')가 포함되어있습니다");
        return;
    }

    if (s = word_filter_check(f.wr_content.value)) {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        return;
    }

    if (document.getElementById('char_count')) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return;
            }
        }
    }

   if (typeof(f.wr_key) != 'undefined') {
        if (hex_md5(f.wr_key.value) != md5_norobot_key) {
            alert('자동등록방지용 글자가 제대로 입력되지 않았습니다.');
            f.wr_key.select();
            f.wr_key.focus();
            return;
        }
    }

    <? if ($mw_basic[cf_zzal] && $mw_basic[cf_zzal_must]) { ?>
    var zzal = document.getElementById("bf_file_0").value;
    if (f.w.value=='' && !zzal)
    {
        alert("짤방 이미지를 입력해 주세요.");
        return;
    }

    if (f.w.value=='' && !zzal.match(/.(gif|jpg|jpeg|png)$/i))
    {
        alert(document.getElementById("bf_file[]").value + ' 은(는) 이미지 파일이 아닙니다.');
        return;
    }
    <? } ?>

    var geditor_status = document.getElementById("geditor_wr_content_geditor_status");
    if (geditor_status != null) {
        if (geditor_status.value == "TEXT") {
            f.html.value = "html2";
        }
        else if (geditor_status.value == "WYSIWYG") {
            f.html.value = "html1";
        }
    }

    document.getElementById('btn_submit').disabled = true;
    document.getElementById('btn_list').disabled = true;

    f.action = "./write_update.php";
    f.submit();
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>

<? if ($is_dhtml_editor) { ?>
    <script type="text/javascript"> var g4_skin_path = "<?=$board_skin_path?>"; </script>
    <script type="text/javascript" src="<?=$board_skin_path?>/mw.geditor/geditor.js"></script>
    <? if (strstr($write[wr_option], "html2")) { ?>
	<script type="text/javascript"> geditor_wr_content.mode_change(); </script>
    <? } ?>
<? } ?>

<style type="text/css">
<?=$mw_basic[cf_css]?>
</style>


