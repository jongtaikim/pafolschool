<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-26
* 작성자: 김종태
* 설   명: 디스트 사용량 뽑기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$color = "AFD8F8,F6BD0F,8BBA00,FF8E46,FF8E46,008E8E,8E468E,588526,B3AA00,008ED6,9D080D,A186BE";
$color = explode(",",$color);

$mtypes =	 array(
		'n' => '비회원',
		'a'=>'졸업생',
		'g' => '일반',
		's' => '학생',
		'p' => '학부모',
		't' => '교직원',
		'z' => '최고관리자' );

	//회원수
	$sql = "select chr_mtype, count(*) mtype_cnt from TAB_MEMBER  group by chr_mtype";
	$row = $DB -> sqlFetchAll($sql);
	for($a=0 ; $a<sizeof($row) ; $a++){
		$chr_mtype = $row[$a]['chr_mtype'];
		$data['tot_user'] += $row[$a]['mtype_cnt'];
		if($mtypes[$chr_mtype]) $row[$a]['mtype'] = $mtypes[$chr_mtype];
		else $row[$a]['mtype'] = "등급없음";
	$row[$a][color] = $color[$a];
	}

echo '<?xml version="1.0" encoding="euc-kr"?>';

	$tpl->assign(array('LIST'=>$row));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("manage/use_member.htm"));
	$content = $tpl->fetch('CONTENT');
	
	
	

?>