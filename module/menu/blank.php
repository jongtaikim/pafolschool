<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/menu/blank.php
* �ۼ���: 2008-06-25
* �ۼ���: ������
* ��  ��: ��޴� Ŭ���� �����޴��� ����(redirect)
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'];
$cate = $_REQUEST['cate'];
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu_top',$mcode);



//2008-12-16 ���� AND num_view=1 ����
$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate LIKE '".$cate."__'  ORDER BY num_step";
;

if($data = $DB->sqlFetch($sql)) {
	
	if($data['str_type'] == "link"){
		$sql = "select str_url from TAB_CONTENT_URL where num_oid = '$_OID' and num_cate = '".$data[num_cate]."'";
		$urls = $DB -> sqlFetchOne($sql);
		
		  WebApp::redirect($urls);
		

	}else{
	list($module_name,$module_type) = explode('#',$data['str_type']);
    $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data['num_mcode'],'cate'=>$data['num_cate'],'module_type'=>$module_type));
   $link = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
   

    WebApp::redirect($link);
    }

} else {


	$tpl->setLayout();

    $tpl->define('CONTENT',WebApp::getTemplate('blank.htm'));
	$tpl->assign(array('mcode'=>$mcode));
	
}
?>