<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/manage/makehost.php
* �ۼ���: 2006-05-01
* �ۼ���: ������
* ��  ��: ȣ��Ʈ �����ϱ� (�� �������̽�)
*****************************************************************
* 
*/

if(!$_SESSION[ADMIN]){
WebApp::moveBack('�����̾����ϴ�.');
exit;
}


$DB = &WebApp::singleton('DB');
$default_passwd = 'ewut'.date("Y");
$host_url = DOMAIN_;

switch (REQUEST_METHOD) {
	case 'GET':


	
	$d = dir("theme");
    while ($_types = $d->read()) {
      if ($_types{0} == '.') continue;
      if (is_dir("theme/{$_types}")) {
        $_type_conf = @parse_ini_file("theme/{$_types}/template.conf.php");
        $types[] = array(
          'name' => $_types,
          'description' => $_type_conf['description']
        );
      }
    }

/* �׽�Ʈ �ڵ�
        $FORM = &WebApp::singleton('Form','makeform');
        $FORM->setValues(array(
            'str_organ'=>'�����׽�Ʈ',
            'str_ceo_name'=>'�׽�Ʈ',
            'str_ceo_email'=>'test@test.com',
            'str_phone'=>'02-222-2222',
            'str_fax'=>'02-222-3333',
            'chr_zip'=>'123-456',
            'str_addr1'=>'����� ������ ����2��',
            'str_addr2'=>'1234',
            'str_master_name'=>'�׽�Ʈ',
            'str_master_phone'=>'02-333-3333',
            'str_master_mobile'=>'010-5555-5555',
            'str_master_email'=>'master@test.com',
            'str_password'=>'1111',
            'str_host'=>'exam',
            'str_domain'=>'',
            'str_theme'=>'default'
        ));
//*/


	$sql = "select str_host,str_organ from TAB_ORGAN where str_hometype = 'HOME'  ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('organ_LIST'=>$row));



    $tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("manage/makehost.htm"));

    $tpl->assign('DESIGN_TYPE',$types);
	$tpl->assign(array('mcode'=>$mcode));
	
	
	break;

  
  
  case 'POST':


  
  

		$str_organ = $_POST['str_organ'];
		$str_ceo_name = $_POST['str_ceo_name'] ? $_POST['str_ceo_name'] : "�Է¾���";
		$str_ceo_email = $_POST['str_ceo_email'] ? $_POST['str_ceo_email'] : "�Է¾���";
		$str_phone = $_POST['str_phone'] ? $_POST['str_phone'] : "�Է¾���";
		$str_fax = $_POST['str_fax'] ? $_POST['str_fax'] : "�Է¾���";
		$chr_zip = $_POST['chr_zip'] ? $_POST['chr_zip'] : "�Է¾���";
		$str_addr1 = $_POST['str_addr1'] ? $_POST['str_addr1'] : "�Է¾���";
		$str_addr2 = $_POST['str_addr2'] ? $_POST['str_addr2'] : "�Է¾���";
		$str_master_name = $_POST['str_master_name'] ? $_POST['str_master_name'] : "�Է¾���";
		$str_master_phone = $_POST['str_master_phone'] ? $_POST['str_master_phone'] : "�Է¾���";
		$str_master_mobile = $_POST['str_master_mobile'] ? $_POST['str_master_mobile'] : "�Է¾���";
		$str_master_email = $_POST['str_master_email'] ? $_POST['str_master_email'] : "�Է¾���";
		$str_password = $_POST['str_password'] ? $_POST['str_password'] : $default_passwd;
		
		$host = $str_host = $_POST['str_host'];
		$hosturl = $str_host = $_POST['str_host'].'.'.$host_url.'';
		
		$str_domain = $_POST['str_domain'] ? $_POST['str_domain'] : "�Է¾���";
		$str_theme = $_POST['str_theme'] ? $_POST['str_theme'] : "SH1";

		if (is_dir("hosts/{$host}") || is_link("hosts/{$host}")) {
			WebApp::raiseError('���� ȣ��Ʈ�� �����մϴ�.');
		}

		//==-- DB ���� �Է� --==//
		$oid = (int)$DB->sqlFetchOne("
				SELECT
						/*+ INDEX_DESC(".TAB_ORGAN." ".PK_TAB_ORGAN.") */
						num_oid
				FROM
						".TAB_ORGAN."
				WHERE
						rownum = 1
		") + 1;

/*	if($str_end_date) {
		$mk = date("Y-m-d");
		$mk = explode("-",$mk);
		$str_end_date = $mk[0]+$str_end_date."-".$mk[1]."-".$mk[2];
			
	}*/

	$user_ip		= getenv("REMOTE_ADDR");
	$sql = "INSERT INTO TAB_MEMBER 
	(

	num_oid,
	str_name,
	str_nick,
	str_id,
	chr_mtype,
	num_auth,
	num_login_cnt,
	str_ip,
	dt_date,
	num_jumin,
	str_passwd,
	chr_zip,
	str_addr1,
	str_addr2,
	str_email,
	str_phone,
	str_handphone


	) VALUES (

	'$oid',
	'�б�������',
	'�б�������',
	'admin',
	'z',
	'1',
	'1',
	'$user_ip',
	SYSDATE,
	'$oid',
	'$str_password',
	'$chr_zip',
	'$str_addr1',
	'$str_addr2',
	'$str_master_email',
	'$str_phone',
	'$str_phone'


	) ";
	$DB->query($sql);
	$DB->commit();






		$sql = "INSERT INTO ".TAB_ORGAN." (
			num_oid,
			str_host,
			str_domain,
			str_organ,
			str_title,
			str_theme,
			str_password,
			str_ceo_name,
			str_ceo_email,
			str_phone,
			str_fax,
			chr_zip,
			str_addr1,
			str_addr2,
			str_master_name,
			str_master_phone,
			str_master_mobile,
			str_master_email,
			dt_date,

			str_hometype,
			str_school,
			
			
			str_sa_number,
			str_st,
			str_end_date,
			str_bi,
			str_text



		) VALUES (
			  $oid,
			'$host',
			'$str_domain',
			'$str_organ',
			'$str_organ',
			'$str_theme',
			'$str_password',
			'$str_ceo_name',
			'$str_ceo_email',
			'$str_phone',
			'$str_fax',
			'$chr_zip',
			'$str_addr1',
			'$str_addr2',
			'$str_master_name',
			'$str_master_phone',
			'$str_master_mobile',
			'$str_master_email',
			SYSDATE,

			'$str_hometype',
			'$str_school',

			'$str_sa_code',
			'$str_st',
			'$str_end_date',
			'$str_bi',
			'$str_text'
			
		)";

		if(!$DB->query($sql)) {
			
			WebApp::raiseError('SQL���� ���������� ������� ���߽��ϴ� ['.$sql.$DB->error['message'].']');

		}
		$DB->commit();





    //*/==-- ����ȣ��Ʈ�� ���丮 ���� --==//
	
		//$FH->make_host($oid);
		
		$copy_oid = 2;
		
		//����1 ����
		exec("cp -R "._DOC_ROOT."/hosts/".strtolower($str_theme)."/ "._DOC_ROOT."/hosts/".$host."/");
		exec("rm -R "._DOC_ROOT."/hosts/".$host."/conf/global.conf.php");
		exec("chmod -R 707 "._DOC_ROOT."/hosts/".$host."/");
		exec("ln -s "._DOC_ROOT."/hosts/".$host."/www2/hosts/".$oid);
		$table = array();



		//$table[]['table_name'] = "TAB_POPUP";
		//$table[]['table_name'] = "TAB_TITLE_DOC";
		$table[]['table_name'] = "TAB_ATTACH_CONFIG";
		$table[]['table_name'] = "TAB_ATTACH_PART";
		//$table[]['table_name'] = "TAB_BOARD_CONFIG";
		//$table[]['table_name'] = "TAB_CONTENT_URL";
		//$table[]['table_name'] = "TAB_CSS";
		//$table[]['table_name'] = "TAB_FILES";
		//$table[]['table_name'] = "TAB_MENU";
		//$table[]['table_name'] = "TAB_MENU_RIGHT";
		//$table[]['table_name'] = "TAB_MENU_INDEX";
		//$table[]['table_name'] = "TAB_BOARD_CATEGORY";

		for($ii=0; $ii<count($table); $ii++) {
			
		if($table[$ii]['table_name'] == "TAB_ATTACH_CONFIG"){
		
		if(strlen($str_theme) == 6) {
			$type_number = substr(strtolower($str_theme),strlen(strtolower($str_theme))-2,strlen(strtolower($str_theme)));	
		}else{
			$type_number = substr(strtolower($str_theme),strlen(strtolower($str_theme))-1,strlen(strtolower($str_theme)));
		}

			$sql = "select * from ".$table[$ii]['table_name']." where num_oid = '$copy_oid' and num_css = '".$type_number."'";
		}else{
			$sql = "select * from ".$table[$ii]['table_name']." where num_oid = '$copy_oid' ";
		}

		$row = $DB -> sqlFetchAll($sql);

		for($iii=0; $iii<count($row); $iii++) {

			if($table[$ii]['table_name'] != "TAB_ORGAN") {

				unset($row[$iii][num_oid]);
				$row[$iii][num_oid] = $oid;

				if($table[$ii]['table_name'] == "TAB_ATTACH_CONFIG"){
				$row[$iii][num_css] = 1;
				}

				$DB-> insertQuery($table[$ii]['table_name'],$row[$iii]);
				 $DB->commit();

				//echo "<br>";
			}
			}



		}







		//==-- �⺻ ���ϵ� ���� --==//
		
		$FH = &WebApp::singleton('FileHost');
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		//$FTP->mkdir(_DOC_ROOT."/hosts/{$host}");
		//$FTP->put_r("var/skel",_DOC_ROOT."/hosts/{$host}");
		//$FTP->put_r("theme/{$str_theme}/@",_DOC_ROOT."/hosts/{$host}");
		$FTP->chmod(_DOC_ROOT."/hosts/$host/files",777);
		$FTP->chmod(_DOC_ROOT."/hosts/$host/tmp",777);
		$FTP->chmod(_DOC_ROOT."/hosts/$host",707);
		

		
		
		flush();

		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		//==-- �������� ���� --==/*/
		//** global.conf.php
		$data = $_POST;
		$data['oid'] = $data['num_oid'] = $oid;
		$data['file_ftp_num'] = DEFAULT_FILE_FTP_NUM;

		$cfgfile = &WebApp::singleton('MiniTemplate','theme/'.$str_theme.'/conf/global.conf.php.tpl');
		$cfgfile->assign($data);
		$cfgfile->parse();
		$FTP->put_string($cfgfile->fetch(),_DOC_ROOT."/hosts/{$host}/conf/global.conf.php");
		flush();



	/*	// ���̾ƿ� ��ġ
		$THEME_CONF = Display::getThemeConf($str_theme);
		if($THEME_CONF['attach']['use_attach']) {
				include_once 'theme/'.$str_theme.'/attach/attach_default_sql.php';
				if(is_array($sql)) foreach($sql as $_sql) $DB->query($_sql);
				$DB->commit();

		}
		flush();

		$DB->commit();
		*/
		


			
			/*	include_once 'module/attach/admin/makelayer.php';
				foreach($THEME_CONF['attach']['layouts'] as $layout => $layout_name) {
				    makelayer($layout,$oid,$host);
				}*/

		echo '<script>alert("�����Ǿ����ϴ�. �����ڿ��� ���̾ƿ���ġ�۾��� ���ּ���.");window.open("http://'.$hosturl.'/");</script>';
		//echo "<meta http-equiv='Refresh' Content=\"0; URL='http://{$host}/admin'\">";
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.organ?mcode=$mcode'\">";

		//WebApp::redirect($URL->setVar('act','.makehost'),'�����Ǿ����ϴ�. �����ڿ��� ���̾ƿ���ġ�۾��� ���ּ���.');
		break;
}
?>
