<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2008-06-09
* 작성자: 김종태
* 설  명: 게시판 목록보기
*****************************************************************
*
*/
$tpl = WebApp::singleton('Display');
$DB = WebApp::singleton('DB');

$sql = "
select a.* from (
	select ROWNUM as RNUM, b.* from (
		select str_organ, str_text, str_domain
		from TAB_ORGAN where num_oid > 20260 and num_oid < 20289
		order by num_oid desc
	)b)a
where a.RNUM > 0 and a.RNUM <= 2
";
$data = $DB->sqlFetchAll($sql);

for($a=0 ; $a<sizeof($data) ; $a++){
	$data[$a]['str_text'] = Display::text_cut($data[$a]['str_text'],30,"..");
	$data[$a]['str_domain'] = "http://".$data[$a]['str_domain'];
}

$tpl->assign(array(
'LIST'=>$data
));
 
$template = $param['template'];
$tpl->define('OrganWA_',$template);
$content = $tpl->fetch("OrganWA_");

echo $content;

//<wa:applet module="board.list_wa" code="2110" listnum="5" titlelen="20"></wa:applet>
?>
