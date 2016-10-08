<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16 
* 작성자: 김종태
* 설  명 : 네이버리모컨과 비슷한 디자인 라이브러리 알고리즘 잡기
* 참  고 : 이 프로그램을 잘 사용하면 주신의 왕이 부활 할것임..
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");




$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'latestboard' and str_layer = 'NONE' and str_layout = 'main'  ";
$latestboard_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('latestboard_count'=>$latestboard_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'lunch' and str_layer = 'NONE' and str_layout = 'main' ";
$lunch_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('lunch_count'=>$lunch_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'smenu' and str_layer = 'NONE' and str_layout = 'main' ";
$smenu_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('smenu_count'=>$smenu_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'schedule' and str_layer = 'NONE' and str_layout = 'main' ";
$calendar_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('calendar_count'=>$calendar_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'counter' and str_layer = 'NONE' and str_layout = 'main'  ";
$counter_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('counter_count'=>$counter_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'class'  and str_layer = 'NONE' and str_layout = 'main' ";
$class_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('class_count'=>$class_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'counter' and str_layer = 'NONE' and str_layout = 'main'  ";
$counter_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('counter_count'=>$counter_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'party' and str_layer = 'NONE' and str_layout = 'main'  ";
$party_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('party_count'=>$party_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'vote' and str_layer = 'NONE' and str_layout = 'main'  ";
$poll_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('poll_count'=>$poll_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'banner' and str_layer = 'NONE' and str_layout = 'main'  ";
$banner_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('banner_count'=>$banner_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'edusearch' and str_layer = 'NONE' and str_layout = 'main'  ";
$edusearch_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('edusearch_count'=>$edusearch_count));


$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'latestgallery' and str_layer = 'NONE' and str_layout = 'main'  ";
$latestgallery_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('latestgallery_count'=>$latestgallery_count));



$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'news' and str_layer = 'NONE' and str_layout = 'main'  ";
$news_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('news_count'=>$news_count));

$sql = "select count(str_name) from TAB_ATTACH_CONFIG where num_oid = '$_OID' and str_name =  'news2' and str_layer = 'NONE' and str_layout = 'main'  ";
$news2_count = $DB -> sqlFetchOne($sql);
$tpl->assign(array('news2_count'=>$news2_count));



			if(_LATESTBOARD)  $latestboard		 =  _LATESTBOARD; 	 else    $latestboard	= _THEME;
			if(_LUNCH)				$lunch			=_LUNCH;				else			  $lunch		= _THEME;	
			if(_MENU)				$menu			=	_MENU;			else				  $menu		= _THEME;	
			if(_CALENDAR)		$calendar		=	_CALENDAR;		else			  $calendar	= _THEME;	
			if(_COUNTER)		$counter		= _COUNTER;			else			  $counter		= _THEME;
			if(_CLASS)				$class			=	_CLASS;				else		  $class		= _THEME;	
			if(_PARTY)				$party			= _PARTY;			else			  $party		= _THEME;	
			if(_POLL)				$poll				=	_POLL;				else			  $poll	= _THEME;			
			if(_BANNER)				$banner				=	_BANNER;				else			  $banner	= _THEME;			
			if(_EDUSEARCH)				$edusearch				=	_EDUSEARCH;				else			  $edusearch	= _THEME;			
			if(_LATESTGALLERY)				$latestgallery				=	_LATESTGALLERY;				else			  $latestgallery	= _THEME;	
		if(_NEWS)				$news				=	_NEWS;				else			  $news	= _THEME;	
		if(_NEWS2)				$news2				=	_NEWS2;				else			  $news2	= _THEME;	


	if(!$key) $key = "smenu";

	$tpl->assign(array(
	'key'=>$key,	
	'LIST_demi'=>$theme_themi,
		'r_theme' => _THEME,
		'lunch' => $lunch,
		'menu' => $menu,
		'calendar' => $calendar,
		'counter' => $counter,
		'class' => $class,
		'party' => $party,
		'poll'  => $poll,
		'latestboard'  => $latestboard,
		'banner'  => $banner,
		'edusearch'  => $edusearch,
		'latestgallery'  => $latestgallery,
		'news'  => $news,
		'news2'  => $news2,

		));



	
	
	$tpl->setLayout('admin');

if(_THEME == "JINSUNG"){
	$tpl->define("CONTENT", Display::getTemplate("attach/de_main_no.htm"));	
}else{
$tpl->define("CONTENT", Display::getTemplate("attach/de_main.htm"));	
}

	

?>

