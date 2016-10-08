<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
작성자 : 누구게? ( budget74@nate.com )
작성일 : 2004년 09월 22일
용  도 : 리스트에서 일괄 처리
*****************************************************************
* 
*/
if(!$env['admin']) WebApp::moveBack('권한이 없습니다.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);

for( $i=0; $i < count($board_id); $i++ ){
	if(${"del_".$board_id[$i]}){
		board_files_del($board_id[$i]);
	}else{
		$chk_right=true;
		/* 패스 시키기 */
		# 1. 이름, 날짜, 조회수 중 빈칸이 있을때, 조회 수가 숫자가 아닐때
		if( !$chg_name[$i] || !$chg_date[$i] || $chg_hit[$i]=='' || !is_numeric($chg_hit[$i]) )$chk_right=false;

		# 2. 날짜가 조건에 맞지 않을 경우
		if( pass_match_date($chg_date[$i])==false )$chk_right=false;

		if($chk_right==false)continue;

		$DB->query("UPDATE $ARTICLE_TABLE SET str_name='".$chg_name[$i]."', dt_date=to_date('".$chg_date[$i]."','YYYY-MM-DD'), num_hit=".$chg_hit[$i]." WHERE num_oid=".$oid." AND num_mcode=".$code." AND num_serial=".$board_id[$i]);
	}
	
}

function pass_match_date($ins_date) {
	$chk_result=false;
	if( strlen($ins_date)==10 ){
		$chk_result=true;
		$dates=explode('-',$ins_date);
		if(sizeof($dates)!=3)$chk_result=false;
		foreach( $dates as $date ){
			if(!is_numeric($date)){
				$chk_result=false;
				break;
			}
		}
	}
	return $chk_result;
}

function board_files_del($ins){
	global $ARTICLE_TABLE,$DB,$oid,$code,$FH;

	$data=$DB->sqlFetch("SELECT str_text1,str_text2,str_text3,str_thumb FROM $ARTICLE_TABLE  WHERE num_oid=".$oid." AND num_mcode=".$code." and num_serial=".$ins);
	if($data['str_thumb']) $FH->del_thumb($data['str_thumb']);
	$content = $str_text1.$str_text2.$str_text3;
	$FH->delete_as_main($ins);
	$FH->delete_as_html($content);

	$DB->query("DELETE FROM $ARTICLE_TABLE WHERE num_oid=".$oid." AND num_mcode=".$code." and num_serial=".$ins);
	$DB->commit();
}
WebApp::redirect($URL->setVar(array('act'=>'.list','mcode'=>$mcode,'page'=>$_POST['page'])));
?>
