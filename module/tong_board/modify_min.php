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


$tpl->define("CONTENT",WebApp::getTemplate("board/skin/".$skin."/write_min.htm"));

		
		
		$que = " num_oid = '$_OID' and ";





switch(REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
		$sql = "
			SELECT
				num_mcode AS mcode,num_serial AS serial,num_notice,str_user,str_name AS name,str_pass,str_email AS email,str_title,str_text1,str_text2,str_text3,str_text4,str_text5,str_text6,str_text7,str_text8,str_text9,str_text10, chr_html AS use_html, TO_CHAR(dt_date,'YYYY-MM-DD') AS dt_date,
				num_hit , num_file, str_ip AS remote_addr, num_comment, str_thumb , str_hak, num_input_pass, str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick
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

		$sql = "select distinct str_category from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row));

		$tpl->assign($data);
		$tpl->assign(array(
			'id'=>$id,
			'mcode'=>$mcode,
			'env'=>$env
		));
	break;
	case "POST":
		if($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');

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

		$str_text = $FH->get_content($_POST['content']);
		$content = str_replace("'","''",$content);

		//////// ���⼭���� �̹��� ó����.
		$s = $str_text; 
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		for($ii=0; $ii<count($tmp_img_list); $ii++) {
			if(strstr($tmp_img_list[$ii],"/".$sess_id."/") && $sess_id){

				$tmp_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_tmp/".date("Ymd")."/".$sess_id."/";
				$real_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_img/".date("Ymd")."/".$sess_id."/";

				//host�� ����� host�� ����������Ѵ�.
				$tmp_img_list[$ii] = str_replace("http://".$HTTP_HOST, "", $tmp_img_list[$ii]);

				//���̹��� ��η� ����
				$real_image = str_replace("/board_tmp/", "/board_img/", $tmp_img_list[$ii]);

				//���̹��� ����� ���丮 ����
				$path = explode("/",$real_dir);
				for($i=0;$i<count($path);$i++) {
					for($j=0;$j<=$i;$j++) {
						$path_dir .= $path[$j]."/";
					}
					if (!is_dir($path_dir)) { 
						mkdir($path_dir,0707); 
						chmod($path_dir, 0777); 
					}
					$path_dir=$path_con_dir="";
				}

				//������ ���� �̹����� board_img ���丮�� move��Ų��.
				if(rename(_DOC_ROOT.$tmp_img_list[$ii], _DOC_ROOT.$real_image)){
					//������ ���� �̹��� ��� �������ش�.
					$str_text = str_replace($tmp_img_list[$ii],$real_image,$str_text);
				}
			}
		}

		// /board_tmp/ �� �Ϸ簡 ���� ������ ������ ���⼭ ��������~
		$del_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_tmp/".date("Ymd", mktime(0,0,0,date("m"),date("d")-2,date("Y")))."/";
		if (is_dir($del_dir)) { 
			system("rm -rf $del_dir");
		}
		////////������� �̹��� ó�� ��

		list($str1,$str2,$str3,$str4,$str5,$str6,$str7,$str8,$str9,$str10) = WebApp::content_split($str_text);	// �տ������� 3�� ���ϴ� ����!
       

		$num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : false;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD ')" : false;

		$sql = "
			UPDATE
				$ARTICLE_TABLE
			SET
                num_notice=$num_notice, str_title='$title',str_text1='$str1', str_text2='$str2', str_text3='$str3', str_text4='$str4', str_text5='$str5', str_text6='$str6', str_text7='$str7', str_text8='$str8', str_text9='$str9', str_text10='$str10', str_name='$name',str_email='$email', chr_html='$use_html', num_input_pass = '$num_input_pass' , str_hak = '$str_hak', str_tmp1 = '$str_tmp1',str_tmp2 = '$str_tmp2',str_tmp3 = '$str_tmp3',str_tmp4 = '$str_tmp4',str_tmp5 = '$str_tmp5',str_tmp6 = '$str_tmp6',str_tmp7 = '$str_tmp7',str_tmp8 = '$str_tmp8',str_tmp9 = '$str_tmp9',str_tmp10 = '$str_tmp10', str_category = '$str_category', str_tag = '$str_tag',str_coment = '$str_coment',str_scrab = '$str_scrab',str_rss = '$str_rss' , str_nick = '$str_nick' ".
                ($num_hit ? ', num_hit='.$num_hit.' ' : '').
                ($dt_date ? ', dt_date='.$dt_date.' ' : '').
			  "WHERE
				$que num_mcode=$mcode AND num_serial=$id
		";


		if ($DB->query($sql)) {
			$DB->commit();
        


if($_SESSION['get_thumb_filename']) {
	$sql = "
                UPDATE
                    $ARTICLE_TABLE
                SET
                    num_file=1, str_thumb='$get_thumb_filename'
                WHERE
                    $que num_mcode=$mcode AND num_serial=$id";


  if ($DB->query($sql)) $DB->commit();




}else{

$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			
			if($FH->thumb_target) {
				$get_thumb_filename = $FH->thumb_target;
				if($_POST['str_thumb'] != $FH->thumb_target) $FH->del_thumb($_POST['str_thumb']);
			} else {
				$get_thumb_filename = $_POST['str_thumb'];
			}
			$FH->close();
			// }}}

			if ($DB->query("
				UPDATE
					$ARTICLE_TABLE
				SET
					num_file=$origin_num_file + $num_file,
					str_thumb='$get_thumb_filename'
				WHERE
					$que num_mcode=$mcode AND num_serial=$id
			")) $DB->commit();


}

$_SESSION['get_thumb_filename'] = "";
unset($_SESSION['get_thumb_filename']);



$sql = "select str_mov from TAB_BOARD $que num_mcode=$mcode AND num_serial=$id";
$str_mov = $DB -> sqlFetchOne($sql);
$str_mov = explode(",",$str_mov);
	


if($str_mov[$ii]) { // 2008-09-26 ���� ������ ���ε尡 �־��ٸ�..
		for($ii=0; $ii<count($str_mov[$ii]); $ii++) {

		

	//2008-11-05 ���� ������ ������ ������			
	if(!strstr($content,"?cid=".$str_mov[$ii])) {
	$fp1 = fopen("http://121.78.86.50/uadmin/content_delete_proc2.php?id=".$str_mov[$ii],"r");
	fclose($fp1);	
	}		

	}

}


if($_SESSION['mov_ses']) { // 2008-09-26 ���� ������ ���ε尡 �־��ٸ�..
		for($ii=0; $ii<count($_SESSION['mov_ses']); $ii++) {

		$_C_ID .= $_SESSION['mov_ses'][$ii][c_id].",";	

	//2008-11-05 ���� ������ ������ ������			
	if(!strstr($content,"?cid=".$_SESSION['mov_ses'][$ii][c_id])) {
	$fp1 = fopen("http://121.78.86.50/uadmin/content_delete_proc2.php?id=".$_SESSION['mov_ses'][$ii][c_id],"r");
	fclose($fp1);	
	}		

	}
}
unset($_SESSION['mov_ses']);




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

			WebApp::redirect($listlink);
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
	$arr['content'] = $arr['str_text1'].$arr['str_text2'].$arr['str_text3'].$arr['str_text4'].$arr['str_text5'];
}
// }}}
?>
