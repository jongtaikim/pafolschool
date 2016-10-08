<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/__init__.php
* 날  짜: 2006-05-17
* 작성자: 이범민
* 설  명: 공통 인클루드 파일
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
    $publicArr = array('비공개','공개');
    $methodArr = array('B'=>'게시판','E'=>'이메일');

    //==-- 템플릿 기능버튼 링크 정의 --==//
    $modifylink = $URL->setVar('act','.modify');
    $replylink = $URL->setVar('act','.reply');
    $deletelink = $URL->setVar('act','.delete');

    $URL->delVar('id');
    $writelink = $URL->setVar(array(act=>'.write',num=>''));
    $listlink = $URL->setVar(array(act=>'.list',num=>''));

    //==-- 레이아웃 설정하기 --==//
    $tpl->setLayout('@sub');
    $tpl->assign('modifylink', $modifylink);
    $tpl->assign('replylink', $replylink);
    $tpl->assign('deletelink', $deletelink);
    $tpl->assign('writelink', $writelink);
    $tpl->assign('listlink', $listlink);
}
?>