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


	$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write.htm"));

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
	$name = $_POST['str_name'];
	$title = $_POST['str_title'];
	$pass = $_POST['str_pass'];
	$email = $_POST['str_email'];
	$upfiles = $_POST['upfiles'];


	// �ӽ� ������ ó���Դϴ�. //2007-11-07 ����

	$backtext = "�ٵ���|��ī|nara.cn|xgame|����|����|��ģ|8��|����|������|�һ���|����|����|����|����|�ϱ��|���|����|�ֳ�|�ֳ�|����|����|�ϱ��|��������|���|������|�ٺ�����|�û���|����|����|�ù�|����|���׶�|����|��õ��|��õid|��õ���̵�|��õid|��õ���̵�|��/õ/��|����|���|�ΰ���|��ģ��|��ģ��|���|�׽��ϴ�|�Ծ�|�Ե��|�����|����|��ī|";

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
	$str_text = str_replace("'","''",$str_text);
	if(!$str_text) $str_text = "<p></p>";

	//////// ���⼭���� �̹��� ó����.
	$str_text = WebApp::ImgChaneDe3($str_text);
	////////������� �̹��� ó�� ��


	$title = str_replace("'","`",$title);

	$str_text = $FH->get_content($str_text);
	list($str1,$str2,$str3,$str4,$str5,$str6,$str7,$str8,$str9,$str10) = WebApp::content_split($str_text);	// �տ������� 3�� ���ϴ� ����!



		/*$str1 = substr($str_text, 0, 2000);
		$str2 = substr($str_text, 2001, 4000);
		$str3 = substr($str_text, 4001, 6000);
	*/
	$use_html = $_POST['use_html'];
	if (!$use_html) $use_html = 'Y';
	$ip = getenv('REMOTE_ADDR');
	$num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
	$dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';

	if(!$str_tag_use) {
		$str_tag = '';
	}

	$sql =
	"INSERT INTO $ARTICLE_TABLE
	(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
	str_email, str_title, str_text1, str_text2, str_text3, str_text4, str_text5, str_text6, str_text7, str_text8, str_text9, str_text10, chr_html, dt_date, str_ip, num_hit, str_hak, num_input_pass,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick,num_unix_time)
	VALUES
	($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$str4','$str5','$str6','$str7','$str8','$str9','$str10','$use_html', $dt_date,'$ip', $num_hit, '$str_hak','$num_input_pass','$str_category','$str_tmp1', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10','$str_tag','$str_coment','$str_scrab','$str_rss' ,'$str_nick',".mktime().")
	";




	if ($DB->query($sql)) {
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
			$sdate = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$edate = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
			$sql = "select count(*) from $ARTICLE_TABLE
			where num_oid = $_OID
			and str_user = '".$_SESSION['USERID']."'
			and num_depth = 0
			and num_unix_time between $sdate and $edate";
			$bcnt = $DB -> sqlFetchOne($sql);

			if($bcnt <= 2){
				$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
				$DB->query($sql);
				$DB->commit();
			}

		}

		// {{{ ���ε��� ���� ó��
		if(!$_SESSION['get_thumb_filename']) {



			$num_file = ($upfiles = $_POST['upfiles']) ? count(explode("\n",$upfiles)) : 0;


			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$serial);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}

			if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
			$FH->close();
			// }}}


			if ($DB->query("
				UPDATE
				$ARTICLE_TABLE
				SET
				num_file=$num_file, str_thumb='$get_thumb_filename'
				WHERE
				$que num_mcode=$mcode AND num_serial=$serial"
				)) $DB->commit();

		}
		else{



			if ($DB->query("
				UPDATE
				$ARTICLE_TABLE
				SET
				num_file=1, str_thumb='$get_thumb_filename'
				WHERE
				$que num_mcode=$mcode AND num_serial=$serial"
				)) $DB->commit();




		}

		$_SESSION['get_thumb_filename'] = "";
		unset($_SESSION['get_thumb_filename']);


		if($_SESSION['mov_ses']) {
			// 2008-09-26 ���� ������ ���ε尡 �־��ٸ�..
			for($ii=0; $ii<count($_SESSION['mov_ses']); $ii++) {

				$_C_ID .= $_SESSION['mov_ses'][$ii][c_id].",";

				//2008-11-05 ���� ������ ������ ������
				if(!strstr($content,"?cid=".$_SESSION['mov_ses'][$ii][c_id])) {
					$fp1 = fopen("http://121.78.86.50/uadmin/content_delete_proc2.php?id=".$_SESSION['mov_ses'][$ii][c_id],"r");
					fclose($fp1);
				}

			}
			unset($_SESSION['mov_ses']);



			if ($DB->query("
				UPDATE
				$ARTICLE_TABLE
				SET
				str_mov='".$_C_ID."'
				WHERE
				$que num_mcode=$mcode AND num_serial=$serial"
				)) $DB->commit();



			//unset($_SESSION['mov_ses']);
		}

    /*        if($env['use_recent']) {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');

		}*/

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







		echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.list?mcode=$mcode'\">";

	}
	else {
		$FH->rm_tmp_files($_POST['timestamp']);
		$FH->close();

		WebApp::moveBack('���� �ۼ��� �� �����ϴ�'.$DB->error['message']);
	}
	break;
}
?>
