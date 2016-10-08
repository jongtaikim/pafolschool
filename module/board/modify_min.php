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


$tpl->define("CONTENT",WebApp::getTemplate("board/skin/".$skin."/write_min.htm"));

		
		
		$que = " num_oid = '$_OID' and ";





switch(REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
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

		
		//2008-06-24 종태 카테고리 목록

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
		if($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');

		$originPw = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_serial=$id");

		
		if($_POST['str_pass'] != $originPw) WebApp::moveBack('패스워드가 일치하지 않습니다');

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$name = $_POST['str_name'];
		$title = $_POST['str_title'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$use_html = $_POST['use_html'];
		$origin_num_file = $_POST['origin_num_file'];
		if (!$use_html) $use_html = 'Y';
		
		if(strstr($_POST['content'], "SCRIPT")) {
			WebApp::moveBack('본문중 스크립트가 포함돼어있습니다. 글을 등록할수 없습니다.');
		}
			if(strstr($_POST['content'] ,"SCRIPT")) {
			WebApp::moveBack('본문중 스크립트가 포함돼어있습니다. 글을 등록할수 없습니다.');
		}


		// 임시 금지어 처리입니다. //2007-11-07 종태

		$backtext = "바둑이|포카|nara.cn|xgame|고스톱|씨발|미친|8억|새끼|개새끼|소새끼|병신|지랄|씨팔|십팔|니기미|찌랄|지랄|쌍년|쌍놈|빙신|좆까|니기미|좆같은게|잡놈|벼엉신|바보새끼|씹새끼|씨발|씨팔|시벌|씨벌|떠그랄|좆밥|추천인|추천id|추천아이디|추천id|추천아이디|추/천/인|쉐이|등신|싸가지|미친놈|미친넘|찌랄|죽습니다|님아|님들아|씨밸넘|고스톱|포카|";

		//2008-11-20 현민 관리자 필터추가(관리자>기본설정 동일하게 수정해줘야함.)
		$sql = "select str_bi from TAB_ORGAN where num_oid = $_OID";
		$str_bi = $DB -> sqlFetchOne($sql);
		$backtext .= $str_bi;

		$backtext = explode("|",$backtext);
			

		for($ii=0; $ii<count($backtext); $ii++) {
			if(!$backtext[$ii]) continue;
			if(strstr($_POST['content'], $backtext[$ii])) WebApp::moveBack('본문중 금지어('.$backtext[$ii].')가 포함되어있습니다. 글을 등록할수 없습니다.');

		}

		$str_text = $FH->get_content($_POST['content']);
		$content = str_replace("'","''",$content);

		//////// 여기서부터 이미지 처리됨.
		$s = $str_text; 
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $s, $m); 
		$tmp_img_list = $m[1];

		for($ii=0; $ii<count($tmp_img_list); $ii++) {
			if(strstr($tmp_img_list[$ii],"/".$sess_id."/") && $sess_id){

				$tmp_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_tmp/".date("Ymd")."/".$sess_id."/";
				$real_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_img/".date("Ymd")."/".$sess_id."/";

				//host가 들어간경우 host를 삭제해줘야한다.
				$tmp_img_list[$ii] = str_replace("http://".$HTTP_HOST, "", $tmp_img_list[$ii]);

				//실이미지 경로로 변경
				$real_image = str_replace("/board_tmp/", "/board_img/", $tmp_img_list[$ii]);

				//실이미지 저장될 디렉토리 생성
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

				//본문에 사용된 이미지만 board_img 디렉토리로 move시킨다.
				if(rename(_DOC_ROOT.$tmp_img_list[$ii], _DOC_ROOT.$real_image)){
					//본문에 사용된 이미지 경로 변경해준다.
					$str_text = str_replace($tmp_img_list[$ii],$real_image,$str_text);
				}
			}
		}

		// /board_tmp/ 에 하루가 지난 폴더가 있으면 여기서 삭제하자~
		$del_dir = _DOC_ROOT."/data/hosts/".$_OID."/board_tmp/".date("Ymd", mktime(0,0,0,date("m"),date("d")-2,date("Y")))."/";
		if (is_dir($del_dir)) { 
			system("rm -rf $del_dir");
		}
		////////여기까지 이미지 처리 끝

		list($str1,$str2,$str3,$str4,$str5,$str6,$str7,$str8,$str9,$str10) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!
       

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
	


if($str_mov[$ii]) { // 2008-09-26 종태 동영상 업로드가 있었다면..
		for($ii=0; $ii<count($str_mov[$ii]); $ii++) {

		

	//2008-11-05 종태 쓰레기 동영상 버리기			
	if(!strstr($content,"?cid=".$str_mov[$ii])) {
	$fp1 = fopen("http://121.78.86.50/uadmin/content_delete_proc2.php?id=".$str_mov[$ii],"r");
	fclose($fp1);	
	}		

	}

}


if($_SESSION['mov_ses']) { // 2008-09-26 종태 동영상 업로드가 있었다면..
		for($ii=0; $ii<count($_SESSION['mov_ses']); $ii++) {

		$_C_ID .= $_SESSION['mov_ses'][$ii][c_id].",";	

	//2008-11-05 종태 쓰레기 동영상 버리기			
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
