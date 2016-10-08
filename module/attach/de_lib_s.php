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
switch ($REQUEST_METHOD) {
	case "GET":

	if(!$key) $key = "smenu";

//2008-04-16 종태 현재 테마숫자
$dir1= "./theme/";

$num = 0;
$d1 = opendir($dir1);
while($file = readdir($d1)) {
  if(is_dir($file)) continue;

if(!strstr($file,".")) {
$theme_themi[$num]['api'] =$file;
}

$num++;
}
closedir($dir1);


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



			if(_LATESTBOARD) $latestboard		 = _LATESTBOARD; 	 else  $latestboard	= _THEME;
			 if(_LUNCH) 	$lunch =_LUNCH; 	else  $lunch		= _THEME;	
			 if(_MENU) 	$menu =	_MENU; else 	 $menu		= _THEME;	
			 if(_CALENDAR)		$calendar		=	_CALENDAR;		else  $calendar	= _THEME;	
			 if(_COUNTER)		$counter		= _COUNTER; else  $counter		= _THEME;
			 if(_CLASS) 	$class =	_CLASS; 	else		 $class		= _THEME;	
			 if(_PARTY) 	$party = _PARTY; else  $party		= _THEME;	
			 if(_POLL) 	$poll 	=	_POLL; 	else  $poll	= _THEME; 
			 if(_BANNER) 	$banner 	=	_BANNER; 	else  $banner	= _THEME; 
			 if(_EDUSEARCH) 	$edusearch 	=	_EDUSEARCH; 	else  $edusearch	= _THEME; 
			 if(_LATESTGALLERY) 	$latestgallery 	=	_LATESTGALLERY; 	else  $latestgallery	= _THEME;	
		if(_NEWS) 	$news 	=	_NEWS; 	else  $news	= _THEME;	
		if(_NEWS2) 	$news2 	=	_NEWS2; 	else  $news2	= _THEME;	


	if(!$key) $key = "news";

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
	$tpl->define("CONTENT", Display::getTemplate("attach/de_lib_s.htm"));
	
	 break;
	case "POST":

if(!$mmode) $mmode = "update";
switch ($mmode) {
	case "update":
	
	
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			if($_SESSION[latestboard_ses]) $INI->setVar("latestboard",$_SESSION[latestboard_ses],"attach_main");
			if($_SESSION[lunch_ses]) $INI->setVar("lunch",$_SESSION[lunch_ses],"attach_main");
			if($_SESSION[menu_ses]) $INI->setVar("menu",$_SESSION[menu_ses],"attach_main" );
			if($_SESSION[calendar_ses]) $INI->setVar("calendar",$_SESSION[calendar_ses],"attach_main" );
			if($_SESSION[counter_ses]) $INI->setVar("counter",$_SESSION[counter_ses] ,"attach_main");
			if($_SESSION[class_ses]) $INI->setVar("class",$_SESSION[class_ses] ,"attach_main");
			if($_SESSION[party_ses]) $INI->setVar("party",$_SESSION[party_ses],"attach_main");
			if($_SESSION[poll_ses]) $INI->setVar("poll",$_SESSION[poll_ses],"attach_main");
			if($_SESSION[banner_ses]) $INI->setVar("banner",$_SESSION[banner_ses],"attach_main");
			if($_SESSION[edusearch_ses]) $INI->setVar("edusearch",$_SESSION[edusearch_ses],"attach_main");
			if($_SESSION[latestgallery_ses]) $INI->setVar("latestgallery",$_SESSION[latestgallery_ses],"attach_main");
			if($_SESSION[news_ses]) $INI->setVar("news",$_SESSION[news_ses],"attach_main");
			if($_SESSION[news2_ses]) $INI->setVar("news2",$_SESSION[news2_ses],"attach_main");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
	
	if(!$back) 	echo "<script type='text/javascript'> parent.document.getElementById('tmp').value = '';   parent.location.reload();</script>";	

	
	 break;



	case "session":
	
			if($latestboard) $_SESSION[latestboard_ses] = $latestboard;
			if($lunch)  $_SESSION[lunch_ses] = $lunch;
			if($menu)  $_SESSION[menu_ses] = $menu;
			if($calendar)  $_SESSION[calendar_ses] = $calendar;
			if($counter)  $_SESSION[counter_ses] = $counter;
			if($class)  $_SESSION[class_ses] = $class;
			if($party)  $_SESSION[party_ses] = $party;
			if($poll)  $_SESSION[poll_ses] = $poll;
			if($banner)  $_SESSION[banner_ses] = $banner;
			if($edusearch)  $_SESSION[edusearch_ses] = $edusearch;
			if($latestgallery)  $_SESSION[latestgallery_ses] = $latestgallery;
			if($news)  $_SESSION[news_ses] = $news;
			if($news2)  $_SESSION[news2_ses] = $news2;

	

	
	if(!$back) 	echo "<script type='text/javascript'>  parent.document.getElementById('tmp').value = '';  parent.location.reload();</script>";	

	
	 break;


	case "reset":
	
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("latestboard",_THEME,"attach_main");
			$INI->setVar("lunch",_THEME,"attach_main");
			$INI->setVar("menu",_THEME,"attach_main" );
			$INI->setVar("calendar",_THEME,"attach_main" );
			$INI->setVar("counter",_THEME ,"attach_main");
			$INI->setVar("class",_THEME ,"attach_main");
			$INI->setVar("party",_THEME,"attach_main");
			$INI->setVar("poll",_THEME,"attach_main");
			$INI->setVar("banner",_THEME,"attach_main");
			$INI->setVar("edusearch",_THEME,"attach_main");
			$INI->setVar("latestgallery",_THEME,"attach_main");
			$INI->setVar("news",_THEME,"attach_main");
			$INI->setVar("news2",_THEME,"attach_main");
			
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');

			unset($_SESSION[latestboard_ses]);
			unset($_SESSION[lunch_ses]);
			unset($_SESSION[menu_ses]);
			unset($_SESSION[calendar_ses]);
			unset($_SESSION[counter_ses]);
			unset($_SESSION[class_ses]);
			unset($_SESSION[party_ses]);
			unset($_SESSION[poll_ses]);
			unset($_SESSION[banner_ses]);
			unset($_SESSION[edusearch_ses]);
			unset($_SESSION[latestgallery_ses]);
			unset($_SESSION[news_ses]);
			unset($_SESSION[news2_ses]);
	

		  $dellist=array();

		  $dellist[]="inc.main.banner.htm";
		  $dellist[]="inc.main.calendar.htm";
		  $dellist[]="inc.main.latestboard.G.htm";
		  $dellist[]="inc.main.latestboard1.B.htm";
		  $dellist[]="inc.main.lunch.htm";
		  $dellist[]="inc.main.news.com.htm";
		  $dellist[]="inc.main.news.sch.htm";
  		  $dellist[]="inc.main.news.sch2.htm";
		  $dellist[]="inc.main.poll.htm";
		  $dellist[]="inc.counter.htm";
  		  $dellist[]="inc.class.htm";
   		  $dellist[]="inc.party.htm";
		  $dellist[]="inc.main.banner.htm";

		 


		for($ii=0; $ii<count($dellist); $ii++) {
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
		
		}
		echo "<script type='text/javascript'> parent.document.getElementById('tmp').value = '';   parent.location.reload();</script>";	
	break;
	}

		
	
	
	
	break;
	}

?>

