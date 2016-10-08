<?
$menu = array();

$menu[0]['title'] = "레이아웃관리";
$menu[0]['link'] = "/attach.admin.manage";
	
	$menu[0]['submenu'][0]['title'] = "메인화면";
	$menu[0]['submenu'][0]['link'] = "/attach.admin.manage?layout=main";

	$menu[0]['submenu'][1]['title'] = "1번서브";
	$menu[0]['submenu'][1]['link'] = "/attach.admin.manage?layout=sub";

	$menu[0]['submenu'][2]['title'] = "2번서브";
	$menu[0]['submenu'][2]['link'] = "/attach.admin.manage?layout=sub2";

	$menu[0]['submenu'][3]['title'] = "3번서브";
	$menu[0]['submenu'][3]['link'] = "/attach.admin.manage?layout=sub3";

	$menu[0]['submenu'][4]['title'] = "4번서브";
	$menu[0]['submenu'][4]['link'] = "/attach.admin.manage?layout=sub4";

	$menu[0]['submenu'][5]['title'] = "5번서브";
	$menu[0]['submenu'][5]['link'] = "/attach.admin.manage?layout=sub5";



$menu[1]['title'] = "디자인관리";
$menu[1]['link'] = "/?remocon=Y";

	$menu[1]['submenu'][0]['title'] = "디자인 리모컨";
	$menu[1]['submenu'][0]['link'] = "/?remocon=Y";
	
	$menu[1]['submenu'][1]['title'] = "팝업관리";
	$menu[1]['submenu'][1]['link'] = "/";


$menu[2]['title'] = "메뉴관리";
$menu[2]['link'] = "/menu.admin.frame";

	$menu[2]['submenu'][0]['title'] = "메뉴관리";
	$menu[2]['submenu'][0]['link'] = "/menu.admin.frame";

	$menu[2]['submenu'][1]['title'] = "게시판리스트";
	$menu[2]['submenu'][1]['link'] = "#";

	$menu[2]['submenu'][2]['title'] = "웹문서리스트";
	$menu[2]['submenu'][2]['link'] = "#";

	$menu[2]['submenu'][3]['title'] = "링크메뉴 리스트";
	$menu[2]['submenu'][3]['link'] = "#";

	$menu[2]['submenu'][4]['title'] = "동영상 강좌리스트";
	$menu[2]['submenu'][4]['link'] = "#";




$menu[3]['title'] = "회원관리";
$menu[3]['link'] = "/member.admin.list";

	$menu[3]['submenu'][0]['title'] = "전체회원목록";
	$menu[3]['submenu'][0]['link'] = "/member.admin.list";

	$menu[3]['submenu'][1]['title'] = "인증회원목록";
	$menu[3]['submenu'][1]['link'] = "/member.admin.list?noauth=1";

	$menu[3]['submenu'][2]['title'] = "미인증회원목록";
	$menu[3]['submenu'][2]['link'] = "/member.admin.list?noauth=0";



$menu[4]['title'] = "환경설정";
$menu[4]['link'] = "/admin.common";

	$menu[4]['submenu'][0]['title'] = "환경설정";
	$menu[4]['submenu'][0]['link'] = "/admin.common";

	$menu[4]['submenu'][1]['title'] = "공지사항 설정";
	$menu[4]['submenu'][1]['link'] = "/news.admin.list?code=com";

	$menu[4]['submenu'][2]['title'] = "설문조사";
	$menu[4]['submenu'][2]['link'] = "/poll.admin.list";
r
?>