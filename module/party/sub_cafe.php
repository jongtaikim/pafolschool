<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-12-26
* 작성자: 김종태
* 설   명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

//카페목록
if($param[stype] !="class") {
	

if($_SESSION[USERID]) { // 가입한 카페목록

$sql = "select a.num_pcode, b.str_pname from TAB_PARTY_MEMBER a, TAB_PARTY b 
where  

a.num_oid = "._OID." and   
a.num_oid = b.num_oid and
a.num_pcode = b.num_pcode and a.str_id = '".$_SESSION[USERID]."'
and b.str_type = '".$param[stype]."' order by num_pcode asc
";

$row = $DB -> sqlFetchAll($sql);

}
}else{

$sql = "select num_pcode, str_pname from  TAB_PARTY 
where  

num_oid = "._OID." and   
str_type = '".$param[stype]."' order by num_pcode asc
";

$row = $DB -> sqlFetchAll($sql);

}

$tpl->assign(array('cafe_list'=>$row));
$tpl->define("SelectCafe",$param['template']);
$content = $tpl->fetch("SelectCafe");
echo $content ;
?>