<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: modify.php
* �ۼ���: 2005-03-16
* �ۼ���: ��ģ����
* ��  ��: �Խ��� �� ����
* accept method : get / post
*****************************************************************
* 
*/
$id = $_REQUEST['id'];

if(!$env['writable']) WebApp::raiseError('������ �����ϴ�.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);

		

		$tpl->define("CONTENT", WebApp::getTemplate("tong_board/skin/A_board/write.htm"));
		
		$que = " num_oid = '$_OID' and ";





switch(REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
		$sql = "
				SELECT
				num_mcode AS mcode,num_serial AS serial,num_notice,str_user,str_name AS name,str_pass,str_email AS email,str_title,str_text, chr_html AS use_html, TO_CHAR(dt_date,'YYYY-MM-DD') AS dt_date,
				num_hit , num_file, str_ip AS remote_addr, num_comment, str_thumb , str_hak, num_input_pass, str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick,str_view
			FROM
				$ARTICLE_TABLE
			WHERE
				$que num_mcode=$mcode AND num_serial=$id
		";
		$data = $DB->sqlFetch($sql);
		_format_data(&$data);
		$data['content'] = $FH->set_content($data['content']);




		
		WebApp::call('_titlebar',array('title'=>$TITLE));
	
		if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);

		
		//2008-06-24 ���� ī�װ� ���
		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row));

		$tpl->assign($data);
		$tpl->assign(array(
			'id'=>$id,
			'mcode'=>$mcode,
			'env'=>$env
		));

		//2008-12-01 ÷������ �뷮üũ �߰�
		list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize();
		$tpl->assign(array(
			'num_disk'=>$num_disk,
			'num_upload_size'=>$num_upload_size,
			'db_num_size'=>$db_num_size,
			'use_size'=>$use_size,
			'maxfilesize'=>$maxfilesize
		));
	break;
	case "POST":





		if($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
		$serial = $id;
		$originPw = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_serial=$id");

		
		if($_POST['str_pass'] != $originPw) WebApp::moveBack('�н����尡 ��ġ���� �ʽ��ϴ�');

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$use_html = $_POST['use_html'];
		$origin_num_file = $_POST['origin_num_file'];
		if (!$use_html) $use_html = 'Y';
		
		if(strstr($_POST['content'], "SCRIPT")) {
			WebApp::moveBack('������ ��ũ��Ʈ�� ���Եž��ֽ��ϴ�. ���� ����Ҽ� �����ϴ�.');
		}
			if(strstr($_POST['content'] ,"SCRIPT")) {
			WebApp::moveBack('������ ��ũ��Ʈ�� ���Եž��ֽ��ϴ�. ���� ����Ҽ� �����ϴ�.');
		}


		// �ӽ� ������ ó���Դϴ�. //2007-11-07 ����

		$backtext = "�ٵ���|��ī|nara.cn|xgame|����|����|��ģ|8��|������|�һ���|����|����|����|����|�ϱ��|���|����|�ֳ�|�ֳ�|����|����|�ϱ��|��������|���|������|�ٺ�����|�û���|����|����|�ù�|����|���׶�|����|��õ��|��õid|��õ���̵�|��õid|��õ���̵�|��/õ/��|����|���|�ΰ���|��ģ��|��ģ��|���|�׽��ϴ�|�Ծ�|�Ե��|�����|����|��ī|";

		//2008-11-20 ���� ������ �����߰�(������>�⺻���� �����ϰ� �����������.)
		$sql = "select str_bi from TAB_ORGAN where num_oid = $_OID";
		$str_bi = $DB -> sqlFetchOne($sql);
		$backtext .= $str_bi;

		$backtext = explode("|",$backtext);
			

		for($ii=0; $ii<count($backtext); $ii++) {
			if(!$backtext[$ii]) continue;
			if(strstr($_POST['content'], $backtext[$ii])) WebApp::moveBack('������ ������('.$backtext[$ii].')�� ���ԵǾ��ֽ��ϴ�. ���� ����Ҽ� �����ϴ�.');

		}

		$str_text = $_POST['content'];
	    $str_text = WebApp::ImgChaneDe($str_text);
		$title = str_replace("'","''",$title);
		//$str_text = str_replace("'","''",$str_text);
		
       

		$num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : false;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD ')" : false;

		if($_conf[chr_listtype] =="D"){
		if(!$str_view)  $str_view = "N";
		$listsql = ",str_view";
		$listsql_value = ",'$str_view'";
		$listsql_update = ",str_view = '$str_view'";
		}


		$sql = "
			UPDATE
				$ARTICLE_TABLE
			SET
                num_notice=$num_notice, str_title='$title',str_text=:str_text,  str_name='$name',str_email='$email', chr_html='$use_html', num_input_pass = '$num_input_pass' , str_hak = '$str_hak', str_tmp1 = '$str_tmp1',str_tmp2 = '$str_tmp2',str_tmp3 = '$str_tmp3',str_tmp4 = '$str_tmp4',str_tmp5 = '$str_tmp5',str_tmp6 = '$str_tmp6',str_tmp7 = '$str_tmp7',str_tmp8 = '$str_tmp8',str_tmp9 = '$str_tmp9',str_tmp10 = '$str_tmp10', str_category = '$str_category', str_tag = '$str_tag',str_coment = '$str_coment',str_scrab = '$str_scrab',str_nick='$str_nick',str_rss = '$str_rss' $listsql_update ".
                ($num_hit ? ', num_hit='.$num_hit.' ' : '').
                ($dt_date ? ', dt_date='.$dt_date.' ' : '').
			  "WHERE
				$que num_mcode=$mcode AND num_serial=$id
		";



		if ($DB->query_clob($sql,$str_text)) {
			$DB->commit();
        


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
								$que num_mcode=$mcode AND num_serial=$id
						")) $DB->commit();




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



            if($env['use_recent']) {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
            }

			WebApp::redirect("/tong_board.read?mcode=$mcode&id=$id&num=$id");
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('���� ������ �� �����ϴ�');
		}
	break;
}

// {{{ Functions
function _format_data(&$arr) {
	global $env;
	if ($env['admin'] == true) {
		$arr['pass'] = $arr['str_pass'];
	} else 	$arr['str_pass'] = "";
	$arr['use_html_checked'] = ($arr['use_html'] == 1) ? " CHECKED" : "";
	$arr['secret_checked'] = ($arr['secret'] == 1) ? " CHECKED" : "";
	$arr['name'] = &$arr['name'];
	$arr['title'] = $arr['title'];
	$arr['content'] = $arr['str_text']->load();
}
// }}}
?>
