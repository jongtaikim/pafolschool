<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/__init__.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
require_once dirname(__FILE__).'/table_define.php';
$URL = &WebApp::singleton('WebAppURL');
$PERM = &WebApp::singleton('Permission');
$PERMCAFE = &WebApp::singleton('PermissionCafe');
$oid = _OID;


if(!function_exists('sublist_format')) {
	function sublist_format(&$arr) {
		global $PERMCAFE, $cafe_mtype;
		$wchk = $PERMCAFE->check('party',$arr['num_pcode'].'.'.$arr['num_mcode'],'w', $cafe_mtype);
		if(!$_SESSION[CAFE_ADMIN] && !$wchk){
			$arr['num_mcode'] = "N";
			$arr['str_title'] = Display::text_cut($arr['str_title'],15,"..");
			$arr['str_title'] .= " (권한없음)";
			
		}else{
			$arr['str_title'] = Display::text_cut($arr['str_title'],22,".."); 
			$arr['chke'] = "y";
		}
	}
}


if(!function_exists('byte_convert')) {
function byte_convert($bytes){
	$symbol = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	$exp = 0;
	$converted_value = 0;
	if( $bytes > 0 ){
		$exp = floor( log($bytes)/log(1024) );
		$converted_value = ( $bytes/pow(1024,floor($exp)) );
	}

	return sprintf( '%.2f'.$symbol[$exp], $converted_value );
	//return sprintf( '%d'.$symbol[$exp], $converted_value );
}
}


if(!function_exists('ImgGetThumb')) {
function ImgGetThumb($content,$id) {
	global $_OID, $FH;
	$sect = $FH->sect;
	$code = $FH->code;

	//게시글중 첫번째이미지 썸네일
	$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $content, $m); 
	$tmp_img_list = $m[1];

	for($ii=0; $ii<count($tmp_img_list); $ii++) {
		if(strstr($tmp_img_list[$ii],"/data/hosts/".$_OID."/board_img/")){
			//첫번째이미지를 썸네일로~
			if(WebApp::saveThumbImg(_DOC_ROOT.$tmp_img_list[$ii],_DOC_ROOT.$tmp_img_list[$ii]."_100",100,100,100, 1, "")){
				return $tmp_img_list[$ii]."_100";
			}
		}else{
			$ftype = array_pop(explode(".",$tmp_img_list[$ii]));
			$tmp_dir = "/data/hosts/".$_OID."/board_thumb/".$sect."/";
			WebApp::Makedir($tmp_dir);
			$tmp_nm = $tmp_dir.$code.".".$id.".".$ftype;
			$tmp_file = _DOC_ROOT.$tmp_nm;

			$ch = curl_init($tmp_img_list[$ii]);
			$fp = fopen($tmp_file, "w");
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			curl_exec($ch);
			curl_close($ch);
			fclose($fp);

			if(WebApp::saveThumbImg($tmp_file,$tmp_file."_100",100,100,100, 1, "")){
				return $tmp_nm."_100";
			}
		}
	}
}
}


if(!function_exists('cut_str')) {
function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
	for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}
}

//게시판종류
if ($pcode) {
	$sql = "select num_pcode, num_mcode, str_title from TAB_PARTY_BOARD_CONFIG where num_oid = $_OID and num_pcode = $pcode and str_skin!='memo' order by num_mcode";
	if($data2 = $DB->sqlFetchAll($sql)) array_walk($data2,'sublist_format'); // 데이터가공
}

$tpl->assign(array('SUBMENU2'=>$data2));




//$mcode = $_REQUEST['mcode'];
//$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
$search = $_REQUEST['search'];




if($mcode){
	$_conf = $DB -> sqlFetch("select * from TAB_PARTY_BOARD_CONFIG where num_oid = $_OID and num_pcode = $pcode and num_mcode = $mcode ");
	$DOC_TITLE = 'str:'.$_conf['str_title'];
	if(!$_conf[str_skin] =="board");
	$tpl->assign($_conf);
	$board_type = $_conf[str_skin];

}else{
	$DOC_TITLE = "str:전체글보기";
	$board_type = "board";
}





//==-- 템플릿 기능버튼 링크 정의 --==//
$modifylink = $URL->setVar('act','.modify');
$replylink = $URL->setVar('act','.reply');
$deletelink = $URL->setVar('act','.delete');
$URL->delVar('id','num');
$writelink = $URL->setVar('act','.write');
$listlink = $URL->setVar('act','.list');


if($_SESSION[CAFE_ADMIN] || $_SESSION[CAFE_ADMIN_sub]) {$admin="Y";
$env['admin'] = true;
}

if($mcode) $env['writable'] = (($_SESSION[CAFE_ADMIN_sub]|| $_SESSION[CAFE_ADMIN]) || $PERMCAFE->check('party',$pcode.'.'.$mcode,'w',$cafe_mtype));
else $env['writable'] = "Y";



$tpl->assign(array(
'admin'=>$admin,
'pcode'=>$pcode,
'mcode'=>$mcode,
'env' => $env,
'modifylink' => "/party.board.modify?pcode=$pcode&mcode=$mcode&id=$id",
'replylink' => "/party.board.reply?pcode=$pcode&mcode=$mcode&id=$id",
'deletelink' => "/party.board.delete?pcode=$pcode&mcode=$mcode&id=$id",
'writelink' => "/party.board.write?pcode=$pcode&mcode=$mcode",
'listlink' => $listlink,
'listnum'=>$_conf['option']['listnum']
));

$tpl->setLayout('p');


//2007-10-28 로그인시 정보 가지고 있기 종태
$tpl->assign(array(
	'NAME' => $_SESSION['NAME'],
	'PASSWD' => $_SESSION['PASSWORD'],
	'EMAIL' => $_SESSION['E_MAIL'],
	));


$board_skin = "A_board";

$tpl->define("BOARD_TOP", '/html/party/board/skin/board_top.htm');

?>
