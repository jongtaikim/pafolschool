<script language="JavaScript">
<!--
var ifrContentsTimer;
function resizeRetry() { //이미지같이 로딩시간이 걸리는 것들이 로딩된후 다시 한번 리사이즈
        if(document.body.readyState == "complete") { 
            clearInterval(ifrContentsTimer); 
        }else { 
            resizeFrame(); 
        } 
} 
function resizeFrame(){  //페이지가 로딩되면 바로 리사이즈..
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
* 파일명: module/doc/view.php
* 작성일: 2005-03-31
* 작성자: 거친마루
* 설  명: 웹문서 출력
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

//2008-03-04 종태 메뉴를 디비에서 가져옴..ㅡㅡㅋ
$sql = "select str_title from tab_menu where num_oid = '$_OID' and num_mcode = '$mcode'  ";
$DOC_TITLE = "str:".$DB -> sqlFetchOne($sql);
//echo $DOC_TITLE;




$body = $FH->set_content($MSG->__toString());



echo $body;



?>
</body>