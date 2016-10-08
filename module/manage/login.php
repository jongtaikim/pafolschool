<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/login.php
* 작성일: 2006-06-01
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
        $tpl->setLayout('admin');
        $tpl->define('CONTENT','module/manage/login.htm');
	break;
	case "POST":
		if($_POST['passwd'] == 'iknock') {
            $_SESSION['MANAGE'] = true;
            WebApp::redirect('manage.organ');
    }
    else{
      echo "
      <script>
      alert('비밀번호를 확인하십시오');
      history.go(-1);
      </script>
      ";
    }
	break;
}
?>