<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/plugin/board_group/lib.php");

// 메인 배너
$main_banner = array();

$main_banner[0][url] = "http://g4.miwit.com";
$main_banner[0][img] = "$mw_index_skin_main_path/img/main-banner.gif";
$main_banner[0][tar] = "_self";
$main_banner[1][url] = "http://point.miwit.com/plugin/cybercash/";
$main_banner[1][img] = "$mw_index_skin_main_path/img/main-banner-cash.gif";
$main_banner[1][tar] = "_self";
$main_banner[2][url] = "http://www.magictoday.co.kr";
$main_banner[2][img] = "$mw_index_skin_main_path/img/main-banner-magictoday.gif";
$main_banner[2][tar] = "_self";
$main_banner[3][url] = "http://bbs.miwit.com/plugin/attendance/";
$main_banner[3][img] = "$mw_index_skin_main_path/img/main-banner-attendance.gif";
$main_banner[3][tar] = "_self";

shuffle($main_banner);
?>

<style type="text/css">
#main { margin:5px 0 0 0; }
#main .latest-block { margin:5px 0 0 0; }
#main .main-ad { margin-top:5px; background-color:#efefef; line-height:25px; text-align:center; }
#main .point_info { height:30px; margin:15px 0 0 0; }
#main .point_info div { float:left; margin:0 0 0 30px; }
</style>


<!-- 메인 시작 -->
<table width="100%" id="main" border=0 cellpadding=0 cellspacing=0>
<tr>
<td width="545" valign="top">
    <div id="main_banner_div" style="height:100px;"><a href="<?=$main_banner[0][url]?>" target="<?=$main_banner[0][tar]?>"
         id="main_banner_url"><img src="<?=$main_banner[0][img]?>" id="main_banner_img" width="545" height="100" border="0"></a></div>

    <div style="margin:5px 0 0 0;">
    <?
    echo mw_board_group("바꿔주삼", "어서오시렵니까?^^", 5, array(
        "B01"   => array("skin" => "mw.board.group.image",      "rows" => 4, "length" => 30, "image_count" => 1),
        "B02"   => array("skin" => "mw.board.group.image",      "rows" => 4, "length" => 30, "image_count" => 1),
        "B03"   => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B04"   => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B05"   => array("skin" => "mw.board.group.image",      "rows" => 4, "length" => 30, "image_count" => 1),
        "B06"   => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
    ));
    ?>
    </div>

    <div style="margin:5px 0 0 0;">
    <?
    echo mw_board_group("바꿔주삼2", "<a href='$g4[bbs_path]/board.php?bo_table=B07'>배추마을에서 함께해요.. ^.^</a>", 7, array(
        "B07"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B08"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B09"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B10"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B11"       => array("skin" => "mw.board.group.image",      "rows" => 4, "length" => 35, "image_count" => 1),
    ));
    ?>
    </div>

    <div style="margin:5px 0 0 0;">
    <?
    echo mw_board_group("바꿔주삼3", "<a href='$g4[bbs_path]/board.php?bo_table=B12'>배추마을에서 함께할까요?</a>", 9, array(
        "B12"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B13"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B14"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B15"       => array("skin" => "mw.board.group.list",       "rows" => 5, "length" => 35, "image_count" => 1),
        "B16"       => array("skin" => "mw.board.group.image",      "rows" => 4, "length" => 35, "image_count" => 1),
    ));
    ?>
    </div>

    <div class="point_info">
        <div style="margin-left:0;"><img src="<?=$mw_index_skin_main_path?>/img/point-title.gif"></div>
        <div style="margin-left:50;"><a href="http://point.miwit.com/page/point/point_policy.php"><img src="<?=$mw_index_skin_main_path?>/img/point-get.gif"></a></div>
        <div style="margin-left:80;"><a href="http://point.miwit.com/plugin/cybercash/index.php"><img src="<?=$mw_index_skin_main_path?>/img/point-cash.gif"></a></div>
    </div>
</td>
<td width="5"></td>
<td valign="top">
    <?=outlogin("mw.outlogin4")?>
    <div class="latest-block"><?=mw_latest("mw.news", "notice", 5, 40, 0, $mw[config][cf_index_cache])?></div>

    <div class="latest-block"><a href="http://www.miwit.com/"><img src="<?=$mw_index_skin_main_path?>/img/mbr-meta.gif" id=mbr border=0></a></div>

    <style type="text/css">
    #mw_image_tab { border:1px solid #e1e1e1; border-bottom:0; margin:5px 0 0 0; height:250px; }
    #mw_image_tab .tab_menupan { height:35px; font-family:dotum; background:url(<?=$mw_index_skin_main_path?>/img/tab_image_bg.gif); }
    #mw_image_tab .tab_menupan .tab_title { display:inline; float:left; margin:15px 30px 0 15px; font-weight:bold; letter-spacing:-1px; }
    #mw_image_tab .tab_menupan .tab_menu { display:inline; float:left; cursor:pointer; margin:0; width:57px; height:35px; text-align:center; letter-spacing:-1px; font-size:11px; }
    #mw_image_tab .tab_menupan .tab_menu div { margin:15px 0 0 0; }
    #mw_image_tab .tab_item { margin:10px 0 0 5px; display:none; }
    </style>
   
    <div id="mw_image_tab">
        <div class="tab_menupan">
            <div class="tab_title"><img src="<?=$mw_index_skin_main_path?>/img/down.gif"></div>
            <div id="tab_menu1" class="tab_menu" onmouseover="mw_image_tab_over(1)"><div>B17</div></div>
            <div id="tab_menu2" class="tab_menu" onmouseover="mw_image_tab_over(2)"><div>B18</div></div>
            <div id="tab_menu3" class="tab_menu" onmouseover="mw_image_tab_over(3)"><div>B19</div></div>
        </div>
        <div id="tab_item1" class="tab_item"><?=mw_latest("mw.index.tab.image", "B17", 8, 20); ?></div>
        <div id="tab_item2" class="tab_item"><?=mw_latest("mw.index.tab.image", "B18", 8, 20); ?></div>
        <div id="tab_item3" class="tab_item"><?=mw_latest("mw.index.tab.image", "B19", 8, 20); ?></div>
    </div>

    <script type="text/javascript">
    function mw_image_tab_over(n) {
        $(".tab_item").each(function () {
            $(this).css("display", "none");
        });
        $(".tab_menu").each(function () {
            $(this).css("font-weight", "normal");
            $(this).css("background", "none");
        });
        $("#tab_item"+n).css("display", "block");
        $("#tab_menu"+n).css("font-weight", "bold");
        $("#tab_menu"+n).css("background", "url(<?=$mw_index_skin_main_path?>/img/tab_image.gif)");
    }
    mw_image_tab_over(1);
    </script>
</td>
</tr>
</table><!-- main -->


<div style=" clear:both; border-top:3px solid #636870; background-color:#fafafa; border-bottom:1px solid #ebebeb; height:35px;">
    <div class="new-name"><a href="<?=$g4[bbs_path]?>/new.php">최근게시물</a> : </div>
    <div class="new-scroll"><!-- 최근게시물 --><?=mw_new("mw.index.scroll", 10, 50, 0)?></div> 

    <div style="float:right; width:250px;">
        <div style="margin:8px 0 0 0;"><a href="#"><img src="<?=$mw_index_skin_main_path?>/img/site-use.gif"></a></div>
    </div>
</div>

<style type="text/css">
.new-name { float:left; margin:10px 5px 0 10px; font-weight:bold; }
.new-name a { font-weight:bold; color:#666; font-size:11px; }
.new-scroll { float:left; height:25px; text-align:left; margin:6px 0 0 0; }
#mw-index-new-layer .item a { color:#666; font-size:11px; }
</style>

</div><!-- mw-index -->

<script type="text/javascript"> fsearch.stx.focus(); </script>


