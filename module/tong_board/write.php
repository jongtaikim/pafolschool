<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: write.php
* �ۼ���: 2002-12-26
* �ۼ���: ��ģ����
* ��  ��: �Խ��� �� ���� �ۼ�
*****************************************************************
* 
*/

$PERM->apply('menu',$mcode,'w');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
		$timestamp = date('U');
		

        $tpl->define("CONTENT", WebApp::getTemplate("tong_board/skin/A_board/write.htm"));

		$str_title = "";
		$tpl->assign(array('str_title'=>$str_title));
		
		WebApp::call('_titlebar',array('title'=>$TITLE));


		$tpl->assign(array(
			'mcode'=>$mcode,
			'env'=>$env,
			'edit'=>$edit
		));
		
		$data['user_id'] = $_SESSION['USERID'];
		$data['name2'] = $_SESSION['NAME'];
		$data['e_mail'] = $_SESSION['E_MAIL'];
		$data['password'] = $_SESSION['PASSWORD'];
		$data['dt_date'] = date("Y-m-d",mktime());

		//2008-06-24 ���� ī�װ� ���

		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row));



		// {{{ ���ε��� ���� ó��
		$serial = $DB->sqlFetchOne("
					SELECT
						/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
							max(num_serial) + 1
					FROM
						$ARTICLE_TABLE
					WHERE
						 num_oid = '$_OID' and  num_mcode=$mcode 
				");

		if(!$serial) $serial = 1;



		$FH->delete_as_main($serial);


		/*		$sql = 'delete  '.
						'FROM '.TAB_FILES.' '.
						'WHERE '.
							'NUM_OID='.$_OID.' AND '.
							'STR_SECT=\'menu\' AND '.
							'STR_CODE=\''.$mcode.'\' AND '.
							'NUM_MAIN='.$serial;


					$DB->query($sql);
					$DB->commit();
		*/
		$tpl->assign($data);


		list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize();


		$tpl->assign(array(
			'num_disk'=>$num_disk,
			'num_upload_size'=>$num_upload_size,
			'db_num_size'=>$db_num_size,
			'use_size'=>$use_size,
			'maxfilesize'=>$maxfilesize,
			'str_category'=>$str_category,
		));
		break; 
	
	case "POST":


		//���� TAB_CATEGORY �߰�
		if($str_category_text && ($str_category_text != '�Ϲ�')){
			$sql = "select count(*) from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode=$mcode and str_category='$str_category_text'";
			$cat_count = $DB -> sqlFetchOne($sql);

			if(!$cat_count){
				$sql = "
					SELECT
						/*+ INDEX_DESC (TAB_BOARD_CATEGORY PK_BOARD_CATEGORY) */
							max(NUM_SERIAL) + 1
					FROM
						TAB_BOARD_CATEGORY
					WHERE
						 num_oid = $_OID and num_mcode=$mcode
				";
				$cat_serial = $DB -> sqlFetchOne($sql);
				if (!$cat_serial) $cat_serial = 1;

				$sql = "INSERT INTO TAB_BOARD_CATEGORY(num_oid, num_mcode, num_serial, str_category) VALUES($_OID, $mcode, $cat_serial, '$str_category_text')";
				$DB->query($sql);
				$DB->commit();
			}
			$str_category = $str_category_text;
		}

		$que = " num_oid = '$_OID' and ";

		

		$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
					max(num_serial) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				 num_oid = '$_OID' and  num_mcode=$mcode 
		");




		if (!$serial) $serial = 1;
		$group = $DB->sqlFetchOne("
			SELECT
				max(num_group) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				$que num_mcode=$mcode
		");
		

		

		if (!$group) $group = 1;
		$depth = 0;
		$step = 0;

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$user = $_SESSION['USERID'];
		$name = trim($_POST['str_name']);
		$title = trim($_POST['str_title']);
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$upfiles = $_POST['upfiles'];

		// �ӽ� ������ ó���Դϴ�. //2007-11-07 ����

		$backtext = "��ī|nara.cn|xgame|����|����|��ģ|8��|������|�һ���|����|����|����|����|�ϱ��|���|����|�ֳ�|�ֳ�|����|����|�ϱ��|��������|���|������|�ٺ�����|�û���|����|����|�ù�|����|���׶�|����|��õ��|��õid|��õ���̵�|��õid|��õ���̵�|��/õ/��|����|���|�ΰ���|��ģ��|��ģ��|���|�׽��ϴ�|�Ծ�|�Ե��|�����|����|��ī|";

		//2008-11-20 ���� ������ �����߰�(������>�⺻���� �����ϰ� �����������.)
		$sql = "select str_bi from TAB_ORGAN where num_oid = $_OID";
		$str_bi = $DB -> sqlFetchOne($sql);
		$backtext .= $str_bi;

		$backtext = explode("|",$backtext);

		for($ii=0; $ii<count($backtext); $ii++) {
			if(!$backtext[$ii]) continue;
			if(strstr($_POST['content'], $backtext[$ii])) WebApp::moveBack('������ ������('.$backtext[$ii].')�� ���ԵǾ��ֽ��ϴ�. ���� ����Ҽ� �����ϴ�.');

		}		
		
		



		if(strstr($_POST['content'], "SCRIPT")) {
			WebApp::moveBack('������ ��ũ��Ʈ�� ���ԵǾ��ֽ��ϴ�. ���� ����Ҽ� �����ϴ�.');
		}
    
	
		if(!$_POST['content']) {
			WebApp::moveBack('������ �Է����ֽʽÿ�.');
		}

	
		
		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$str_text = WebApp::ImgChaneDe($str_text, $serial);

		$title = str_replace("'","''",$title);
		//$str_text = str_replace("'","''",$str_text);
		

		//2008-08-08 ���� �ܺ��̹����� ã�Ƽ� ������ �����Ѵ�..����
/*
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->mkdir($FH->file_dir);
		$FTP->chmod($FH->file_dir,777);
		$FTP->mkdir($FH->file_dir."/board_img/");
		$FTP->chmod($FH->file_dir."/board_img/",777);
			
		$s = $str_text; 
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		for($ii=0; $ii<count($tmp_img_list); $ii++) {
			if(!strstr($tmp_img_list[$ii],"isch")){
		
			///////////////////////////////////////////
			$ch = curl_init($tmp_img_list[$ii]);
			$tmp_file = $FH->file_dir."/board_img/".mktime()."gif";

			$fp = fopen($tmp_file, "w");

			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			curl_exec($ch);
			curl_close($ch);
			fclose($fp);

			$str_text = str_replace($tmp_img_list[$ii],$tmp_file,$str_text);
			//////////////////////////////////////////////
			}
		}
*/		
	

		


		/*$str1 = substr($str_text, 0, 2000);
		$str2 = substr($str_text, 2001, 4000);
		$str3 = substr($str_text, 4001, 6000);
		*/
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
		$ip = getenv('REMOTE_ADDR');
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
		if((strlen($_POST['dt_date'])>0) && substr(trim($_POST['dt_date']),0,2) != '20') $_POST['dt_date'] = "20".trim($_POST['dt_date']);
        $dt_date = trim($_POST['dt_date']) ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';

		if(!$str_tag_use) {
			$str_tag = '';
		}

		
		if($_conf[chr_listtype] =="D"){
		if(!$str_view)  $str_view = "N";
		$listsql = ",str_view";
		$listsql_value = ",'$str_view'";
		$listsql_update = ",str_view = '$str_view'";
		}

		//if(strlen($str_text)>100000)WebApp::moveBack('���� �ۼ��� �� �����ϴ� : ���� ������ �ٿ��ּ���');



						
		if(($mcode == _AOIDAS1 || $mcode == _AOIDAS2 || $mcode == _AOIDAS3 || $mcode == _AOIDAS4) ) {

			$titlee="[����][�����ڹ���] $str_title";
			$board_add = "http://www.goesh.net/tong_board.list?mcode=$mcode";
			if($mcode == _AOIDAS1) { $board_add2 = "�۾���û�Խ���"; }
			else{	$board_add2 = "���ǰԽ���"; }
			$board_name = "$str_tmp1";
			$board_url = "http://$str_tmp2";

			$email = "now17@e-wut.com";
			$email2 = "mace@e-wut.com";

			
			$rmail = "now17@nate.com";
			$name="$str_name";

			$mail_header = "From: $name <$rmail>\n";
			$mail_header .= "Reply-to: $rmail\n";
			$mail_header .= "MIME-Version: 1.0\n";
			$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
			$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";
			
				$cont="
							<html>
							<head>
							<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
							<title>[�����ڹ���] ���Դϴ�.</title>
							</head>

							<body>
							<table width='660' border='0' cellspacing='0' cellpadding='0'>
							  <tr>
								<td>
								�۾��б� : $board_name ( $board_url )
								<br>
								�Խ��� �ּ� : $board_add2 : $board_add
								<br>
								����: $str_title
								<br>
								���� : $str_text
								</td>
							  </tr>
							</table>
							</body>
							</html>
					";

			mail($email,$titlee,$cont,$mail_header);
			mail($email2,$titlee,$cont,$mail_header);
			mail($rmail,$titlee,$cont,$mail_header);

		}



		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text, chr_html, dt_date, str_ip, num_hit, str_hak, num_input_pass,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick,num_unix_time $listsql) 
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title',:str_text,'$use_html', $dt_date,'$ip', $num_hit, '$str_hak','$num_input_pass','$str_category','$str_tmp1', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10','$str_tag','$str_coment','$str_scrab','$str_rss' ,'$str_nick',".mktime()." $listsql_value)
			";



		if ($DB->query_clob($sql,$str_text)) {
			$DB->commit();

			if($str_setup) {

				 $str_setup_val = $str_coment."|".$str_scrab."|".$str_rss;
				
				 $sql = "UPDATE ".TAB_MEMBER." SET STR_SETUP='$str_setup_val' WHERE num_oid=$_OID and str_id = '".$_SESSION['USERID']."'";
				 $DB->query($sql);
				 $DB->commit();
				$_SESSION['SETUP'] = $str_setup_val;
			}



			if($_SESSION['USERID']){
				//2008-07-07 ȸ�� ����Ʈ ��
				$plus_point = "num_board_point";

				$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
				$chw = $DB -> sqlFetchOne($sql);
				
				//2008-11-10 ���� - �Խñ� ��Ͻ� ����Ʈ�� �Ϸ翡 2�Ǹ����� ����.
				$sql = "select count(*) from $ARTICLE_TABLE where num_oid = $_OID and str_user = '".$_SESSION['USERID']."'";
				$bcnt = $DB -> sqlFetchOne($sql);

				if($bcnt < 2){
					$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
					$DB->query($sql);
					$DB->commit();
				}

			}
// {{{ ���ε��� ���� ó��


		//2009-07-01 ���� �ű� ���ε� ���μ���
		$FH = &WebApp::singleton('FileHost');
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

		$FTP->mkdir($FH->file_dir);
		$FTP->chmod($FH->file_dir,777);
		$FTP->mkdir($FH->file_dir."/".date("Ym")."/");
		$FTP->chmod($FH->file_dir."/".date("Ym")."/",777);


		
		for($ii=1; $ii<11; $ii++) {
			uploadFile($ii);
		}

		
		  if ($DB->query("
                UPDATE
                    $ARTICLE_TABLE
                SET
                   str_thumb='".$_SESSION['get_thumb_filename']."'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$serial"
                )) $DB->commit();
			
			$_SESSION['get_thumb_filename'] = "";
			unset($_SESSION['get_thumb_filename']);




		function deleteCacheFiles($mcode) {
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/smenu.htm');

				$_mcode = substr($mcode,0,2);
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$_mcode.'.htm');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$mcode.'.htm');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu2.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');


				  $dellist=array();
				  $dellist[]="inc.main.out_bbs1.htm";
				  $dellist[]="inc.main.out_bbs2.htm";
				  $dellist[]="inc.main.out_bbs3.htm";
				  $dellist[]="inc.main.out_bbs4.htm";
				  $dellist[]="inc.main.out_bbs5.htm";
				

				for($ii=0; $ii<count($dellist); $ii++) {
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
				}

		}

		deleteCacheFiles($mcode);




	echo '<script>alert("���������� ���� �ۼ��Ǿ����ϴ�.\n����ڿ��� ���Ϲ߼� �Ϸ�!!");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/tong_board.list?mcode=$mcode'\">";

		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			
			echo $DB->error;

				

			//WebApp::moveBack("���� �ۼ��� �� �����ϴ�".$DB->error);
		}
	break;
}
?>
