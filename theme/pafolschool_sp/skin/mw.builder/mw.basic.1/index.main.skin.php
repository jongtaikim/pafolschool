<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 메인 배너
$main_banner = array();
$main_banner[] = "<a href=\"http://g4.miwit.com\"><img src=\"$mw_index_skin_main_path/img/main-banner.gif\" width=400 height=100></a>";
$main_banner[] = "<a href=\"http://g4.miwit.com\"><img src=\"$mw_index_skin_main_path/img/main-banner-skin.gif\" width=400 height=100></a>";
shuffle($main_banner);

?>

<style type="text/css">
#main { margin:7px 0 0 0; }
#main .latest-block { margin:7px 0 0 0; }
#main .main-ad { margin-top:7px; background-color:#efefef; line-height:25px; text-align:center; }

#tail { margin:10px 0 0 0; border:1px solid #dedede; background-color:#f4f4f4; }
#tail .ad { height:30px; line-height:30px; }
#tail .ad .left a { float:left; margin:0 0 0 10px; letter-spacing:-1px; }
#tail .ad .right a { float:right; margin:0 10px 0 0; letter-spacing:-1px; }

#tail .sitemap { margin:0 5px 5px 5px; padding-left:20px; background-color:#fff; border:1px solid #fff; letter-spacing:-1px; }
#tail .sitemap ul { margin:0; padding:10px 0 10px 0; list-style:none; float:left; }
#tail .sitemap ul.sline { background:url(<?=$mw_index_skin_main_path?>/img/sl.gif) no-repeat left middle; }
#tail .sitemap ul li { margin:0; padding:0; width:125px; }
#tail .sitemap ul li .group { font-weight:bold; padding:0 0 0 10px; height:25px; overflow:hidden; } 
#tail .sitemap ul li .group a { color:#5695D4; }
#tail .sitemap ul li .menu { margin-left:1px; padding:0 0 0 10px; height:20px; overflow:hidden; }
#tail .sl { float:left; }
#tail .sitemap .gag { clear:both; height:1px; line-height:1px; font-size:1px; }
</style>

<!-- 메인 시작 -->
<table width=100% id="main" border=0 cellpadding=0 cellspacing=0>
<tr>
<td width=180 valign=top>
    <!-- 메인 좌측 -->
    <?=outlogin("mw.outlogin2")?>
    <div class="latest-block"><!-- 인기검색어 : 스킨, 갯수, 간격 --><?=mw_popular("mw.index", 10, 1, $mw[config][cf_popular_cache])?></div>
    <div class="latest-block"><?=poll("mw.poll")?></div>
    <div class="latest-block"><a href="http://bbs.miwit.com/bbs/board.php?bo_table=bbs_freelancer"><img src="<?=$mw_index_skin_main_path?>/img/freelancer.gif"></a></div>
    <div class="latest-block"><a href="http://bbs.miwit.com/bbs/board.php?bo_table=bbs_lsy"><img src="<?=$mw_index_skin_main_path?>/img/lsy.gif"></a></div>
    <div class="latest-block"><?=mw_latest("mw.index.side2", "B01", 2, 25, 0, $mw[config][cf_index_cache])?></div>
</td>
<td width=7></td>
<td valign=top>
    <!-- 메인 중앙 -->
    <div><?=$main_banner[0]?></div>
    <div class="latest-block"><!-- 중앙 컨텐츠 --><?=mw_latest_main("mw.index.main", "B02, B03", 8, 35, $mw[config][cf_index_cache])?></div>
    <div class="main-ad"><!-- 한줄 광고 --><a href="http://g4.miwit.com/">포털형 홈페이지 구축, 빌더 프로그램 <b>다운로드 무료!!</b></a></div>
    <div class="latest-block"><?=mw_latest("mw.index.list", "B04", 5, 35, 1, $mw[config][cf_index_cache])?></div>
    <div class="latest-block"><?=mw_latest("mw.index.list", "B05", 5, 35, 1, $mw[config][cf_index_cache])?></div>
    <div class="latest-block"><?=mw_latest_rand("mw.index.list.img", "B06", 3, 40, 0, $mw[config][cf_index_cache])?></div>
</td>
<td width=7></td>
<td width=206 valign=top>
    <!-- 메인 우측 -->
    <!--<div onclick="window.open('http://sir.co.kr/lecture/photoshopcs3/', 'PhotoshopCS3', 'left=0,top=0,width=1017,height=685,scrollbars=1');">
    <div><img src="<?=$mw_index_skin_main_path?>/img/photoshopcs3banner.gif" border="0" alt="포토샵 CS3 무료강좌" width=206 height=100 style="cursor:pointer;"></div>
    </div>-->
    <div><a href="http://www.miwit.com"><img src="<?=$mw_index_skin_main_path?>/img/right-banner.gif" border="0" alt="메타검색 솔루션" width=206 height=100></a></div>
    <div class="latest-block"><?=mw_latest("mw.index.side", "B07", 5, 28, 0, $mw[config][cf_index_cache])?></div>
    <div class="latest-block"><a href="http://www.miwit.com/"><img src="<?=$mw_index_skin_main_path?>/img/right-banner2.gif"></a></div> 
    <div class="latest-block"><?=mw_latest("mw.index.side.img", "B08", 4, 30, 0, $mw[config][cf_index_cache])?></div>
    <div class="latest-block"><?=mw_latest("mw.index.side2", "B09", 5, 28, 0, $mw[config][cf_index_cache])?></div>
</td> 
</tr>
</table><!-- main -->

<!-- 테일 시작 -->
<div id="tail">

<div class="ad">
<div class="left"><a href="http://g4.miwit.com/"><strong>포털</strong>형 홈페이지 구축, 빌더 <strong>프로그램 다운로드</strong> 무료!!</a></div>
<div class="right"><a href="http://www.miwit.com/"><strong>메타검색엔진</strong> 구입</a></div>
</div><!-- ad -->

<div class="sitemap">
<?
for ($i=0; $i<$mw_groups_sitemap_count; $i++) {
    $mw_mmenus = mw_get_middle_menus($mw_groups_sitemap[$i][gr_id]);
    //if ($i!=0) $sline = "class=\"sline\""; else $sline = "";
    echo "<ul $sline>\n";
    echo "<li><div class=\"group\"><a href=\"{$mw_groups_sitemap[$i][gr_url]}\">{$mw_groups_sitemap[$i][gr_subject]}</a></div></li>\n";
    for ($a=0; $a<sizeof($mw_mmenus); $a++) {
	$mw_smenus = mw_get_small_menus($mw_mmenus[$a][mm_id]);
	for ($j=0; $j<sizeof($mw_smenus); $j++) {
	    echo "<li><div class=\"menu\"><a href=\"{$mw_smenus[$j][ms_url]}\">{$mw_smenus[$j][ms_name]}</a></div></li>\n";
	}
    }
    echo "</ul>\n";
    if (($i+1)%6==0) echo "<div class=gag>&nbsp;</div>";
}
?>
<div class="gag"></div>
</div><!-- sitemap -->
</div><!-- tail -->
</div><!-- mw-index -->

<script type="text/javascript">
fsearch.stx.focus();
</script>
