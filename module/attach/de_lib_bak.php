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

	/*$theme_themi[0]['api'] = "SH1";
	$theme_themi[1]['api'] = "SH2";
	$theme_themi[2]['api'] = "SH3";
	$theme_themi[3]['api'] = "SH4";
	$theme_themi[4]['api'] = "SH5";
	$theme_themi[5]['api'] = "SH6";
	$theme_themi[6]['api'] = "SH7";
	$theme_themi[7]['api'] = "SH8";

	$theme_themi[8]['api'] = "SJ1";

	$theme_themi[9]['api'] = "A2";
	$theme_themi[10]['api'] = "A3";
	$theme_themi[11]['api'] = "A4";
	$theme_themi[12]['api'] = "A5";
	$theme_themi[13]['api'] = "B1";
*/




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






			if(_LATESTBOARD)  $latestboard		 =  _LATESTBOARD; 	 else    $latestboard	= _THEME;
			if(_LUNCH)				$lunch			=_LUNCH;				else			  $lunch		= _THEME;	
			if(_MENU)				$menu			=	_MENU;			else				  $menu		= _THEME;	
			if(_CALENDAR)		$calendar		=	_CALENDAR;		else			  $calendar	= _THEME;	
			if(_COUNTER)		$counter		= _COUNTER;			else			  $counter		= _THEME;
			if(_CLASS)				$class			=	_CLASS;				else		  $class		= _THEME;	
			if(_PARTY)				$party			= _PARTY;			else			  $party		= _THEME;	
			if(_POLL)				$poll				=	_POLL;				else			  $poll	= _THEME;			


	if(!$key) $key = "latestboard";

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

		));



	
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("attach/de_lib_bak.htm"));
	
	 break;
	case "POST":

if(!$mmode) $mmode = "update";
switch ($mmode) {
	case "update":
	
	

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			if($latestboard) $INI->setVar("latestboard",$latestboard,"attach_main");
			if($lunch) $INI->setVar("lunch",$lunch,"attach_main");
			if($menu) $INI->setVar("menu",$menu,"attach_main" );
			if($calendar) $INI->setVar("calendar",$calendar,"attach_main" );
			if($counter) $INI->setVar("counter",$counter ,"attach_main");
			if($class) $INI->setVar("class",$class ,"attach_main");
			if($party) $INI->setVar("party",$party,"attach_main");
			if($poll) $INI->setVar("poll ",$poll,"attach_main");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
	
	if(!$back) 	echo "<script type='text/javascript'>    parent.location.reload();</script>";	

	
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
			$INI->setVar("poll ",_THEME,"attach_main");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');


	

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

		 


		for($ii=0; $ii<count($dellist); $ii++) {
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
		
		}
		echo "<script type='text/javascript'>    parent.location.reload();</script>";	
	break;
	}

		
	
	
	
	break;
	}

?>

