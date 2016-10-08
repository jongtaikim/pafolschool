<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");

 $sql = "delete from ".TAB_ATTACH_CONFIG." WHERE num_oid=$_OID and str_name not like '%part___' and  str_name not like '%bbs__%'   ";
 $DB->query($sql);
 $DB->commit();


switch (_THEME) {


	case "SH9":
	
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'story', 'LEFT', 1, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'lunch', 'LEFT', 2, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestgallery', 'LEFT', 3, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'banner', 'LEFT', 4, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news', 'MAIN', 1, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news2', 'MAIN', 2, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestboard', 'MAIN', 3, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'schedule', 'MAIN', 4, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'edusearch', 'MAIN', 5, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'party', 'MAIN', 6, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'class', 'MAIN', 7, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'naverwii', 'NONE', 1, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'tv', 'NONE', 2, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'smenu', 'RIGHT', 1, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'vote', 'RIGHT', 2, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'counter', 'RIGHT', 3, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'submenu', 'LEFT', 1, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'class', 'LEFT', 2, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'party', 'LEFT', 3, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'counter', 'NONE', 1, '120px', '100%' )";
$DB->query($sql);
 $DB->commit();
$sql="Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'latestboard', 'NONE', 2, '248px', '100%' )";
$DB->query($sql);
 $DB->commit();





	
	 break;
	
	case "SH8":
	



$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'edusearch', 'LEFT', 1, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'story', 'LEFT', 2, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'banner', 'LEFT', 3, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news', 'MAIN', 1, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news2', 'MAIN', 2, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestgallery', 'MAIN', 3, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'party', 'MAIN', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'class', 'MAIN', 5, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'schedule', 'MAIN', 6, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestboard', 'MAIN', 7, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'tv', 'NONE', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'smenu', 'RIGHT', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'lunch', 'RIGHT', 2, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'vote', 'RIGHT', 3, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'counter', 'RIGHT', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'submenu', 'LEFT', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'latestboard', 'LEFT', 2, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'class', 'LEFT', 3, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'party', 'LEFT', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();




	
	 break;


case "SH9":
	



$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'edusearch', 'LEFT', 1, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'story', 'LEFT', 2, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'banner', 'LEFT', 3, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news', 'MAIN', 1, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news2', 'MAIN', 2, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestgallery', 'MAIN', 3, '248px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'party', 'MAIN', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'class', 'MAIN', 5, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'schedule', 'MAIN', 6, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestboard', 'MAIN', 7, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'tv', 'NONE', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'smenu', 'RIGHT', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'lunch', 'RIGHT', 2, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'vote', 'RIGHT', 3, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'counter', 'RIGHT', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'submenu', 'LEFT', 1, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'latestboard', 'LEFT', 2, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'class', 'LEFT', 3, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'party', 'LEFT', 4, '120px', '100%')";
 $DB->query($sql);
 $DB->commit();




	
	 break;

	case "SH7":


$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'smenu', 'LEFT', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'schedule', 'LEFT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'counter', 'LEFT', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news', 'MAIN', 1, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news2', 'MAIN', 2, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestgallery', 'MAIN', 3, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'edusearch', 'MAIN', 4, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'banner', 'MAIN', 5, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'tv', 'NONE', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'lunch', 'RIGHT', 1, '140px', '100%')"; 
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestboard', 'RIGHT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'class', 'RIGHT', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'party', 'RIGHT', 4, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'vote', 'RIGHT', 5, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'submenu', 'LEFT', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'class', 'LEFT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'party', 'LEFT', 4, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'lunch', 'NONE', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'latestboard', 'NONE', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'counter', 'NONE', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();


	
	break;



	default:

$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'smenu', 'LEFT', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'schedule', 'LEFT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'counter', 'LEFT', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news', 'MAIN', 1, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'news2', 'MAIN', 2, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestgallery', 'MAIN', 3, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'edusearch', 'MAIN', 4, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'banner', 'MAIN', 5, '360px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'tv', 'NONE', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'latestboard', 'RIGHT', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'class', 'RIGHT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'party', 'RIGHT', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'lunch', 'RIGHT', 4, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'main', 'vote', 'RIGHT', 5, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'submenu', 'LEFT', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'class', 'LEFT', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'party', 'LEFT', 4, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'lunch', 'NONE', 1, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'latestboard', 'NONE', 2, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();
$sql = "Insert into TAB_ATTACH_CONFIG
   (NUM_OID, STR_LAYOUT, STR_NAME, STR_LAYER, NUM_STEP, STR_WIDTH, STR_HEIGHT)
 Values
   ($_OID, 'sub', 'counter', 'NONE', 3, '140px', '100%')";
 $DB->query($sql);
 $DB->commit();

break;

	}




	

if($mmode == "Y") {
echo "<meta http-equiv='Refresh' Content=\"0; URL='/attach.admin.manage?layout=main&tmp=reload'\">";
	
}elseif($mmode == "Y2"){
echo "<meta http-equiv='Refresh' Content=\"0; URL='/attach.admin.manage2?layout=main&tmp=reload'\">";
}else{

WebApp::moveBack();
}


?>