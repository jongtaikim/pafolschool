<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/doc/view.php
* �ۼ���: 2005-03-31
* �ۼ���: ��ģ����
* ��  ��: ������ ���
*****************************************************************
* 
*/
$PERM = WebApp::singleton('Permission');
$PERM->apply('menu',$mcode,'r');
$mcode = $_REQUEST['mcode'];
$FH = WebApp::singleton('FileHost','menu',$mcode);


$filepath2 = 'hosts/'.$HOST.'/doc/'.$mcode.'.css';


$css_text =  @file_get_contents(_DOC_ROOT."/".$filepath2);


$MSG = WebApp_Message::fromFile(Display::getTemplate('doc/'.$mcode.'.msg'));

$body = $FH->set_content($MSG->__toString());
	


if($_SESSION[ADMIN]) {
	
if (!$body) {
	$body = '<div style="height:200px"><center>������ �����ϴ�.<br><a href=/doc.admin.edit?mcode='.$mcode.'&cate='.$cate.'><img src=/html/doc_board/skin/A_board/image/btn_write.gif /></a></center></div>';
}else{
	$body  = "<div  class='smartOutput'>".$body."</div><center><br><a  href='/doc.admin.edit?mcode=".$mcode."&cate=".$cate."'><br><img src=/html/doc_board/skin/A_board/image/btn_modify.gif /></a></center>";
}

}else{

if (!$body) {
	$body = '<div style="height:200px"><center>������ �����ϴ�.</center></div>';
}else{
	$body  = "<div class='smartOutput'>".$body."</div>";
}
}



if($css_text){
	$body = '<style type="text/css" title="">
			 '.$css_text.'
			</style>
			'.$body;
}

$tpl->setLayout('@sub');
$tpl->assign(array('css_text'=>$css_text));


$tpl->define('#CONTENT',$body);




$tpl->assign(array('mcode'=>$mcode));

// {{{ Functions
// }}}
?>
