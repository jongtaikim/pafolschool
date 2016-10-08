<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/__init__.php
* 작성일: 2006-05-16
* 작성자: 김종태
* 설  명:  카페 메인 설정
*****************************************************************
* 
*/

$tpl = &WebApp::singleton('Display');
$DB = &WebApp::singleton("DB");

global $cafe_data,$pcode;

include _DOC_ROOT.'/module/party/office_carte.php';


//카페 DB환경설정
$sql = "select 

   num_pcode, num_step, 
   str_pname,  str_memo,
   str_id, str_skin, 
   str_main_html1, 
   str_main_html2, str_main_html3, str_join_msg, 
   str_text1, str_text2, str_text3, 
   str_text4, str_text5, str_mtype, 
   cafe_memo, cafe_title, str_date, 
   num_user, num_board, num_ccode, 
   num_update, str_type,str_layout
 
 from TAB_PARTY where num_oid = "._OID." and num_pcode = $pcode ";
$cafe_data = $DB -> sqlFetch($sql);


$sql = "select count(*) from TAB_PARTY_MEMBER where num_oid = "._OID." and num_pcode = ".$pcode."";
$member_count = $DB -> sqlFetchOne($sql);
$cafe_data[num_user] =$member_count + 0;


$board_skin = $cafe_data[str_skin];


if($cafe_data[str_type] =="class") {
$tpl->assign(array('cname'=>"학급홈페이지"));
if(!$cafe_data[str_layout]) $cafe_data[str_layout] = "ct01";


}else if($cafe_data[str_type] =="office"){
$tpl->assign(array('cname'=>"인터넷교무실"));
if(!$cafe_data[str_layout]) $cafe_data[str_layout] = "tt01";

}else{
$tpl->assign(array('cname'=>"동아리"));
if(!$cafe_data[str_layout]) $cafe_data[str_layout] = "gt01";

}

$cafe_data[str_skin] = $board_skin;

if(!$cafe_data[str_type]) {
$cafe_data[str_type] = "cafe"	;
}

define('_CAFETYPE',$cafe_data[str_type]);


$cafe_data[str_main_html1] = WebApp::set_content($cafe_data[str_main_html1]);


//카페멤버등급
$_cafe_mtypes = WebApp::get('party.member',array('key'=>'member_types'));
$tpl->assign("CMTYPES", $_cafe_mtypes);

//카페등록회원수
$tpl->assign(array('cafe_num_user'=>$cafe_data[num_user]));

//카페총 글수
$tpl->assign(array('cafe_num_board'=>$cafe_data[num_board]));

//카페 메니저 회원정보
$sql = "select str_id as cm_id,str_name as cm_name,str_nick as cm_nick from TAB_MEMBER where num_oid = "._OID." and str_id = '".$cafe_data[str_id]."' ";



$cafe_admin_data = $DB -> sqlFetch($sql);
$tpl->assign($cafe_admin_data);





//카페회원권한
$sql = "select str_mtype, num_board, num_comment, num_login,str_id as cafe_member_id from TAB_PARTY_MEMBER where num_oid = "._OID." and num_pcode = '$pcode' and str_id='".$_SESSION[USERID]."'";
$cafe_member_data = $DB -> sqlFetch($sql);
$cafe_mtype = $cafe_member_data['str_mtype'];
$tpl->assign(array('cafe_mtype'=>$cafe_mtype));
$tpl->assign(array('cafe_mtype_name'=>$_cafe_mtypes[$cafe_mtype]));
$tpl->assign($cafe_member_data);

if($cafe_mtype =="b") {
	$_SESSION[CAFE_ADMIN_sub] = true;	
}else{
	unset($_SESSION[CAFE_ADMIN_sub]);
}

//2008-12-24 카페 관리자 권한
if(($cafe_data[str_id] == $_SESSION[USERID] && $_SESSION[USERID]) || $_SESSION[ADMIN]) {
	$_SESSION[CAFE_ADMIN] = true;
}else{
	unset($_SESSION[CAFE_ADMIN]);
}


	if($_SESSION[CAFE_ADMIN] || $_SESSION[CAFE_ADMIN_sub]){

		//2008-12-23 디자인툴에 있는 배경파일 열기
		$dir1= _ROOT."/background/";	
		$num = 0;
		$d1 = opendir($dir1);
		while($file = readdir($d1)) {
		  if(is_dir($file)) continue;
		if(strstr($file,".")) {
		if($file !="." ||$file !=".."  ) $bg[$num]['name'] =$file;	
		}
		$num++;
		}
		closedir($dir1);



		$dir1= _ROOT."/background/"._OID."/p"._PCODE."/";	

		$num = 0;
		$d1 = opendir($dir1);
		while($file = readdir($d1)) {
		  if(is_dir($file)) continue;
		if(strstr($file,".")) {
		if($file !="." ||$file !=".."  ) $bg2[$num]['name'] =$file;	
		}
		$num++;
		}
		closedir($dir1);

		$tpl->assign(array('bgselect'=>$bg,'bgselect_up'=>$bg2));





		//2008-12-23 종태 임시 디자인 css
		if($reset=="Y") {
		setcookie("cafe_css","",1); 

		}
	}
//unset($cafe_css);



if($act){

	if($skin_name) {
		
		$cafe_data[str_layout] = $skin_name;
		$tpl->assign($cafe_data);

	}

}


if(!$pcode) $pcode = _PCODE;
if(!$mcode) $mcode = _MCODE;
$tpl->assign(array('pcode'=>$pcode,'mcode'=>$mcode));

$tpl->assign($cafe_data);		
?>