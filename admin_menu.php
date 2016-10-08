<?

$menu = array();




$cate1 = 0;

$menu[$cate1]['title'] = "운영관리";
$menu[$cate1]['link'] = "/admin.common";
	
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "홈페이지 기본정보";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.common"; 
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지의 기본정보를 입력합니다."; 
	
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "관리자 암호관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.passwd";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "관리자 암호를 설정합니다.";
	
	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "개인정보보호방침 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지 회원의 개인정보 보호방침을 작성합니다.";

	$cate2 = 3;
	$menu[$cate1]['submenu'][$cate2]['title'] = "홈페이지 이용약관 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra3";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지 회원의 이용약관을 작성합니다.";

	$cate2 = 4;
	$menu[$cate1]['submenu'][$cate2]['title'] = "저작권 보호방침 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra2";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "저작권 보호방침을 작성합니다.";
	$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "게시판 필터링 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.bitext?PageNum=020303";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "각 게시판에 금칙어를 일괄적으로 적용합니다.";
/*
	$cate2 = 6;
	$menu[$cate1]['submenu'][$cate2]['title'] = "첨부파일 사용량";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/manage.admin.organ_view?mode=disk";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "업로드된 파일 현황 확인";
	
	$cate2 = 7;
	$menu[$cate1]['submenu'][$cate2]['title'] = "게시판 사용 현황";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/manage.admin.organ_view?mode=board";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "월별,일별 게시물 업로드 현황 확인";
	
*/	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "방문자 통계";
	$menu[$cate1]['submenu'][$cate2]['link'] = "manage.admin.organ_view?mode=count";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "월별,일별 방문자 현황확인";
	






$cate1 = 1;
$menu[$cate1]['title'] = "기능관리";
$menu[$cate1]['link'] = "/banner.admin.list";
	
	/*$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "메뉴관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.frame";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지의 게시판, 웹페이지등의 메뉴를 구성합니다."; 

	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "메뉴이동 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.move";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지 메뉴 위치를 변경합니다."; 

	/*$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "사이트 바로가기 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.site_add";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "셀랙트 박스 형태의 링크 메뉴입니다."; */
/*
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "배너 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/banner.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "배너를 등록하고 관리합니다."; 

	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "설문조사";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/poll.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "설문조사를 게시합니다."; 

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "매인화면 비주얼관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/vis.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "매인화면 비주얼을 관리합니다."; 
*/
	$cate2=0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "신청폼 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "form.admin.main?admin=y";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "사용자사 일정한 폼에 입력한 데이터를 수집하고 관리합니다."; 

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "팝업관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/popup.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "팝업을 관리합니다.";
	
	/*
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "홈페이지 퀵메뉴 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/qmenu.admin.main";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지의 퀵메뉴(바로가기)를 구성합니다."; 

	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "팝업/배너관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/banner.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "팝업과 배너를 관리합니다.";

	$cate2 = 3;
	$menu[$cate1]['submenu'][$cate2]['title'] = "정보제공기능 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/calendar.admin.list?PageNum=030401";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "다양한 정보 제공형 기능들을 관리 하는 곳입니다.";
	*/

	
	
	/*
	$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "커뮤니티관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/party.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "동아리, 설문조사, 투표 등등";
	*/




$cate1 = 2;
$menu[$cate1]['title'] = "회원관리";
$menu[$cate1]['link'] = "/member.admin.list?noauth=1";




	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "정회원관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list?noauth=1";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "인증이 완료된 회원의 목록을 보여줍니다."; 


/*
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "인증대기회원관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list?noauth=0";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "인증대기 회원들의 목록을 보여줍니다."; 
*/	

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "회원그룹관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.group_list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "기본권한그룹아래 하위분류를 만듭니다."; 


	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "회원 포인트 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.point_list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "회원들의 포인트를 설정합니다."; 


	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "불량회원 차단관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "member.admin.crossuser";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "스팸로봇, 불량회원을 차단합니다."; 
	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "회원가입 경로 리스트";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list_ac";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "회원가입 경로 현황을 확인 및 변경 할 수 있습니다."; 
	

	
	/*$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "정책 및 이용약관";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.info";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "개인정보정책이나 이용약관을 편집합니다.";
*/
global $DB;
$sql = "select num_ccode from TAB_LMS_CATE where str_delete='n' order by num_step asc limit 1 ";
$f_ccode = $DB -> sqlFetchOne($sql);


$cate1 = 3;
$menu[$cate1]['title'] = "추가기능";
$menu[$cate1]['link'] = "/lms.admin.main";
	
	

	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "캠프 프로그램 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.list?ccode=".$f_ccode;
	$menu[$cate1]['submenu'][$cate2]['tip'] = "캠프 프로그램를 관리합니다.";
		
		$cate3 = 0;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "캠프 목록 관리";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.list?ccode=".$f_ccode;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "켐프프로그램 기수를 등록";

		$cate3 = 1;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "캠프 프로그램 관리";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.cate";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "교육의 카테고리를 설정합니다.";

		

	
	
	
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "캠프관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.order_list?all=y";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "캠프 신청현황확인 및 맨토를 관리합니다.";
		
		$cate3 = 0;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "전체보기";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?all=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "켐프 신청 목록";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "켐프신청 관리";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "켐프 신청 목록";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "신청 대기자 관리";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?hold=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "캠프 신청 대기자 목록";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "취소/환불 관리";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?cancel=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "캠프 신청 취소 목록";


		
	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "맨토 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.tach";
	$menu[$cate1]['submenu'][$cate2]['tip'] = " 맨토를 관리합니다.";






	 for($ii=0; $ii<count($menu); $ii++) { 
		$iia = $ii +1;

		if(strstr($menu[$ii]['link'],"?")) {
		$menu[$ii]['pn'] ="&PageNum=0".$iia."0100";	
		}else{
		$menu[$ii]['pn'] ="?PageNum=0".$iia."0100";	
		}
		

		for($i=0; $i<count($menu[$ii]['submenu']); $i++) {
		$ia = $i +1;
			if(strstr($menu[$ii]['submenu'][$i]['link'],"?")) {
			$menu[$ii]['submenu'][$i]['pn'] ="&PageNum=0".$iia."0".$ia."00";	
			}else{
			$menu[$ii]['submenu'][$i]['pn'] ="?PageNum=0".$iia."0".$ia."00";	
			}
			
			for($iii=0; $iii<count($menu[$ii]['submenu'][$i]['submenu_sub']); $iii++) {
				$iaa = $iii +1;
				
				if(strstr($menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['link'],"?")) {
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="&PageNum=0".$iia."0".$ia."0".$iaa;	
				}else{
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="?PageNum=0".$iia."0".$ia."0".$iaa;	
				}
			
			}
			

		}

	 }


?>