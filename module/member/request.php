<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/request.php
* �ۼ���: 2006-03-08
* �ۼ���: �̹���
* ��  ��: Ȩ������ ���� ��û ��
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout();
        $tpl->define('CONTENT',WebApp::getTemplate('member/request.htm'));
	break;
	case "POST":
		$str_id = $_POST['str_id'];
        $str_passwd = $_POST['str_passwd'];
        $str_name = $_POST['str_name'];
        $str_jumin1 = $_POST['str_jumin1'];
        $str_jumin2 = $_POST['str_jumin2'];
        $str_vender = $_POST['str_vender'];
        $str_organ = $_POST['str_organ'];
        $num_organ = $_POST['num_organ'];
        $str_addr = $_POST['str_addr'];
        $chr_zip = $_POST['chr_zip'];
        $str_email = $_POST['str_email'];
        $dt_birth1 = $_POST['dt_birth1'];
        $dt_birth2 = $_POST['dt_birth2'];
        $dt_birth3 = $_POST['dt_birth3'];
        $chr_birthtype = $_POST['chr_birthtype'];
        $str_intro_ment = addslashes(strip_tags($_POST['str_intro_ment']));

        $str_url = $str_id.'.kangsa.net';
        $num_hdd = 100;
        $str_theme = 'a';
        $str_jumin = $str_jumin1.'-'.$str_jumin2;

        if (!($str_id && $str_passwd && $str_name && $str_jumin1 && $str_jumin2 && $str_addr && $chr_zip && $str_vender &&
            $str_organ && $num_organ && $str_email &&  $dt_birth1 && $dt_birth2 && $dt_birth3 && $chr_birthtype)) {
            WebApp::moveBack('��� �׸��� �������� �Է��Ͽ� �ֽʽÿ�.');
        }

        $sql = "SELECT /*+ INDEX_DESC (".TAB_MASTER_MEMBER." ".PK_TAB_MASTER_MEMBER.") */ num_oid FROM ".TAB_MASTER_MEMBER." WHERE rownum=1";
        $oid = $DB->sqlFetchOne($sql) + 1;
        $dt_birth = $dt_birth1.'-'.$dt_birth2.'-'.$dt_birth3;

        $sql = "INSERT INTO ".TAB_MASTER_MEMBER." (
                    num_oid,str_vender,str_id,str_passwd,str_name,str_jumin,str_organ,num_organ,str_url,
                    str_theme,num_hdd,str_email,chr_zip,str_addr,dt_birth,chr_birthtype,str_intro_ment
                ) VALUES (
                    $oid,'$str_vender','$str_id','$str_passwd','$str_name','$str_jumin','$str_organ',$num_organ,'$str_url',
                    '$str_theme',$num_hdd,'$str_email','$chr_zip','$str_addr',TO_DATE('$dt_birth','YYYY-MM-DD'),'$chr_birthtype','$str_intro_ment'
                )";
        if(!$DB->query($sql)) {
            $fp = @fopen('tmp/memeber.request.log','a');
            @fwrite($fp, $sql."\n");
            @fclose($fp);
            WebApp::moveBack("��û�� �����Ͽ����ϴ�. �ٽ� �õ��Ͽ� �ֽʽÿ�.\n�ٽ� ���� ������ �߻��� �����Ϳ� �����Ͽ� �ֽñ� �ٶ��ϴ�.");
        }
        $DB->commit();
        WebApp::alert('��û�� �Ϸ�Ǿ����ϴ�.');
        WebApp::closeWin();
	break;
}

?>