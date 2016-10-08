<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: express.php
* 작성일: 2008-11-27
* 작성자: 이현민
* 설  명: 팝업창 표출 설정(인트라넷 전체팝업설정)
*****************************************************************
* 
*/



	
$DB = &WebApp::singleton('DB');

$sql = "select str_view from TAB_POPUP where num_serial = $ids  ";
$st = $DB -> sqlFetchOne($sql);

if($st =="Y") $res2 = "N"; else $res2 = "Y";



		$sql = "UPDATE ".TAB_POPUP." SET str_view='".$res2."' WHERE  NUM_SERIAL = $ids";
		if($DB->query($sql)){
		echo $oid."|".$ids."|".$res2;
		}
		

//echo $sql;

//echo "{'Code':'00','Message':'ok'}";
//echo "{'Code':'00','Message':'".addslashes($sql)."'}";
//echo "{'Code':'00','Message':'aaaaa'}";
?>
