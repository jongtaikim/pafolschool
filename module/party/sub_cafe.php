<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-12-26
* �ۼ���: ������
* ��   ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');

//ī����
if($param[stype] !="class") {
	

if($_SESSION[USERID]) { // ������ ī����

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