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



if(!$key) $key = "top_menu";



if($auto_save) {

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');

		
			if($_SESSION[top_menu_ses])  $INI->setVar("top_menu",$_SESSION[top_menu_ses],"attach_main");
			if($_SESSION[copyright_ses]) $INI->setVar("copyright",$_SESSION[copyright_ses],"attach_main");
			if($_SESSION[menu_ses]) $INI->setVar("menu",$_SESSION[menu_ses],"attach_main");
			if($_SESSION[counter_ses]) $INI->setVar("counter",$_SESSION[counter_ses],"attach_main");
			if($_SESSION[poll_ses]) $INI->setVar("poll",$_SESSION[poll_ses],"attach_main");
			if($_SESSION[login_ses]) $INI->setVar("login",$_SESSION[login_ses],"attach_main");
			if($_SESSION[latestgallery_ses]) $INI->setVar("latestgallery",$_SESSION[latestgallery_ses],"attach_main");
			if($_SESSION[latestboard_ses]) $INI->setVar("latestboard",$_SESSION[latestboard_ses],"attach_main");
			if($_SESSION[news_ses]) $INI->setVar("news",$_SESSION[news_ses],"attach_main");

			if($_SESSION[main_web_ses]) $INI->setVar("main_web",$_SESSION[main_web_ses],"attach_main");
			if($_SESSION[titlebar_ses]) $INI->setVar("titlebar",$_SESSION[titlebar_ses],"attach_main");

			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
	
echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";
exit;	
}


switch ($REQUEST_METHOD) {


	
case "GET":

//2008-04-16 종태 현재 테마숫자
$dir1= "./theme_lib/".$key."/";

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

if($r_layout =="main") $layout_r = 'main'; else $layout_r = 'sub';
$sql = "select  * from TAB_ATTACH_CONFIG where NUM_OID = "._OID." and str_layout='$layout_r' and str_layer != 'NONE' order by str_name asc ";

$attach_list = $DB -> sqlFetchAll($sql);


$tpl->assign(array('ATTACH_LIST'=>$attach_list));






			if(_TOPMENU)  $top_menu		 =  _TOPMENU; 	 else    $top_menu	= _THEME;
			if(_LATESTBOARD)  $latestboard		 =  _LATESTBOARD; 	 else    $latestboard	= _THEME;
			if(__COPYRIGHT)  $copyright		 =  __COPYRIGHT; 	 else    $copyright	= _THEME;
			if(_MENU)  $menu		 =  _MENU; 	 else    $menu	= _THEME;
			if(_COUNTER)  $counter		 =  _COUNTER; 	 else    $counter	= _THEME;
			if(_POLL)  $poll		 =  _POLL; 	 else    $poll	= _THEME;
			if(_LOGIN)  $login		 =  _LOGIN; 	 else    $login	= _THEME;
			if(_LATESTGALLERY)  $latestgallery		 =  _LATESTGALLERY; 	 else    $latestgallery	= _THEME;
			if(_NEWS)  $news		 =  _NEWS; 	 else    $news	= _THEME;
			if(_MAIN_WEB)  $main_web		 =  _MAIN_WEB; 	 else    $main_web	= _THEME;
			if(_TITLEBAR) $titlebar = _TITLEBAR; else $titlebar = _THEME;


	$tpl->assign(array(
	'key'=>$key,	
	'LIST_demi'=>$theme_themi,
	'r_theme' => _THEME,

		));



	
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("attach/de_lib.htm"));
	
	 break;
	case "POST":

if(!$mmode) $mmode = "update";
switch ($mmode) {
	case "update":
	

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');

			if($_SESSION[top_menu_ses])  $INI->setVar("top_menu",$_SESSION[top_menu_ses],"attach_main");
			if($_SESSION[copyright_ses]) $INI->setVar("copyright",$_SESSION[copyright_ses],"attach_main");
			if($_SESSION[menu_ses]) $INI->setVar("menu",$_SESSION[menu_ses],"attach_main");
			if($_SESSION[counter_ses]) $INI->setVar("counter",$_SESSION[counter_ses],"attach_main");
			if($_SESSION[poll_ses]) $INI->setVar("poll",$_SESSION[poll_ses],"attach_main");
			if($_SESSION[login_ses]) $INI->setVar("login",$_SESSION[login_ses],"attach_main");
			if($_SESSION[latestgallery_ses]) $INI->setVar("latestgallery",$_SESSION[latestgallery_ses],"attach_main");
			if($_SESSION[latestboard_ses]) $INI->setVar("latestboard",$_SESSION[latestboard_ses],"attach_main");
			if($_SESSION[news_ses]) $INI->setVar("news",$_SESSION[news_ses],"attach_main");
			if($_SESSION[main_web_ses]) $INI->setVar("main_web",$_SESSION[main_web_ses],"attach_main");
			if($_SESSION[titlebar_ses]) $INI->setVar("titlebar",$_SESSION[titlebar_ses],"attach_main");

			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
	
	if(!$back) 	echo "<script type='text/javascript'> parent.document.getElementById('tmp').value = '';   parent.location.reload();</script>";	

	
	 break;



	case "session":
	
			if($top_menu) $_SESSION[top_menu_ses] = $top_menu;
			if($copyright) $_SESSION[copyright_ses] = $copyright;
			if($menu) $_SESSION[menu_ses] = $menu;
			if($counter) $_SESSION[counter_ses] = $counter;
			if($poll) $_SESSION[poll_ses] = $poll;
			if($login) $_SESSION[login_ses] = $login;
			if($latestgallery) $_SESSION[latestgallery_ses] = $latestgallery;
			if($latestboard) $_SESSION[latestboard_ses] = $latestboard;
			if($news) $_SESSION[news_ses] = $news;
			if($main_web) $_SESSION[main_web_ses] = $main_web;
			if($titlebar) $_SESSION[titlebar_ses] = $titlebar;
	
	if(!$back) 	echo "<script type='text/javascript'>  parent.document.getElementById('tmp').value = '';  parent.location.reload();</script>";	

	
	 break;


	case "reset":
	
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			
			//2008-06-28 중요 종태 디자인 라이브러리 배열로 처리
			for($ii=0; $ii<count($module_array); $ii++) {
			 $this_modue = $module_array[$ii];
			 $INI->setVar("$this_modue",_THEME,"attach_main");				
			}

		$INI->setVar("top_menu",_THEME,"attach_main");	
		$INI->setVar("copyright",_THEME,"attach_main");	
		$INI->setVar("menu",_THEME,"attach_main");	
		$INI->setVar("counter",_THEME,"attach_main");	
		$INI->setVar("poll",_THEME,"attach_main");	
		$INI->setVar("login",_THEME,"attach_main");	
		$INI->setVar("latestgallery",_THEME,"attach_main");	
		$INI->setVar("latestboard",_THEME,"attach_main");	
		$INI->setVar("news",_THEME,"attach_main");	
		$INI->setVar("main_web",_THEME,"attach_main");	
		$INI->setVar("titlebar",_THEME,"attach_main");	

			
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

