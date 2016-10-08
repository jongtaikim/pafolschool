<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
//강좌관리 환경설정
$_LMS = WebApp::getConf('lms');
$tpl->assign($_LMS);

$tpl->assign(array('mcode'=>$mcode));
$tpl->setLayout();

//메뉴로 권한 설정
$PERM = &WebApp::singleton('Permission');
$env['writable'] = (($oid == $_OID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w')));
$env['admin'] = (($oid == $_OID) && $_SESSION['ADMIN']);

//특수 모듈별로 레이아웃환경설정에서 불러온 레이아웃가져오기 2008-09-11종태
$DB = &WebApp::singleton('DB');
$tpl->setLayout();	
if(!$_LMS['skin']) {
$skin = "basic";
}else{
$skin = $_LMS['skin'];
}

$sql = "select str_title from TAB_MENU where num_oid = $_OID and num_mcode = $mcode ";
$title_no = $DB -> sqlFetchOne($sql);
$DOC_TITLE= "str:".$title_no;

//메인에 표기되는 강좌 옵션 - /module/main_lms.php 에도 동일하게있음
$mainv = array("best"=>"N","new"=>"N","opt1"=>"N","opt2"=>"N");

function loginCheck(){ //주문번호 생성
global $REQUEST_URI;
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다.");</script>';
	$_SESSION['reurl'] = $REQUEST_URI;
	echo "<meta http-equiv='Refresh' Content=\"0; URL='member.login'\">";
	exit;
}

}


function loginCheck2(){ //주문번호 생성
global $REQUEST_URI;
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다.");
	opener.location.href="/member.login";
	self.close();
	</script>';
	
	exit;
}

}

function orderNewCode($str_id){ //주문번호 생성
return date("YmdHis")."-".$str_id;
}


function Tel($tel1,$tel2,$tel3){ //전화번호 합
return $tel1."-".$tel2."-".$tel3;
}

function TelExp($tel){ //전화번호 나누기
return $a = explode("-",$tel);
	
}

function mkday($date){
$a = explode("-",$date);
$mkt = mktime(00, 00, 01, $a[1],  $a[2], $a[0]);
return $mkt;
}





function orderNewSerial(){ //주문테이블 
global $_OID;
$DB = &WebApp::singleton('DB');

$sql = "select max(num_serial)+1 from TAB_MEDIA_ORDER where num_oid = $_OID ";
$max_code = $DB -> sqlFetchOne($sql);
if(!$max_code) $max_code = 1;
return $max_code;
}



function memberPoint(){
global $_OID,$_CSS,$DB;
$sql = "select 
   num_point_total 
   
   from TAB_MEMBER where num_oid = "._OID." and str_id  = '".$_SESSION['USERID']."' ";
$my_point = $DB -> sqlFetchOne($sql);

$my_point =  $my_point + 0;
return $my_point;
}



function memberPoint2(){
global $_OID,$_CSS,$DB;
$sql = "select 
   num_sam_money 
   
   from TAB_MEMBER where num_oid = "._OID." and str_id  = '".$_SESSION['USERID']."' ";

$my_point = $DB -> sqlFetchOne($sql);

$my_point =  $my_point + 0;
return $my_point;
}



function memberData($str_id){ //2008-09-11 종태 회원정보가져오기
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select 
STR_NAME, 
STR_ID,
CHR_ZIP, 
STR_ADDR1, 
STR_ADDR2,
STR_NICK,
STR_PHONE,
STR_HANDPHONE,
NUM_SAM_MONEY,
STR_EMAIL,
NUM_JUMIN,
NUM_POINT_TOTAL,
CHR_MTYPE

from TAB_MEMBER where num_oid = $_OID and str_id= '".$str_id."'  ";

$member_data = $DB -> sqlFetch($sql);

$str_phone = explode("-",$member_data[str_phone]);
$member_data[tel1]	= $str_phone[0];
$member_data[tel2]	= $str_phone[1];
$member_data[tel3]	= $str_phone[2];


$str_handphone = explode("-",$member_data[str_handphone]);
$member_data[tel11]	= $str_handphone[0];
$member_data[tel22]	= $str_handphone[1];
$member_data[tel33]	= $str_handphone[2];

if(!$member_data[str_name]) $member_data[str_name] = "테스트";

if(!$member_data[str_addr1]) {
	$member_data[str_addr1] = "";
}

if(!$member_data[str_addr2]) {
	$member_data[str_addr2] = "";
}

if(!$member_data[chr_zip]) {
	$member_data[chr_zip] = "";
}

$tpl->assign($member_data);
return $member_data;

}




function mediaData($ccode){ //2008-09-11 강좌정보가져오기 (1개)
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select 

   a.NUM_OID, 
   a.NUM_CCODE, 
   a.NUM_CHK_MCODE,
   a.STR_TITLE, 
   a.STR_TITLE2, 
   a.STR_TEXT_TOP, 
   a.STR_TEXT_FOOT, 
   a.STR_LAYOUT, 
   a.NUM_VIEW, 
   a.NUM_PRICE, 
   a.STR_ORDER_TYPE, 
   a.STR_ORDER_SALE, 
   a.NUM_MEDIA_TYPE, 
   a.NUM_S_DATE, 
   a.NUM_E_DATE, 
   a.STR_ORDER_OFFLINE, 
   a.STR_ORDER_DAY, 
   a.STR_ORDER_URL, 
   a.STR_TACH_CODE, 
   a.STR_BOOK_CODE, 
   a.STR_OFF_TIME,
   a.STR_MSG,
   a.STR_OPTION1, 
   a.NUM_OPTION1_PRICE, 
   a.STR_OPTION2, 
   a.NUM_OPTION2_PRICE, 
   a.STR_OPTION3, 
   a.NUM_OPTION3_PRICE,

   a.NUM_OPTION1_DAY,
   a.NUM_OPTION2_DAY,
   a.NUM_OPTION3_DAY,

   a.NUM_OPTION1_PLUS,
   a.NUM_OPTION2_PLUS,
   a.NUM_OPTION3_PLUS,
   

   
	b.STR_NAME as STR_TACH_NAME ,
	b.STR_TACH_TYPE,
	b.STR_MEMO

 
 from 
 TAB_MEDIA_CONFIG a, TAB_TACH b
 
 where 
 a.num_oid = $_OID and 
 a.num_oid = b.num_oid and 
 a.num_ccode = ".$ccode." and
 a.str_tach_code = b.str_tach_code
 
 ";
$row = $DB -> sqlFetch($sql);

return $row;

}


function bookData($str_book_code){ //2008-09-11 강좌정보가져오기 (1개)
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select 

  
   
  STR_NAME as book_name, 
  STR_PRI_NAME, 
  NUM_PRICE as BOOK_PRICE, 
  STR_MEMO as book_memo

 
 from 
 TAB_BOOK
 
 where 
 num_oid = $_OID and 
 str_book_code = $str_book_code
 ";

$row = $DB -> sqlFetch($sql);

return $row;

}


function bookDataOne($str_book_code ,$cum){ //2008-09-11 강좌정보가져오기 (1개)
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select 

  
   
$cum

 
 from 
 TAB_BOOK
 
 where 
 num_oid = $_OID and 
 str_book_code = $str_book_code
 ";

$row = $DB -> sqlFetchOne($sql);

return $row;

}

function tachData($str_tach_code,$cum){ //2008-09-11 강좌정보가져오기 (1개)
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select 

   
$cum
 
 from 
 TAB_TACH
 
 where 
 num_oid = $_OID and 
 str_tach_code = $str_tach_code
 ";


$row = $DB -> sqlFetchOne($sql);

return $row;

}


function mediaCount($ccode){ //2008-09-11 강좌정보가져오기 (1개)
global $_OID,$_CSS;
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

$sql = "select  count(*)
from TAB_MEDIA where num_oid = $_OID and num_ccode = ".$ccode." ";

$total_media = $DB -> sqlFetchOne($sql);

return $total_media;

}


function mediaDayChk($num_order_number){ // 주문번호로 찾기
global $_OID;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$_SESSION['USERID']."' and
 num_order_number = '".$num_order_number."' order by dt_start_day desc NULLS LAST


";
$data = $DB -> sqlFetch($sql);

$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 
$tpl->assign(array(
	'media_end_day'=>$mk2,
//	'media_end_count'=> round($mk3),
	'media_end_count'=> ceil($mk3)
	));



if($mk2 < $mk ) {
WebApp::moveBack('강의실에 입장할 수 없습니다.\n수강기간이 끝난 강좌이거나 결제확인중인 강좌입니다.');
exit;
}


}



function mediaDayChk2($ccode){ // 강좌코드로 찾기
global $_OID;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$_SESSION['USERID']."' and
 num_ccode = ".$ccode." order by dt_start_day desc NULLS LAST


";
$data = $DB -> sqlFetch($sql);

$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 
$tpl->assign(array(
	'media_end_day'=>$mk2,
	'media_end_count'=> round($mk3),
	));



if($mk2 < $mk ) {
WebApp::moveBack('강의실에 입장할 수 없습니다.\n수강기간이 끝난 강좌이거나 결제확인중인 강좌입니다.');
exit;
}


}



function mediaDayChk3($ccode){ // 강좌코드로 찾기
global $_OID;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다.");
			opener.location.href="/member.login"
			self.close();
			</script>';
			exit;
}
$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$_SESSION['USERID']."' and
 num_ccode = ".$ccode." order by dt_start_day desc NULLS LAST


";
$data = $DB -> sqlFetch($sql);

$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 
$tpl->assign(array(
	'media_end_day'=>$mk2,
	'media_end_count'=> round($mk3),
	));



if($mk2 < $mk ) {
echo '<script>alert("강의실에 입장할 수 없습니다.\n수강기간이 끝난 강좌이거나 결제확인중인 강좌입니다.");
self.close();
</script>';


exit;
}


}







function mediaDayChk4($ccode){ // 강좌코드로 찾기
global $_OID;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$_SESSION['USERID']."' and
 num_ccode = ".$ccode." order by dt_start_day desc NULLS LAST


";
$data = $DB -> sqlFetch($sql);

$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 



if($mk2 < $mk ) {
$rrvalue = "N";
}else{
$rrvalue = "Y";
}

return $rrvalue;
}




function mediaDayChkRow($num_order_number){
global $_OID;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$_SESSION['USERID']."' and
 num_order_number = '".$num_order_number."' 


";
$data = $DB -> sqlFetch($sql);


$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 

if($mk2 < $mk ) {
//$aa = array('end_count' => round($mk3),'end_' => 'Y');
	$aa = array('end_count' => ceil($mk3), 'end_' => 'Y', 'now_time' => $mk, 'end_time' => $mk2);
}else{
//$aa = array('end_count' => round($mk3),'end_' => 'N');
	$aa = array('end_count' => ceil($mk3), 'end_' => 'N', 'now_time' => $mk, 'end_time' => $mk2);
}
return $aa;
}	


function mediaDayChkRow2($num_order_number){
global $_OID,$str_id;
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

$sql = "select 

num_view_end,
dt_start_day 

from TAB_MEDIA_ORDER 
where 
num_oid = $_OID and 
str_id = '".$str_id."' and
 num_order_number = '".$num_order_number."'


";
$data = $DB -> sqlFetch($sql);


$mk = mktime();
$mk2 = $data['dt_start_day'] + (($data['num_view_end'] * 86400) +86400 ); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;
 


if($mk2 < $mk ) {
$aa = array('end_count' => round($mk3),'end_' => 'Y');

}else{
$aa = array('end_count' => round($mk3),'end_' => 'N');
}
return $aa;
}	



function retimeMediaList($ccode,$str_option,$num_option_number){
global $_OID,$str_id,$DB;
$sql = "select 

   *
 
 from TAB_MEDIA_ORDER 
 where 
 num_oid = $_OID and
 str_id = '".$_SESSION[USERID]."' and
 num_ccode = ".$ccode." and
 num_option_number = '".$num_option_number."' 
 
 ";


$data = $DB -> sqlFetchAll($sql);
$mk = mktime();
for($ii=0; $ii<count($data); $ii++) {

$mk2 = $data[$ii]['dt_start_day'] + (($data[$ii]['num_view_end'] * 86400) +86400 ); //하루더 여유를 준다
$mk3 = ($mk2  - $mk) / 86400;

if($mk3 > 0) {
$r_bale = $data[$ii]['num_order_number'];
}	
}

return $r_bale;




}







function inPgLog($num_order_number,$str_order_title,$str_st,$str_card_name,$dt_in_date,$str_in_card_number,$str_name){
global $DB, $_OID;

$sql = "select MAX(num_serial) + 1 from TAB_PG_LOG where num_oid = $_OID ";
$num_serial = $DB -> sqlFetchOne($sql);
if(!$num_serial) $num_serial = 1;
			
$dt_date = date("Y-m-dHis",mktime());

$sql = "INSERT INTO TAB_PG_LOG (
num_oid, num_order_number, num_serial, str_id, str_st, dt_date,str_order_title,str_card_name,dt_in_date,str_in_card_number,str_name
) VALUES (
'$_OID', '$num_order_number', '$num_serial', '".$_SESSION[USERID]."', '$str_st', '$dt_date','$str_order_title','$str_card_name','$dt_in_date','$str_in_card_number','$str_name') ";



$DB->query($sql);
$DB->commit();
			

}




















//////////////////////////////////////////////////////////////////////////////////////////////

$my_point = memberPoint();
$sam_point = memberPoint2();

$tpl->assign(array(

'my_point'=>$my_point,
'sam_point'=>$sam_point,
	));
$member_data = memberData($_SESSION[USERID]);


///////////////////////////////////////바이오리듬/////////////////////////////////////

$birthdate = $member_data[num_jumin];
$birthdate = explode("-",$birthdate);
if(substr($birthdate[0],0,2) < 70) {
$birthdate = "20".substr($birthdate[0],0,2)."-".substr($birthdate[0],2,2)."-".substr($birthdate[0],4,2);	
}else{
$birthdate = "19".substr($birthdate[0],0,2)."-".substr($birthdate[0],2,2)."-".substr($birthdate[0],4,2);
}


$m =date("d",mktime());


function Rhythm($daysAlive, $period) 
{
	$centerDay = $daysAlive - (30 / 2);

	$plotScale = (100 - 25) / 2;
	$plotCenter = (100 - 25) / 2;
//	for ($x = 0; $x <= 30; $x++) {
	$x = 15;
		$phase = (($centerDay + $x) % $period) / $period * 2 * pi() + pi();
     	$y = sin($phase) * (float)$plotScale + (float)$plotCenter;
		if ($x == 15) return (int)(($y-$plotScale)/$plotScale*100*-1);
//	}
}
function bio_gap() {
	global $birthMonth, $birthDay, $birthYear, $gap, $m, $y_g, $m_g, $d_g;
	// 현재 까지의 일자(날수)
	
	$y_g = date('Y');
	$m_g = date('m');
	$d_g = date("d");

	if (!$m) {
		$daysGone =$birthMonth."-".$birthDay."-".$birthYear - date("Y-m-d");
	} else {
		if ($m > 0) {
			for ($i = 1; $i <= $m; $i++) {
				$m_g += 1;
				if ($m_g > 12) { $y_g++; $m_g = 1; }
			}
		} else {
			for ($i = -1; $i >= $m; $i--) {
				$m_g -= 1;
				if ($m_g < 1) { $y_g--; $m_g = 12; }
			}
		}
		$daysGone =date("m");
	}
//	echo "M::".$m."현재날자:".$y_g."-".$m_g."-".$d_g;
	$gap[0] = Rhythm($daysGone, 23);	// 신체리듬
	$gap[1] = Rhythm($daysGone, 28);	// 감성리듬
	$gap[2] = Rhythm($daysGone, 33);	// 지성리듬
	$gap[3] = Rhythm($daysGone, 38);	// 지각리듬
}



// include('solar_lunar.inc'); 
// include ('bio_class.inc'); 
//	$b = new SunLunarKor(1974,01,14);
//	$b->sun_to_lunar();

	
	$y_g = 0;
	$m_g = 0;
	$d_g = 0;
	$gap[0] = 0;
	$gap[1] = 0;
	$gap[2] = 0;
	$gap[3] = 0;
	

	
	
	$now	= date('Y-m-d');
	
	if (! $birthdate) {
		$birthdate = $now;
	} else {
		//setcookie("birthdate", $birthdate, time() + 365 * 86400);
	}
	if (!m) {
		$m = 0;
	}
	$birthYear = subStr($birthdate, 0, 4);
	$birthMonth = subStr($birthdate, 5, 2);
	$birthDay = subStr($birthdate, 8, 2);
	if (!checkDate($birthMonth, $birthDay, $birthYear)) {
	 //  echo  "생일: '$birthYear-$birthMonth-$birthMonth'이(가) 정확하지 않습니다.";
	   
	}
	bio_gap();
    $m_g = sprintf("%02d", $m_g);
//	if ($year)	echo solar_to_lunar($birthYear, $birthMonth, $birthDay);


$tpl->assign(array(
	'ra1'=>$gap[0],
	'ra_text1'=>$gap[0],
	
	'ra2'=>$gap[1],
	'ra_text2'=>$gap[1],

	'ra3'=>$gap[2],
	'ra_text3'=>$gap[2],

	'ra4'=>$gap[3],
	'ra_text4'=>$gap[3],

	));






  //2008-11-21 종태 관리자에서 입력한 키값세팅
  $at_cross_key = $_LMS[at_cross_key];
  $at_shop_id = $_LMS[at_shop_id];







$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from tab_media_order where num_oid = '20252' and dt_start_day + (num_view_end * 86400) > ".mktime()." and num_ccode in ('3','4','6') order by str_id";
	$row = $DB -> sqlFetchAll($sql);
	
	for($ii=0; $ii<count($row); $ii++) {

	switch ($row[$ii][num_ccode]) {
	case "3":
	$row[$ii][title] = "부자되기";
	$row[$ii][occode] = "28";
	 break;
	case "4":
	$row[$ii][title] = "고수되기";
	$row[$ii][occode] = "28";
	 break;
 	case "6":
	if($row[$ii][num_option_number] == 1) {
		$row[$ii][title] = "증권대학 기본편";
		$row[$ii][occode] = "29";
	}
	
	if($row[$ii][num_option_number] == 2) {
		$row[$ii][title] = "증권대학 실전편";
		$row[$ii][occode] = "30";
	}
	if($row[$ii][num_option_number] == 3) {
		$row[$ii][title] = "증권대학 종합편";
		$row[$ii][occode] = "28";
	}
	 break;

	}

	}
   $tpl->assign(array('LIST'=>$row));
	


	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("sink.htm"));
	
	 break;
	case "POST":


		$DB = &WebApp::singleton('DB');

		$member_data = memberData($str_id); //회원정보
		$str_phone = $member_data[str_phone];
		$str_handphone = $member_data[str_handphone];


		$num_ccode = $occode;


		$row = mediaData($num_ccode);//강좌 정보가져오기 
		$num_mcode = $row[num_chk_mcode];
		$num_serial = orderNewSerial(); //새로운 시리얼
		$col_str_option = "str_option1";

		$num_order_number =orderNewCode($str_id); //주문번호

		$num_media_type = "0";

		//$num_view_end = $row[num_option1_day]*30; //수강기간 개월을 일로 변경


		$dt_start_day = mktime();
		
		$sql = "INSERT INTO ".TAB_MEDIA_ORDER." (

		NUM_OID, 
		num_order_number, 
		NUM_SERIAL, 
		NUM_CCODE, 
		STR_ID, 
		DT_DATE, 
		NUM_ST, 
		CHR_ZIP, 
		STR_ADDR1, 
		STR_ADDR2, 
		NUM_BANK_NUMBER, 
		STR_BANK_NAME, 
		DT_BANK_DAY, 


		STR_PHONE, 
		STR_HANDPHONE, 
		STR_MEMO, 
		NUM_ORDER_PRICE, 
		NUM_ORDER_SALE, 
		NUM_ORDER_TYPE,
		STR_BOOK_CODE, 
		STR_TACH_CODE,
		NUM_BOOK_PRICE,
		STR_OPTION,
		NUM_VIEW_END,
		DT_START_DAY,
		STR_PG_RETURN,
		NUM_POINT_USE,
		NUM_MCODE,
		STR_NAME,
		NUM_MEDIA_TYPE,
		NUM_OPTION_NUMBER,

		str_text,
		STR_ORDER_TYPE,
		STR_GU_TYPE

		) VALUES (
							
		'$_OID', 
		'$num_order_number', 
		'$num_serial', 
		'$num_ccode', 
		'$str_id', 
		'".mktime()."', 
		'1', 
		'$chr_zip', 
		'$str_addr1', 
		'$str_addr2', 
		'$num_bank_number', 
		'$str_bank_name', 
		'".mktime()."', 

		'$str_phone', 
		'$str_handphone', 
		'$str_memo', 
		'$num_order_price', 
		'$num_order_sale', 
		'1',

		'$str_book_code', 
		'$str_tach_code',
		'$num_book_price',
		'".$row[$col_str_option]."',
		'$num_view_end',
		'$dt_start_day',
		'$PG_text',
		'$point_use',
		'$num_mcode',
		'".$member_data[str_name]."',
		'$num_media_type',
		'$num_option_number',

		'이전 고수,부자,온라인증권대학 사용자 결제 이관건',
		'media',
		't'

		) ";


		 if($DB->query($sql)){
			 $DB->commit();

		 $sql = "UPDATE ".TAB_MEDIA_ORDER." SET str_gu_type=  'y'  WHERE num_oid=$_OID and num_order_number = '".$num_order_number_."' and num_serial = '".$num_serial_."' ";
		 $DB->query($sql);
		 $DB->commit();


		$sql = "Insert into TAB_PAYMENT
				   (NUM_OID, NUM_ORDER_NUMBER, STR_ID, STR_NAME, NUM_ORDER_PRICE, NUM_ORDER_TAK_PRICE, NUM_DATE)
					 Values
				   ("._OID.", '".$num_order_number."', '".$str_id."', '".$member_data[str_name]."', 0, 0, ".mktime().")";
		
					$DB->query($sql);
					$DB->commit();
					
		
		
		 $DB->query($sql);
		 $DB->commit();

		WebApp::moveBack('적용되었습니다.');
		
		 }else{
		 echo $sql;
		 }
	 break;
	}

?>