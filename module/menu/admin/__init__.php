<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __init__.php
* 작성일: 2008-12-04
* 작성자: 김종태
* 설  명: 메뉴관리
*****************************************************************
* 
*/
include_once "module/admin/__init__.php";


/*	if(strlen($parent) % 2 == 0) { //2008-01-02 종태 2자리 일때 제한	

		$VAR_MENUTYPE = array(
		
		'menu' => _('Blank Menu'),
		'board#B' => _('Bulletin Board'),

		'doc_board' => _('HTML Document'),

		'link' => _('URL Link'),
		'lms' => _('동영상강좌형(카테고리)'),
		'qna_board' => _('QNA형'),
		);
		
		}else{
		
*/

		if($_OID == _AOID) {
		$VAR_MENUTYPE = array(
		'menu' => _('빈메뉴'),
		'board#B' => _('게시판'),
		'tong_board#B' => _('공유게시판'),

		'doc' => _('HTML Document'),


		'link' => _('URL Link'),
		
		'member#L' => _('로그인'),
		'member#F' => _('ID찾기'),
		'member#J' => _('회원가입'),
		'member#M' => _('회원정보수정'),
		'member#D' => _('회원탈퇴'),

		'qna_board' => _('QNA형'),
		'mov_board' => _('UCC형'),
		'form' => _('입력폼페이지'),
		'ifr' => _('아이프래임'),
		'poll' => _('설문조사'),
		'board#A' => _('게시물전체보기(하위)'),
		'sitemap' => _('사이트맵'),
		'member#A' => _('개인정보보호정책'),
		'member#B' => _('사이트이용약관'),
		'pay#A' => _('장바구니리스트'),
		);
		}else{
		$VAR_MENUTYPE = array(
		'menu' => _('빈메뉴'),
		'board#B' => _('Bulletin Board'),

		'doc' => _('웹문서'),

		'link' => _('URL Link'),
		'ifr' => _('아이프래임'),
		'text_db' => "용어사전",

		);
		}




//2008-11-25 종태 인트라넷일 경우 처리

if(_AOID == $_OID ) {

	$VAR_MENUTYPE2 = array(
			'manage#A' => _('호스트 현황'),
			'manage#C' => _('호스트생성'),
			'manage#O' => _('프로젝트관리'),
			'sitemap' => _('사이트맵'),
			'member#L' => _('로그인'),
			'member#F' => _('ID찾기'),
			'member#J' => _('회원가입'),
			'member#M' => _('회원정보수정'),
			'member#D' => _('회원탈퇴'),
			'member#A' => _('개인정보보호정책'),
			'member#B' => _('사이트이용약관'),

		);
}else{
	$VAR_MENUTYPE2 = array(
	
		);
}

	
//}


function deleteCacheFiles($mcode) {
    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
    if(strlen($mcode) % 2) {
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/smenu.htm');
    } else {
        $_mcode = substr($mcode,0,2);
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$_mcode.'.htm');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$mcode.'.htm');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu2.xml');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');
 		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');
    }
}


include _DOC_ROOT.'/module/media.php';

?>