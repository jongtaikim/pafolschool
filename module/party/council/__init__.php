<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/__init__.php
* ��  ¥: 2006-05-17
* �ۼ���: �̹���
* ��  ��: ���� ��Ŭ��� ����
***********************************************/
if($mcode = $_REQUEST['mcode']) {
    $PERM = WebApp::singleton('Permission');

    $id = $_REQUEST['id'];
    $search_key = $_REQUEST['search_key'];
    $search_value = $_REQUEST['search_value'];

    $env = $PARTY_CONF[$mcode];

    $skin = $env['skin'];
    if (!$skin) $skin = 'default';
    $DOC_TITLE = 'str:'.$env['title'];
    $env['admin'] = ($_SESSION['ADMIN'] || $_SESSION['ADMIN_PARTY_'.$pcode]);
    $env['writable'] = ($env['admin'] || $PERM->check('party',$pcode.'.'.$mcode,'w'));
    @extract($env['phpvars']);
    $publicArr = array('�����','����');
    $methodArr = array('B'=>'�Խ���','E'=>'�̸���');

    //==-- ���ø� ��ɹ�ư ��ũ ���� --==//
    $modifylink = $URL->setVar('act','.modify');
    $replylink = $URL->setVar('act','.reply');
    $deletelink = $URL->setVar('act','.delete');

    $URL->delVar('id');
    $writelink = $URL->setVar(array(act=>'.write',num=>''));
    $listlink = $URL->setVar(array(act=>'.list',num=>''));

    //==-- ���̾ƿ� �����ϱ� --==//
    $tpl->setLayout('@sub');
    $tpl->assign('modifylink', $modifylink);
    $tpl->assign('replylink', $replylink);
    $tpl->assign('deletelink', $deletelink);
    $tpl->assign('writelink', $writelink);
    $tpl->assign('listlink', $listlink);
}
?>