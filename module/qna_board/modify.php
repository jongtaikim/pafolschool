<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: modify.php
* 작성일: 2005-03-16
* 작성자: 거친마루
* 설  명: 게시판 글 수정
* accept method : get / post
*****************************************************************
* 
*/
$id = $_REQUEST['id'];

if(!$env['writable']) WebApp::raiseError('권한이 없습니다.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);


$tpl->define("CONTENT",WebApp::getTemplate("qna_board/skin/${skin}/write.htm"));





		
		
		if($mcode < 900000) {
			$que = " num_oid = '$_OID' and ";
		}




switch(REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('해당 문서가 존재하지 않습니다');
		$sql = "
			SELECT
				num_mcode AS mcode,num_serial AS serial,num_notice,str_user,str_name AS name,str_pass,str_email AS email,str_title,str_text1,str_text2,str_text3,str_text4,str_text5, chr_html AS use_html, TO_CHAR(dt_date,'YYYY-MM-DD') AS dt_date,
				num_hit , num_file, str_ip AS remote_addr, num_comment, str_thumb , str_hak, num_input_pass, str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10
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



		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
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
		if($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');

		$originPw = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_serial=$id");
	
	

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$use_html = $_POST['use_html'];
		$origin_num_file = $_POST['origin_num_file'];
		if (!$use_html) $use_html = 'Y';
		



		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$title = str_replace("'","''",$title);
		$str_text = str_replace("'","''",$str_text);
		$str_text = WebApp::ImgChaneDe($str_text, $serial);
		
		list($str1,$str2,$str3,$str4,$str5,$str6,$str7,$str8,$str9,$str10) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!
		


		$num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : false;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : false;

		$sql = "
			UPDATE
				$ARTICLE_TABLE
			SET
                num_notice=$num_notice, str_title='$title',str_text1='$str1', str_text2='$str2', str_text3='$str3', str_text4='$str4', str_text5='$str5', str_name='$name',str_email='$email', chr_html='$use_html', num_input_pass = '$num_input_pass' , str_hak = '$str_hak', str_tmp1 = '$str_tmp1',str_tmp2 = '$str_tmp2',str_tmp3 = '$str_tmp3',str_tmp4 = '$str_tmp4',str_tmp5 = '$str_tmp5',str_tmp6 = '$str_tmp6',str_tmp7 = '$str_tmp7',str_tmp8 = '$str_tmp8',str_tmp9 = '$str_tmp9',str_tmp10 = '$str_tmp10', str_category = '$str_category'  ".
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




}

$_SESSION['get_thumb_filename'] = "";
unset($_SESSION['get_thumb_filename']);


            if($env['use_recent']) {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
            }

			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('글을 수정할 수 없습니다');
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
