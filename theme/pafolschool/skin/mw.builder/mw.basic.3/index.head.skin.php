<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

@include_once("$mw_index_skin_head_path/menu.more.skin.php");

?>

<link rel="stylesheet" href="<?=$mw_index_skin_head_path?>/style.css" type="text/css"/>

<style type="text/css">
body { text-align:center; }
#mw-index { width:<?=$mw[config][cf_index_width]?>px; margin:10px auto 0 auto; text-align:left; }

#head {  }
#head .logo { }
#head .groups { color:#ddd; font-size:10px; text-align:right; vertical-align:bottom; padding:0 5px 2px 0; } 
#head .groups a { color:#555; font-weight:bold; margin:0 2px 0 2px; }
#head .line { background:url(<?=$mw_index_skin_head_path?>/img/mw_search_div.gif) top center no-repeat; height:3px; line-height:1px; font-size:1px; }
#head .shadow { background:url(<?=$mw_index_skin_head_path?>/img/mw_search_shadow.gif) top center repeat-x; }
#head .shadow { height:2px; line-height:1px; font-size:1px; width:<?=$mw[config][cf_index_width]-20?>px; margin:auto; }
#head .left-link { margin:10px 0 0 10px; }
#head .left-link a { color:#E2F6FF; font-weight:bold; }
#head .right-link { margin:10px 0 0 0; }
#head .right-link a { color:#E2F6FF; font-weight:bold; }
#head .quick-link { float:left; padding:0 5px 0 5px; }
#head .quick-link { font-family:dotum; color:#383D41; font-size:11px; }
#head .quick-div { color:#ddd; font-size:8pt; }
#head .mw-scrolls { height:25px; margin:5px 0 0 0; }
#head .keyword-scroll { float:right; width:196px; height:25px; text-align:left; margin:6px 0 0 0; }
#head .keyword-name { float:right; color:#004c7f; font-weight:bold; margin:12px 5px 0 0; }
#head .new-name { float:left; margin:5px 5px 0 5px; color:#004c7f; font-weight:bold; }
#head .new-name a { color:#004c7f; font-weight:bold; }
#head .new-scroll { float:left; height:25px; text-align:left; }

#head .mw-index-menu-bar { clear:both; height:36px; margin:10px 0 0 0; background:url(<?=$mw_index_skin_head_path?>/img/search_bar_bg.gif); }
#head .mw-index-menu-bar a:hover,
#head .mw-index-menu-bar a:link,
#head .mw-index-menu-bar a:active,
#head .mw-index-menu-bar a:visited
{ color:#fff; text-decoration:none; font-size:12px; }
#head .mw-index-menu-left { height:36px; float:left; }
#head .mw-index-menu-right { height:36px; float:right; }
#head .mw-index-menu-item { float:left; padding:12px 7px 0 7px; font-weight:bold; }
#head .mw-index-menu-div { width:10px; height:36px; float:left; background:url(<?=$mw_index_skin_head_path?>/img/search_bar_div.gif) center no-repeat; }
#head .mw-index-menu-select1 { height:28px; float:left; padding:0; margin:4px 5px 0 5px; background:url(<?=$mw_index_skin_head_path?>/img/search_select_bg.gif); }
#head .mw-index-menu-select2 { height:28px; float:left; background:url(<?=$mw_index_skin_head_path?>/img/search_select_left.gif) top left no-repeat; padding:0; margin:0; }
#head .mw-index-menu-select3 { height:28px; float:right; padding:7px 10px 0 10px; margin:0; background:url(<?=$mw_index_skin_head_path?>/img/search_select_right.gif) top right no-repeat; }
#head .mw-index-menu-select3 a:hover,
#head .mw-index-menu-select3 a:link,
#head .mw-index-menu-select3 a:active,
#head .mw-index-menu-select3 a:visited
{ color:#000; font-weight:bold; }
#head .search-button {
    width:50px;
    height:35px;
    border:1px solid #5997D3; /*  total color */
    background-color:#5997D3; /*  total color */
    color:#fff;
    font-weight:bold;
}
</style>

<div id="mw-index">

<!-- 헤더 시작 -->
<div id="head">

<table border=0 cellpadding=0 cellspacing=0 style="margin:0 auto 0 auto;" align="center">
<tr>
<td class="logo"><!-- 사이트 로고 --><a href="<?=$mw[index_url]?>"><img src="<?=$mw_index_skin_head_path?>/img/mw_logo.gif"></a></td>
<td width=10></td>
<td style="padding-top:20px;">
    <!-- 중앙검색창 -->
    <form name=fsearch action="<?=$g4[bbs_path]?>/search.php">
    <?//=$group_select?>
    <input type=text size=35 name=stx style="border:5px solid #5997D3; height:35px; font-size:15px; font-weight:bold; padding:5px; ime-mode:active;">
    <input type=submit value="검색" class="search-button">
    </form>
    <table style="margin-top:5px; text-align:center;" cellpadding=0 cellspacing=0 border=0>
    <tr>
	<td><a href="http://www.miwit.com/" class=quick-link>메타검색</a></td><td class=quick-div>|</span></td>
	<td><a href="http://g4.miwit.com/" class=quick-link>배추빌더</a></td><td class=quick-div>|</span></td>
	<td><a href="http://g4.miwit.com/bbs/board.php?bo_table=g4_skin" class=quick-link>배추스킨</a></td><td class=quick-div>|</span></td>
	<td><a href="http://g4.miwit.com/?mw_menu=3" class=quick-link>배추팁</a></td><td class=quick-div>|</span></td>
	<td><a href="http://g4.miwit.com/bbs/board.php?bo_table=g4_qna" class=quick-link>질문게시판</a></td><td class=quick-div>|</span></td>
	<td><a href="http://bbs.miwit.com/bbs/board.php?bo_table=g4_free" class=quick-link>자유게시판</a></td>
    </tr>
    </table>
</td>
<td width=70></td>
</tr>
</table>

<div class="mw-index-menu-bar">
<div class="mw-index-menu-left"><img src="<?=$mw_index_skin_head_path?>/img/search_bar_left.gif"></div>
<!-- 그룹 메뉴 -->
<? for ($i=0; $i<$mw_groups_head_count; $i++) { ?>
<? if ($i > 0) echo "<span class='mw-index-menu-div'></span>"; ?>
<div class="mw-index-menu-item"><a href="<?=$mw_groups_head[$i][gr_url]?>"><?=$mw_groups_head[$i][gr_subject]?></a></div>
<? } ?>
<div class="mw-index-menu-right"><img src="<?=$mw_index_skin_head_path?>/img/search_bar_right.gif"></div>
<div class="keyword-scroll"><!-- 인기검색어 스크롤 : 스킨, 갯수, 간격 --><?=mw_popular("mw.scroll.3", 10, 1, 60)?></div>
<div class="keyword-name">인기검색어 : </div>
</div>

</div><!-- head -->


