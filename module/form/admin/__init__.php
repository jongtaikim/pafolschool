<?
include_once "module/admin/__init__.php";


$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '$mcode'";
$mtitle = $DB -> sqlFetchOne($sql);
$tpl->assign(array(

		'mcode'=>$mcode,
		'mtitle'=>$mtitle,
		'admin'=>$admin,

		));


if($admin) {
		$tpl->setLayout('no3');
}else{
	$tpl->setLayout('admin');
}
?>