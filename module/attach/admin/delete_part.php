<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/attach/admin/delete_part.php
* �ۼ���: 2006-05-08
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$name = $_REQUEST['name'];
$id = substr($name,strrpos($name,'_')+1);
if(!$name || !$id) msgClose('�߸��� ��û�Դϴ�.');

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','part');
$ATT_CONF = Display::AttachConf();
$attach_file = array_pop($ATT_CONF[$name]['file']);

$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$_OID AND str_name='$name'";
$DB->query($sql);
$DB->commit();

$sql = "DELETE FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID AND num_serial='$id'";
$DB->query($sql);
$DB->commit();

$msg = WebApp_Message::fromFile(Display::getTemplate($attach_file));
$FH->delete_as_html($msg->__toString());

$FTP = WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_file);


$attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
$INI = &WebApp::singleton('IniFile',$attach_conf_file);
$INI->delSection($name);
$FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);

echo '<script type="text/javascript">parent.removePart("'.$name.'");alert("�����Ǿ����ϴ�.");self.close();</script>';
?>