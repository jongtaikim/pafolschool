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

$MSG = WebApp_Message::fromFile(Display::getTemplate('doc/'.$mcode.'.msg'));
$GLOBALS['DOC_TITLE'] = $MSG->header['Title-Decorator'].':'.$MSG->header['Title'];
$body = $FH->set_content($MSG->__toString());
if (!$body) $body = '<center>������ �����ϴ�. ������ �Է����ּ���</center>';

$tpl->setLayout('@admin');
$tpl->define('#CONTENT',$body);

if($GLOBALS[REMOTE_ADDR]=="125.7.183.1211"){

$tpl->tpl_[COPYRIGHT]="hosts/bukchang.iknock.co.kr//copyright.htm";




  $tmp = get_defined_vars();
  echo "<xmp>";
 // print_R($tpl);
 echo "</xmp>";
// exit;
}

// {{{ Functions
// }}}
?>
