<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/manage/login.php
* �ۼ���: 2006-06-01
* �ۼ���: �̹���
* ��  ��: 
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
      alert('��й�ȣ�� Ȯ���Ͻʽÿ�');
      history.go(-1);
      </script>
      ";
    }
	break;
}
?>