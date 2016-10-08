<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
�ۼ��� : ������? ( budget74@nate.com )
�ۼ��� : 2004�� 09�� 22��
��  �� : ����Ʈ���� �ϰ� ó��
*****************************************************************
* 
*/
if(!$env['admin']) WebApp::moveBack('������ �����ϴ�.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);

for( $i=0; $i < count($board_id); $i++ ){
	if(${"del_".$board_id[$i]}){
		board_files_del($board_id[$i]);
	}else{
		$chk_right=true;
		/* �н� ��Ű�� */
		# 1. �̸�, ��¥, ��ȸ�� �� ��ĭ�� ������, ��ȸ ���� ���ڰ� �ƴҶ�
		if( !$chg_name[$i] || !$chg_date[$i] || $chg_hit[$i]=='' || !is_numeric($chg_hit[$i]) )$chk_right=false;

		# 2. ��¥�� ���ǿ� ���� ���� ���
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
