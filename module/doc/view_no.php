<script language="JavaScript">
<!--
var ifrContentsTimer;
function resizeRetry() { //�̹������� �ε��ð��� �ɸ��� �͵��� �ε����� �ٽ� �ѹ� ��������
        if(document.body.readyState == "complete") { 
            clearInterval(ifrContentsTimer); 
        }else { 
            resizeFrame(); 
        } 
} 
function resizeFrame(){  //�������� �ε��Ǹ� �ٷ� ��������..
        var h = parseInt(document.body.scrollHeight)+10;
        if(h<600){h=600;}
       self.resizeTo(document.body.scrollWidth + (document.body.offsetWidth-document.body.clientWidth), h); 
} 
//-->
</script>
<link rel="stylesheet" type="text/css" href="/css/admin.css">
<body onload="resizeFrame();ifrContentsTimer = setInterval('resizeRetry()',100);" style="margin-top:0;margin-left:0" bgcolor="#FFFFFF">
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

$DB = &WebApp::singleton("DB");

//2008-03-04 ���� �޴��� ��񿡼� ������..�ѤѤ�
$sql = "select str_title from tab_menu where num_oid = '$_OID' and num_mcode = '$mcode'  ";
$DOC_TITLE = "str:".$DB -> sqlFetchOne($sql);
//echo $DOC_TITLE;




$body = $FH->set_content($MSG->__toString());



echo $body;



?>
</body>