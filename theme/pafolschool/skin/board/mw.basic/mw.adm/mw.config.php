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

$admin_menu[config] = "select";

$g4[title] = "배추 BASIC SKIN 관리자";
//include_once("mw.head.php");
include_once("$g4[path]/head.sub.php");
?>

<link rel="stylesheet" href="<?=$board_skin_path?>/mw.js/ui-lightness/jquery-ui-1.7.2.custom.css" type="text/css"/>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/jquery-1.3.2.min.js"?>"></script>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/jquery-ui.js"?>"></script>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/selectbox.js"?>"></script>
<script type="text/javascript" src="<?="$board_skin_path/mw.js/mw.config.js"?>"></script>
<style type="text/css">
.notice { margin:10px; padding:5px 0 5px 10px; color:#999; border:1px solid #ddd; display:none; }
#board { margin:0 10px 5px 10px; font-weight:bold; text-align:right; }
#tabs { margin:10px; font-family:dotum; font-size:12px; }
#tabs .tabs { margin:0 0 20px 0; }
#tabs .tabs .cf_item { padding:5px 0 5px 0; clear:both; }
#tabs .tabs .cf_item .cf_title { float:left; width:180px; font-weight:bold; }
#tabs .tabs .cf_item .cf_content { float:left; display:block; }
#tabs .tabs .cf_item span.cf_info { font-size:11px; color:#999; margin:0 0 0 10px; }
#tabs .tabs .cf_item span.cf_info a { font-size:11px; color:#999; }
#tabs .tabs .cf_item div.cf_info { font-size:11px; color:#999; margin:5px 0 0 0; }
#tabs .tabs .block { clear:both; }

input.ed { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:0 0 0 3px; }
textarea { border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:0 0 0 3px; }
input.bt { background-color:#efefef; height:20px; cursor:pointer; font-size:11px; font-family:dotum; }

</style>

<script type="text/javascript">
$(document).ready(function () {
    $("#tabs").tabs();
});
</script>

<div><a href="http://www.miwit.com" target="_blank"><img src="<?=$board_skin_path?>/img/logo_curlychoi.gif"></a></div>

<div id="board"><?=$board[bo_subject]?></div>

<form name="cf_form" method=post action="mw.config.update.php">
<input type=hidden name=bo_table value="<?=$bo_table?>">

<div id="tabs">
<ul>
    <li> <a href="#tabs-1">기본설정</a> </li>
    <li> <a href="#tabs-2">모양</a> </li>
    <li> <a href="#tabs-3">기능</a> </li>
    <li> <a href="#tabs-4">알림</a> </li>
    <li> <a href="#tabs-5">데이터</a> </li>
    <li> <a href="#tabs-6">접근권한</a> </li>
    <li> <a href="#tabs-7">플러그인</a> </li>
    <!--<li> <a href="#tabs-8">업그레이드</a> </li>-->
    <li> <a href="#tabs-9">버전확인</a> </li>
</ul>

<div class="notice">
    <input type=checkbox onclick="if (this.checked) all_checked(true); else all_checked(false);">
    체크시 이 그룹에 속한, 이 스킨을 사용하는 모든 게시판에 동일하게 적용합니다.
</div>


<div id="tabs-1" class="tabs"> <!-- 기본설정 -->
    <div class="cf_item">
	<div class="cf_title"><input type=checkbox name=chk[cf_type] value=1>&nbsp;  목록형태 </div>
	<div class="cf_content">
	    <table>
	    <colgroup width="80"/>
	    <colgroup width="80"/>
	    <colgroup width="80"/>
	    <colgroup width="80"/>
	    <tbody valign=top align=center>
	    <tr>
		<td>
		    <img src="<?=$board_skin_path?>/mw.adm/img/cf_type_list.gif" width=40 height=46 required itemname="목록 형태"> <br/>
		    <input type=radio name=cf_type value="list"> 목록형
		</td>
		<td>
		    <img src="<?=$board_skin_path?>/mw.adm/img/cf_type_thumb.gif" width=40 height=46 required itemname="목록 형태"> <br/>
		    <input type=radio name=cf_type value="thumb"> 썸네일형
		</td>
		<td>
		    <img src="<?=$board_skin_path?>/mw.adm/img/cf_type_gall.gif" width=40 height=46 required itemname="목록 형태"> <br/>
		    <input type=radio name=cf_type value="gall"> 갤러리형
		</td>
		<td>
		    <img src="<?=$board_skin_path?>/mw.adm/img/cf_type_desc.gif" width=40 height=46 required itemname="목록 형태"> <br/>
		    <input type=radio name=cf_type value="desc"> 요약형
		</td>
	    </tr>
	    </tbody>
	    </table>
	</div>
	<script type="text/javascript">
	var ct = document.cf_form.cf_type;
	for (i=0; i<ct.length; i++) {
	    if (ct[i].value == "<?=$mw_basic[cf_type]?>") {
		break;
	    }
	}
	document.cf_form.cf_type[i].checked = true;
	</script>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_desc_len] value=1>&nbsp; 요약형 길이 </div>
	<div class="cf_content">
	    <input type=text size=5 name=cf_desc_len class=ed required itemname="요약형 길이" numeric value="<?=$mw_basic[cf_desc_len]?>">
	    <span class="cf_info">(목록에서의 요약내용 글자수. 잘리는 글은 … 로 표시)</span>
	</div>
    </div>


    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_attribute] value=1>&nbsp; 속성 </div>
	<div class="cf_content">
	    <select name=cf_attribute>
	    <option value="basic"> 일반 게시판</option>
	    <option value="1:1"> 1:1 게시판 </option>
	    <option value="anonymous"> 익명 게시판 </option>
	    </select>
	    <script type="text/javascript"> document.cf_form.cf_attribute.value = "<?=$mw_basic[cf_attribute]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_thumb] value=1>&nbsp; 썸네일1 (기본)</div>
	<div class="cf_content">
	    가로 <input type=text size=3 name=cf_thumb_width class=ed value="<?=$mw_basic[cf_thumb_width]?>">px
	    세로 <input type=text size=3 name=cf_thumb_height class=ed value="<?=$mw_basic[cf_thumb_height]?>">px
	    <input type=checkbox name=cf_thumb_keep value=1> 썸네일 비율을 유지합니다.
	    <script type="text/javascript"> document.cf_form.cf_thumb_keep.checked = '<?=$mw_basic[cf_thumb_keep]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_thumb2] value=1>&nbsp; 썸네일2 </div>
	<div class="cf_content">
	    가로 <input type=text size=3 name=cf_thumb2_width class=ed value="<?=$mw_basic[cf_thumb2_width]?>">px
	    세로 <input type=text size=3 name=cf_thumb2_height class=ed value="<?=$mw_basic[cf_thumb2_height]?>">px
	    <input type=checkbox name=cf_thumb2_keep value=1> 썸네일 비율을 유지합니다.
	    <script type="text/javascript"> document.cf_form.cf_thumb2_keep.checked = '<?=$mw_basic[cf_thumb2_keep]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_thumb3] value=1>&nbsp; 썸네일3 </div>
	<div class="cf_content">
	    가로 <input type=text size=3 name=cf_thumb3_width class=ed value="<?=$mw_basic[cf_thumb3_width]?>">px
	    세로 <input type=text size=3 name=cf_thumb3_height class=ed value="<?=$mw_basic[cf_thumb3_height]?>">px
	    <input type=checkbox name=cf_thumb3_keep value=1> 썸네일 비율을 유지합니다.
	    <script type="text/javascript"> document.cf_form.cf_thumb3_keep.checked = '<?=$mw_basic[cf_thumb3_keep]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_hot] value=1>&nbsp; 인기 게시물 </div>
	<div class="cf_content">
	    <select name=cf_hot>
	    <option value="0"> 사용안함 </option>
	    <option value="1"> 실시간 </option>
	    <option value="2"> 주간 </option>
	    <option value="3"> 월간 </option>
	    <option value="4"> 일간 </option>
	    </select>
	    <select name=cf_hot_basis>
	    <option value="hit"> 조회수 </option>
	    <option value="good"> 추천수 </option>
	    </select>
	    <span class="cf_info">(목록상단에 인기게시물을 출력합니다.)</span>
	    <script type="text/javascript">
	    document.cf_form.cf_hot.value = "<?=$mw_basic[cf_hot]?>";
	    document.cf_form.cf_hot_basis.value = "<?=$mw_basic[cf_hot_basis]?>";
	    </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_related] value=1>&nbsp; 관련글 </div>
	<div class="cf_content">
	    <select name=cf_related>
	    <option value="0"> 사용안함 </option>
	    <option value="3"> 3건 출력 </option>
	    <option value="5"> 5건 출력 </option>
	    <option value="7"> 7건 출력 </option>
	    <option value="10"> 10건 출력 </option>
	    </select>
	    <span class="cf_info">(본문하단에 관련 게시물을 출력합니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_related.value = "<?=$mw_basic[cf_related]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_print] value=1>&nbsp; 인쇄 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_print value=1> 사용 <span class="cf_info">(본문 인쇄 기능)</span>  
	    <script type="text/javascript"> document.cf_form.cf_print.checked = <?=$mw_basic[cf_print]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_link_board] value=1>&nbsp; 링크 게시판  </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_link_board value=1> 사용 <span class="cf_info">(제목을 클릭하면 link1 의 주소로 이동, 관리자제외)</span> 
	    <script type="text/javascript"> document.cf_form.cf_link_board.checked = <?=$mw_basic[cf_link_board]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_list_shuffle] value=1>&nbsp; 게시물 목록 셔플 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_list_shuffle value=1> 사용 <span class="cf_info">(페이지 내의 게시물 목록을 섞습니다.)</span>  
	    <script type="text/javascript"> document.cf_form.cf_list_shuffle.checked = '<?=$mw_basic[cf_list_shuffle]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_norobot_image] value=1>&nbsp; 이미지 방지코드 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_norobot_image value=1> 사용 <span class="cf_info">(그누보드 4.22.00 이전 버전은 사용불가)</span>
	    <script type="text/javascript"> document.cf_form.cf_norobot_image.checked = <?=$mw_basic[cf_norobot_image]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_subject_link] value=1>&nbsp; 권한별 제목링크  </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_subject_link value=1> 사용 <span class="cf_info">(권한이 없으면 제목링크를 삭제)</span>
	    <script type="text/javascript"> document.cf_form.cf_subject_link.checked = <?=$mw_basic[cf_subject_link]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_write_button] value=1>&nbsp; 쓰기버튼 항상 출력 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_write_button value=1> 사용 <span class="cf_info">(권한이 없어도 쓰기버튼 출력)</span>
	    <script type="text/javascript"> document.cf_form.cf_write_button.checked = <?=$mw_basic[cf_write_button]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_write] value=1>&nbsp; 코멘트 입력창 출력 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comment_write value=1> 항상
	    <span class="cf_info">(코멘트 입력창을 항상 출력, 로그인 메시지 출력)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_write.checked = <?=$mw_basic[cf_comment_write]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_default] value=1>&nbsp; 코멘트 기본내용 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_comment_default cols=60 rows=5 class=edarea><?=$mw_basic[cf_comment_default]?></textarea>
	    <div class="cf_info">코멘트 기본 입력 내용</div>
	</div>
    </div>


    <div class="block"></div>

</div> <!-- tabs-1 -->

<div id="tabs-2" class="tabs"> <!-- 모양 -->


    <div class="cf_item">
	<div class="cf_title"><input type=checkbox name=chk[cf_notice_name] value=1>&nbsp; 공지사항 이름 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_notice_name value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_notice_name.checked = <?=$mw_basic[cf_notice_name]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"><input type=checkbox name=chk[cf_notice_date] value=1>&nbsp; 공지사항 날짜</div>
	<div class="cf_content">
	    <input type=checkbox name=cf_notice_date value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_notice_date.checked = <?=$mw_basic[cf_notice_date]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_notice_hit] value=1>&nbsp; 공지사항 조회수 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_notice_hit value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_notice_hit.checked = <?=$mw_basic[cf_notice_hit]?>; </script>
	</div>
    </div>


    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_num] value=1>&nbsp; 게시물 번호 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_post_num value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_num.checked = <?=$mw_basic[cf_post_num]?>; </script>
	</div>
    </div>
	
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_name] value=1>&nbsp; 게시물 이름 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_post_name value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_name.checked = <?=$mw_basic[cf_post_name]?>; </script>
	</div>
    </div>
    
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_date] value=1>&nbsp; 게시물 날짜 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_post_date value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_date.checked = <?=$mw_basic[cf_post_date]?>; </script>
	</div>
    </div>
    
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_hit] value=1>&nbsp; 게시물 조회수 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_post_hit value=1> 출력안함 
	    <span class="cf_info">(체크하면 목록에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_hit.checked = <?=$mw_basic[cf_post_hit]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comma] value=1>&nbsp; 콤마 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comma value=1> 사용 <span class="cf_info">(글번호,조회수 등에 3자리마다 콤마출력)</span>
	    <script type="text/javascript"> document.cf_form.cf_comma.checked = <?=$mw_basic[cf_comma]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_subject_style] value=1>&nbsp; 제목 스타일 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_subject_style value=1> 사용
            <select name="cf_subject_style_level">
            <? for ($i=1; $i<=10; $i++) { ?>
            <option value="<?=$i?>"> <?=$i?> </option>
            <? } ?>
            </select> 레벨 이상
            <span class="cf_info">(제목에 글꼴, 색상을 설정할 수 있습니다.)</span>
	    <script type="text/javascript">
            document.cf_form.cf_subject_style.checked = <?=$mw_basic[cf_subject_style]?>;
            document.cf_form.cf_subject_style_level.value = "<?=$mw_basic[cf_subject_style_level]?>";
            </script>
	</div>
    </div>


    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_file_head] value=1>&nbsp; 첨부파일 상단 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_file_head cols=60 rows=5 class=edarea><?=$mw_basic[cf_file_head]?></textarea>
	    <div class="cf_info">첨부파일 링크 상단에 출력될 코드 </div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_file_tail] value=1>&nbsp; 첨부파일 하단 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_file_tail cols=60 rows=5 class=edarea><?=$mw_basic[cf_file_tail]?></textarea>
	    <div class="cf_info">첨부파일 링크 하단에 출력될 코드 </div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_content_head] value=1>&nbsp; 본문상단 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_content_head cols=60 rows=5 class=edarea><?=$mw_basic[cf_content_head]?></textarea>
	    <div class="cf_info">게시글 본문 상단에 출력될 코드 </div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_content_tail] value=1>&nbsp; 본문하단 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_content_tail cols=60 rows=5 class=edarea><?=$mw_basic[cf_content_tail]?></textarea>
	    <div class="cf_info">게시글 본문 하단에 출력될 코드 </div>
	</div>
    </div>


    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_css] value=1>&nbsp; 사용자정의 CSS </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_css cols=60 rows=5 class=edarea><?=$mw_basic[cf_css]?></textarea>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_include_view_head] value=1>&nbsp; View 본문 상단 파일 </div>
	<div class="cf_content">
	    <input type="text" size="60" name="cf_include_view_head" class="ed" value="<?=$mw_basic[cf_include_view_head]?>"> 
	    <div class="cf_info">글본문 상단에 파일을 삽입합니다.</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_include_view_tail] value=1>&nbsp; View 본문 하단 파일 </div>
	<div class="cf_content">
	    <input type="text" size="60" name="cf_include_view_tail" class="ed" value="<?=$mw_basic[cf_include_view_tail]?>"> 
	    <div class="cf_info">글본문 하단에 파일을 삽입합니다.</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_include_file_head] value=1>&nbsp; 첨부파일 상단 파일 </div>
	<div class="cf_content">
	    <input type="text" size="60" name="cf_include_file_head" class="ed" value="<?=$mw_basic[cf_include_file_head]?>"> 
	    <div class="cf_info">글파일 상단에 파일을 삽입합니다.</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_include_file_tail] value=1>&nbsp; 첨부파일 하단 파일 </div>
	<div class="cf_content">
	    <input type="text" size="60" name="cf_include_file_tail" class="ed" value="<?=$mw_basic[cf_include_file_tail]?>"> 
	    <div class="cf_info">글파일 하단에 파일을 삽입합니다.</div>
	</div>
    </div>

    <div class="block"></div>

</div>

<div id="tabs-3" class="tabs"> <!-- 기능 -->


    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_exif] value=1>&nbsp; 이미지 메타정보 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_exif value=1> 사용 <span class="cf_info">(이미지 클릭시 출력됨, 사용시 사진확대기능 off)</span>
	    <script type="text/javascript"> document.cf_form.cf_exif.checked = '<?=$mw_basic[cf_exif]?>'; </script>
	</div>
    </div>
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_ccl] value=1>&nbsp; CCL 표시 </div>
	<div class="cf_content">
	    <select name=cf_ccl>
	    <option value="0"> 사용안함 </option>
	    <option value="1"> 사용 </option>
	    </select>
	    <a href="http://www.creativecommons.or.kr/info/about" target=_blank>CCL<span class="cf_info">(Creative Commons License 알아보기)</span></a>
	    <script type="text/javascript"> document.cf_form.cf_ccl.value = "<?=$mw_basic[cf_ccl]?>"; </script>
	</div>
    </div>
<!--
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_star] value=1>&nbsp; 코멘트 별점 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_star value=1> 사용 <span class="cf_info">(코멘트작성시 별점을 함께 입력합니다.)</span>  
	    <script type="text/javascript"> document.cf_form.cf_star.checked = <?=$mw_basic[cf_star]?>; </script>
	</div>
    </div>
-->

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_link_blank] value=1>&nbsp; 링크 새창 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_link_blank value=1> 사용 <span class="cf_info">(본문의 링크가 무조건 새창으로 열림)</span>
	    <script type="text/javascript"> document.cf_form.cf_link_blank.checked = <?=$mw_basic[cf_link_blank]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_zzal] value=1>&nbsp; 짤방 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_zzal value=1> 사용
	    <input type=checkbox name=cf_zzal_must value=1> 필수
	    <span class="cf_info">(첨부파일을 짤방으로 이용합니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_zzal.checked = <?=$mw_basic[cf_zzal]?>; </script>
	    <script type="text/javascript"> document.cf_form.cf_zzal_must.checked = <?=$mw_basic[cf_zzal_must]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_source_copy] value=1>&nbsp; 출처 자동복사 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_source_copy value=1> 사용 <span class="cf_info">(본문 복사시 출처를 자동으로 복사합니다. IE 전용)</span>
	    <script type="text/javascript"> document.cf_form.cf_source_copy.checked = <?=$mw_basic[cf_source_copy]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_editor] value=1>&nbsp; 코멘트 에디터 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comment_editor value=1> 사용
	    <span class="cf_info">(최소, 최대 코멘트수 제한 기능을 사용할 수 없음)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_editor.checked = <?=$mw_basic[cf_comment_editor]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_emoticon] value=1>&nbsp; 코멘트 이모티콘 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comment_emoticon value=1> 사용
	    <span class="cf_info">(코멘트 에디터 사용시 자동 사용)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_emoticon.checked = <?=$mw_basic[cf_comment_emoticon]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_ban] value=1>&nbsp; 코멘트 허락 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comment_ban value=1> 사용
	    <span class="cf_info">(허락하지 않은 게시물에는 코멘트를 작성할 수 없슴)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_ban.checked = <?=$mw_basic[cf_comment_ban]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_ban_level] value=1>&nbsp; 코멘트 허락 레벨 </div>
	<div class="cf_content">
	    <select name=cf_comment_ban_level>
	    <? for ($i=1; $i<=10; $i++) {?>
	    <option value="<?=$i?>"><?=$i?></option>
	    <? } ?>
	    </select>
	    <span class="cf_info">(코멘트 허락을 사용할 수 있는 레벨)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_ban_level.value = "<?=$mw_basic[cf_comment_ban_level]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_secret] value=1>&nbsp; 코멘트 비밀글 기본 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_comment_secret value=1> 사용
	    <span class="cf_info">(코멘트 입력시 비밀글 체크를 기본으로 합니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_comment_secret.checked = <?=$mw_basic[cf_comment_secret]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_download_comment] value=1>&nbsp; 다운로드 제한 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_download_comment value=1> 사용
	    <span class="cf_info">(코멘트를 남겨야 다운로드 가능)</span>
	    <script type="text/javascript"> document.cf_form.cf_download_comment.checked = <?=$mw_basic[cf_download_comment]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_uploader_point] value=1>&nbsp; 업로더 포인트 </div>
	<div class="cf_content" height=50>
	    <input type=text size=5 name=cf_uploader_day value="<?=$mw_basic[cf_uploader_day]?>" class=ed> 일 동안
	    <input type=text size=5 name=cf_uploader_point value="<?=$mw_basic[cf_uploader_point]?>" class=ed> 포인트 제공<br/>
	    <span class="cf_info">(첨부파일 다운로드시 업로더에게 포인트를 제공. 0일 입력시 무제한)</span>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_img_1_noview] value=1>&nbsp; 첫이미지 출력 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_img_1_noview value=1> 출력안함 
	    <span class="cf_info">(첫번째 첨부이미지를 본문에서 출력하지 않습니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_img_1_noview.checked = '<?=$mw_basic[cf_img_1_noview]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_only_one] value=1>&nbsp; 글한개만 작성가능 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_only_one value=1> 사용 
	    <span class="cf_info">(한사람당 글한개만 작성가능, 예:가입인사)</span>
	    <script type="text/javascript"> document.cf_form.cf_only_one.checked = '<?=$mw_basic[cf_only_one]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_admin_dhtml] value=1>&nbsp; 관리자 에디터 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_admin_dhtml value=1> 사용 
	    <span class="cf_info">(관리자만 DHTML 에디터를 사용하도록 합니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_admin_dhtml.checked = '<?=$mw_basic[cf_admin_dhtml]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_comment_notice] value=1>&nbsp; 코멘트 공지 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_comment_notice cols=60 rows=5 class=edarea><?=$mw_basic[cf_comment_notice]?></textarea>
	    <div class="cf_info">글 작성시 자동 첫번째 코멘트 메시지 표시</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_write_notice] value=1>&nbsp; 글쓰기 버튼 공지 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_write_notice cols=60 rows=5 class=edarea><?=$mw_basic[cf_write_notice]?></textarea>
	    <div class="cf_info">글작성 버튼 클릭시 alert 공지 띄우기</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_guploader] value=1>&nbsp; 멀티업로더</div>
	<div class="cf_content">
	    <input type=checkbox name=cf_guploader value=1> 사용
	    <span class="cf_info">(지업로더, 이미지만 업로드, 회원만 가능)</span>
	    <script type="text/javascript"> document.cf_form.cf_guploader.checked = "<?=$mw_basic[cf_guploader]?>"; </script>
	</div>
    </div>

    <div class="block"></div>

</div> <!-- tabs-3 -->


<div id="tabs-4" class="tabs"> <!-- 알림 -->
    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_singo] value=1>&nbsp; 신고 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_singo value=1> 사용
	    <span class="cf_info">(신고 통보 아이디에 쪽지로 알림)</span>
	    <script type="text/javascript"> document.cf_form.cf_singo.checked = <?=$mw_basic[cf_singo]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_singo_id] value=1>&nbsp; 신고통보 아이디 </div>
	<div class="cf_content" height=60>
	    <input type=text size=60 name=cf_singo_id class=ed value="<?=$mw_basic[cf_singo_id]?>">
	    <div class="cf_info">아이디 , (컴마) 로 구분</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_email] value=1>&nbsp; 글등록 알림메일 </div>
	<div class="cf_content" height=110>
	    <textarea name=cf_email cols=60 rows=5 class=edarea><?=$mw_basic[cf_email]?></textarea>
	    <div class="cf_info">이메일주소 Enter 로 구분</div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_hp] value=1>&nbsp; 글등록 알림문자 </div>
	<div class="cf_content" height=140>
	    <div>
		ID : <input type=text size=10 name=cf_sms_id value="<?=$mw_basic[cf_sms_id]?>" class=ed>
		PW : <input type=text size=10 name=cf_sms_pw value="<?=$mw_basic[cf_sms_pw]?>" class=ed>
		<span class="cf_info">(<a href="http://www.icodekorea.com" target=_blank>ICODEKOREA</a>,
		<a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target=_blank>건당 16원 가입</a>)</span>
	    </div>
	    <textarea name=cf_hp cols=60 rows=5 class=edarea><?=$mw_basic[cf_hp]?></textarea>
	    <div class="cf_info">핸드폰번호 Enter 로 구분</div>
	</div>
    </div>

    <div class="block"></div>
</div> <!-- tabs-4 -->
 
<div id="tabs-5" class="tabs"> <!-- 데이터 -->

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox disabled>&nbsp; 썸네일 재생성 </div>
	<div class="cf_content">
	    썸네일을 모두 다시 생성합니다.
	    <span id=btn_thumb_remake><input type=button class="bt" value="시작" onclick="run_thumb_remake()"></span>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox disabled>&nbsp; 정렬 </div>
	<div class="cf_content">
	    <div> 게시물을 날짜순으로 정렬합니다. <span id=btn_order_date><input type=button class="bt" value="정렬시작" onclick="run_order('date')"></span></div>
	    <div> 게시물을 제목순으로 정렬합니다. <span id=btn_order_subject><input type=button class="bt" value="정렬시작" onclick="run_order('subject')"></span></div>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox disabled>&nbsp; 이모티콘 싱크 </div>
	<div class="cf_content" height=80>
	    디렉토리명 변경으로 이모티콘이 엑박으로 출력되는 것을 수정합니다.<br/>
	    기존 : <input type=text size=30 id=em_old class=ed value="mw.basic.v.1.0.0/emoticon"><br/>
	    신규 : <input type=text size=30 id=em_new class=ed value="mw.basic/mw.emoticon">
	    <span id=btn_emoticon_sync><input type=button class="bt" value="시작" onclick="run_emoticon_sync()"></span>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_download_log] value=1>&nbsp; 다운로드 로그 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_download_log value=1> 사용
	    <span class="cf_info">(다운로드 기록을 남깁니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_download_log.checked = "<?=$mw_basic[cf_download_log]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_history] value=1>&nbsp; 글변경 로그 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_post_history value=1> 사용
	    <span class="cf_info">(수정된 글의 원본을 보관합니다.)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_history.checked = "<?=$mw_basic[cf_post_history]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_delete_log] value=1>&nbsp; 삭제글 남김 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_delete_log value=1> 사용
	    <span class="cf_info">(글을 삭제하면 "삭제되었습니다" 로 변경, 선택삭제는 그냥 삭제됨)</span>
	    <script type="text/javascript"> document.cf_form.cf_delete_log.checked = "<?=$mw_basic[cf_delete_log]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_post_history_level] value=1>&nbsp; 글변경 로그 확인 </div>
	<div class="cf_content">
	    <select name=cf_post_history_level>
	    <? for ($i=1; $i<=10; $i++) {?>
	    <option value="<?=$i?>"><?=$i?></option>
	    <? } ?>
	    </select>
	    <span class="cf_info">(글변경 로그를 확인할 수 있는 레벨)</span>
	    <script type="text/javascript"> document.cf_form.cf_post_history_level.value = "<?=$mw_basic[cf_post_history_level]?>"; </script>
	</div>
    </div>

     <div class="cf_item">
	<div class="cf_title"> <input type=checkbox disabled>&nbsp; 공지사항 순서 변경 </div>
	<div class="cf_content">
	    <select name=bo_notice id=bo_notice multiple style="width:400px; height:200px;">
            <?
            $bo_notice = explode("\n", $board[bo_notice]);
            for ($i=0, $m=sizeof($bo_notice); $i<$m; $i++) { 
                if (!trim($bo_notice[$i])) continue;
                $row = sql_fetch("select wr_id, wr_subject from $write_table where wr_id = '{$bo_notice[$i]}'");
            ?>
                <option value="<?=$row[wr_id]?>"> <?=get_text($row[wr_subject],1)?> </option>
            <? } ?>
	    </select>
            <div style="margin:10px 0 0 0;">
                <input type="button" class="bt" value="↑" onclick="$('#bo_notice').moveOptionUp();">
                <input type="button" class="bt" value="↓" onclick="$('#bo_notice').moveOptionDown();">
                <input type="button" class="bt" value="저장" onclick="bo_notice_submit()">
            </div>
            <script type="text/javascript">
            function bo_notice_submit() {
                var bo_notice = "";
                $('#bo_notice').selectAllOptions();
                $('#bo_notice :selected').each(function (i, sel) {
                    bo_notice += $(sel).val() + "\n";
                });
                $.post("<?=$board_skin_path?>/mw.proc/mw.bo_notice.php", { bo_table:'<?=$bo_table?>', bo_notice:bo_notice }, function (req) {
                    if (req == "true")
                        alert("공지사항 순서변경이 완료되었습니다.");
                    else
                        alert("공지사항 순서변경에 실패하였습니다.");
                });
            }
            </script>
	</div>
    </div>

    <div class="block"></div>
</div> <!-- tabs-5 -->

<div id="tabs-6" class="tabs"> <!-- 접근권한 -->

    <iframe width="720" height="300" style="margin:0 0 10px 0; border:1px solid #ccc;" src="mw.board.member.php?bo_table=<?=$bo_table?>"></iframe>

    <div class="cf_item">
	<div class=cf_title> 게시판 접근권한 </div>
	<div class=cf_content>
	    <input type=checkbox name=cf_board_member value=1> 사용
	    <span class="cf_info">(회원의 게시판 접근권한을 제한함)</span>
	    <script type="text/javascript"> document.cf_form.cf_board_member.checked = "<?=$mw_basic[cf_board_member]?>"; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class=cf_title> 게시판 접근목록 </div>
	<div class=cf_content>
	    <input type=checkbox name=cf_board_member_list value=1> 사용
	    <span class="cf_info">(접근권한이 없어도 목록은 보여줌)</span>
	    <script type="text/javascript"> document.cf_form.cf_board_member_list.checked = "<?=$mw_basic[cf_board_member_list]?>"; </script>
	</div>
    </div>

    <div class="block"></div>
</div> <!-- tabs-6 -->

<div id="tabs-7" class="tabs"> <!-- 플러그인 -->

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_contents_shop] value=1>&nbsp; <strong>배추 컨텐츠샵</strong> </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_contents_shop value=1> 사용 
	    <span class="cf_info">(배추컨텐츠샵 솔루션 구매 및 설치후 사용하실 수 있습니다. ⇒ <a href="http://solution.miwit.com/" target="_blank"><u>구입하기</u></a>)</span>
	    <script type="text/javascript"> document.cf_form.cf_contents_shop.checked = '<?=$mw_basic[cf_contents_shop]?>'; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_umz] value=1>&nbsp; 짧은링크 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_umz value=1> 사용 <span class="cf_info">(게시물마다 umz.kr/xxxxx 형식의 짧은 글주소 자동생성)</span>  
	    <script type="text/javascript"> document.cf_form.cf_umz.checked = <?=$mw_basic[cf_umz]?>; </script>
	</div>
    </div>

    <div class="cf_item">
	<div class="cf_title"> <input type=checkbox name=chk[cf_shorten] value=1>&nbsp; 짧은링크 - 자체도메인 </div>
	<div class="cf_content">
	    <input type=checkbox name=cf_shorten value=1> 사용 <span class="cf_info">(주소:도메인/게시판/글번호 형식, <a href="http://g4.miwit.com/g4_pluginmall/12" target="_blank">플러그인 설치 후 사용가능 ⇒ <u>설치하기 클릭!</u></a>)</span>  
	    <script type="text/javascript"> document.cf_form.cf_shorten.checked = <?=$mw_basic[cf_shorten]?>; </script>
	</div>
    </div>


    <div class="block"></div>
</div> <!-- tabs-7 -->


<div id="tabs-8" class="tabs"> <!-- 업그레이드 -->

</div> <!-- tabs-8 -->


<div id="tabs-9" class="tabs"> <!-- 버전확인 -->

    <div style="font-weight:bold; font-size:15px; margin:0 0 5px 0;"> -버전확인 </div>
    <div><textarea cols="130" rows="10" readonly><?include("../HISTORY")?></textarea></div>

    <div style="font-weight:bold; font-size:15px; margin:10px 0 5px 0;"> - 라이센스 </div>
    <div><textarea cols="130" rows="10" readonly><?include("../LICENSE")?></textarea></div>

</div> <!-- tabs-9 -->



</div> <!-- tabs -->

<p align=center>
    <input type=button class="bt" value="확     인" onclick="document.cf_form.submit();">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type=button class="bt" value="닫     기" onclick="self.close();">
</p>

</form>

<br/>
<br/>

<?
include_once("$g4[path]/tail.sub.php");
?>
