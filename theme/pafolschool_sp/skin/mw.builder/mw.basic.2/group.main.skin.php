<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sql = "select * from $mw[menu_small_table] where mm_id = '$mm_id' and bo_table <> '' order by ms_order";
$qry = sql_query($sql);

$tables = array();
while ($row = sql_fetch_array($qry)) {
    $tables[] = $row[bo_table];
}
/*
for ($i=0, $max=sizeof($tables); $i<$max; $i++) { 
    $latest = mw_latest("mw.list", $tables[$i], 10, 50, 2, 0);
    if (!$i)
	echo $latest;
    else
	echo "<div class='latest-block'>$latest</div>";
}
*/


// 오른쪽 메뉴 출력
if (!$mw_mmenu[mm_rmenu]) $mw_mmenu[mm_rmenu] = 0;
?>
<style type="text/css">
.group-title { color:#7B7B7B; font-size:11px; height:20px; border-bottom:1px solid #d8d8d8; margin-bottom:10px; font-weight:bold; }
</style>

<!--<div class="group-title"><?=$group[gr_subject]?> &gt; <?=$mw_mmenu[mm_name]?></div>-->
<?=mw_latest_multi("mw.group", $tables, 30, 58, 1, $group[gr_cache])?>

