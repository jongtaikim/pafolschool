<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

@include_once("$mw_index_skin_head_path/menu.more.skin.php");

// 검색창 그룹
$group_select = "<select id='gr_id' name='gr_id' class=select><option value=''>통합검색";
$sql = " select gr_id, gr_subject from $g4[group_table] order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
    $group_select .= "<option value='$row[gr_id]'>$row[gr_subject]";
$group_select .= "</select>";

?>
<link rel="stylesheet" href="<?=$mw_index_skin_head_path?>/style.css" type="text/css"/>

<style type="text/css">
body { text-align:center; }
#mw-index { width:<?=$mw[config][cf_index_width]?>px; margin:10px auto 0 auto; text-align:left; }

#head { text-align:center; }
#head .logo {  }
#head .groups { color:#ddd; font-size:10px; text-align:right; vertical-align:bottom; padding:0 5px 2px 0; } 
#head .groups a { color:#555; font-weight:bold; margin:0 2px 0 2px; }
#head .line { background:url(<?=$mw_index_skin_head_path?>/img/mw_search_div.gif) top center no-repeat; height:3px; line-height:1px; font-size:1px; }
#head .shadow { background:url(<?=$mw_index_skin_head_path?>/img/mw_search_shadow.gif) top center repeat-x; }
#head .shadow { height:2px; line-height:1px; font-size:1px; width:<?=$mw[config][cf_index_width]-20?>px; margin:auto; }
#head .left-link { margin:10px 0 0 10px; }
#head .left-link a { color:#E2F6FF; font-weight:bold; }
#head .right-link { margin:10px 0 0 0; }
#head .right-link a { color:#E2F6FF; font-weight:bold; }
#head .quick-link { filter:DropShadow(Color="#2B5CB0",OffX="1",OffY="1",Positive="1"); float:left; padding:0 8px 0 6px; }
#head .quick-link { letter-spacing:-1px; font-weight:bold; font-family:gulim; color:#fff; font-size:13px; }
#head .keyword-scroll { float:right; width:196px; height:25px; text-align:left; }
#head .keyword-name { float:right; color:#004c7f; font-weight:bold; margin:5px 5px 0 0; }
#head .new-name { float:left; margin:5px 5px 0 5px; color:#004c7f; font-weight:bold; }
#head .new-name a { color:#004c7f; font-weight:bold; }
#head .new-scroll { float:left; height:25px; text-align:left; }
</style>

<div id="mw-index">

<!-- 헤더 시작 -->
<div id="head">
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
<td class="logo"><!-- 사이트 로고 --><a href="<?=$mw[index_url]?>"><img src="<?=$mw_index_skin_head_path?>/img/mw_logo.gif"></a></td>
<td class="groups">
    <!-- 그룹 메뉴 -->
    <? for ($i=0; $i<$mw_groups_head_count; $i++) { ?>
    <? if ($i > 0) echo "l&nbsp;"; ?>
    <a href="<?=$mw_groups_head[$i][gr_url]?>"><?=$mw_groups_head[$i][gr_subject]?></a>
    <? } ?>
</td>
</tr>
</table>

<table width=100% height=90 cellpadding=0 cellspacing=0 border=0>
<tr>
<td width=10><img src="<?=$mw_index_skin_head_path?>/img/mw_search_left.gif"></td>
<td background="<?=$mw_index_skin_head_path?>/img/mw_search_bg.gif" align=center valign=top>

<table width=100% height=50 style="margin-top:10px;" cellpadding=0 cellspacing=0>
<tr>
    <td width=150 align=center valign=top>
	<!-- 좌측배너 -->
	<div class="left-link"><a href="http://g4.miwit.com/bbs/board.php?bo_table=g4_skin">기능 많아 쩔어~<br/>배추스킨 다운로드</a></div>
    </td>
    <td align=center valign=top>
	<!-- 중앙검색창 -->
	<form name=fsearch action="<?=$g4[bbs_path]?>/search.php?sfl=wr_subject&sop=and&stx=">
	<input type="hidden" name="sfl" value="wr_subject||wr_content">
	<?=$group_select?>
	<input type=text size=35 name=stx style="border:1px solid #3173B6; height:21px; font-weight:bold; padding:2px;">
	<input type=image src="<?=$mw_index_skin_head_path?>/img/mw_search_btn.gif" align=absmiddle>
	</form>

	<table style="margin-top:5px; text-align:center;" cellpadding=0 cellspacing=0 border=0>
	<tr>
	    <td><a href="http://www.miwit.com/" class=quick-link>메타검색</a></td>
	    <td><a href="http://g4.miwit.com/" class=quick-link>배추빌더</a></td>
	    <td><a href="http://g4.miwit.com/bbs/board.php?bo_table=g4_skin" class=quick-link>배추스킨</a></td>
	    <td><a href="http://g4.miwit.com/?mw_menu=3" class=quick-link>배추팁</a></td>
	    <td><a href="http://g4.miwit.com/bbs/board.php?bo_table=g4_qna" class=quick-link>질문게시판</a></td>
	    <td><a href="http://bbs.miwit.com/bbs/board.php?bo_table=g4_free" class=quick-link>자유게시판</a></td>
	</tr>
	</table>
    </td>
    <td width=150 align=center valign=top>
	<!-- 우측배너 -->
	<div class="right-link"><a href="http://g4.miwit.com/">포털이 뚝딱!<br/>배추빌더 다운로드</a></div>
    </td>
</tr>
</table>
<div class="line"></div>
<div class="new-name"><a href="<?=$g4[bbs_path]?>/new.php">최근게시물</a> : </div>
<div class="new-scroll"><!-- 최근게시물 --><?=mw_new("mw.index.scroll", 10, 50, 0)?></div> 
<div class="keyword-scroll"><!-- 인기검색어 스크롤 : 스킨, 갯수, 간격 --><?=mw_popular("mw.scroll", 10, 1, 60)?></div>
<div class="keyword-name">인기검색어 : </div>
</td>
<td width=10><img src="<?=$mw_index_skin_head_path?>/img/mw_search_right.gif"></td>
</tr>
</table><div class="shadow"></div></div><!-- head -->


