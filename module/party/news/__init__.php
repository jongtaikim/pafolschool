<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/news/__init__.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
if(!$pcode) {
    if(!$pcode = $_REQUEST['pcode']) WebApp::raiseError('�߸��� ��û�Դϴ�.');
}
$layout = $conf['layout'] ? $conf['layout'] : '@sub';
$skin = $conf['skin'] ? $conf['skin'] : 'blue';
$title = $conf['title'] ? $conf['title'] : '��������';

//2007-10-18 ���� ���Ƹ� ������ �������� ���� �ҽ�
$DB = &WebApp::singleton("DB");


$data_one = $DB -> sqlFetch("select
str_pname,str_img1,str_img2,str_img3,str_memo,str_color1,str_color2,str_color3,str_color4

 from TAB_PARTY where num_oid = $_OID and num_pcode = $pcode ");

if(!$data_one[str_img2]) {

$tpl->assign(array(
'size2'=> "10",
));
}

$sql = "select num_pcode,str_pname from TAB_PARTY where num_oid = $_OID ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('URL_LIST'=>$row));



//���Ƹ� �޴�
if ($pcode) {
    //==-- ���Ƹ� Ȩ������ �޴� --==//
     global $PARTY_CONF;
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT* FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_view=1 order by num_step ";
    $DB->query($sql);
    $data = array();


    while($row = $DB->fetch()) {
        $row['class'] = $class.($mcode == $row['num_mcode'] ? ' '.$class_current : '');
       	$row['str_title'] = Display::text_cut($row['str_title'],22,".."); 
		$data[] = $row;
			
			
    }
 

} 





$tpl->assign(array(
  'SUBMENU2'=>$data,
 
));



if ($_SESSION['ADMIN'] && !$_SESSION['ADMIN_PARTY_'.$pcode]) {
    $admin = "Y";
$tpl->assign(array(
  'admin'=>$admin,
 
));
}

//2007-10-18 ���� ���Ƹ� ������ �������� ���� �ҽ�

?>