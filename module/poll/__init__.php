<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/poll/__init__.php
* �ۼ���: 2005-03-24
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 

$TABLE = "TAB_POLL_MAIN";
$INDEX_PK = "PK_TAB_POLL_MAIN";
$INDEX_TERM = "IDX_TAB_POLL_TERM";
$TABLE_CONTENTS = "TAB_POLL_CONTENTS";
$INDEX_CONTENTS_PK = "PK_TAB_POLL_CONTENTS";
$TABLE_IP = "TAB_POLL_IP";
$INDEX_IP_PK = "PK_TAB_POLL_IP";
$TABLE_USER = "TAB_POLL_USER";
$INDEX_USER_PK = "PK_TAB_POLL_USER";
$TABLE_COMMENT = "TAB_POLL_COMMENT";
$INDEX_COMMENT_PK = "PK_TAB_POLL_COMMENT";
*/
$tpl = &WebApp::singleton('Display'); //���ø����� Ŭ����
$PERM = &WebApp::singleton('Permission');


if(!$sect = $_REQUEST['sect']) $sect = $param['sect'];

if($mcode && (substr($mcode,0,1) == $OFFICE_MCODE)) $sect = "office";
if(!$sect) $sect = 'main';

$cache_file = 'hosts/'.HOST.'/inc.'.$sect.'.poll.htm';
$skin = 'default';

$DB = &WebApp::singleton('DB');
$sql = "select str_title from TAB_MENU where num_oid = $_OID and num_mcode = $mcode ";
$title_no = $DB -> sqlFetchOne($sql);

if($title_no) $DOC_TITLE= "str:".$title_no;
elseif($type == 'vote') $DOC_TITLE = 'str:�¶�����ǥ';
else $DOC_TITLE = 'str:��������';
?>