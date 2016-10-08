<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: reply.php
* 작성일: 2005-03-16
* 작성자: 거친마루
* 설  명: 게시판 답변글 달기
* accept method : get / post
*****************************************************************
* 
*/
$id = $_REQUEST['id'];
if(!$env['writable']) WebApp::raiseError('권한이 없습니다.');
$DB = WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);



switch ($REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('글이 존재하지 않습니다');
		/*$data = $DB->sqlFetch("SELECT * FROM $ARTICLE_TABLE WHERE  $que num_mcode=$mcode AND num_serial=$id");
		if (!$data) WebApp::moveBack('해당 글이 존재하지 않습니다');
		@_format_data(&$data);

		$tpl->assign('re','<td width="40">[Re]:</td>');
		*/

$data[str_title] ='';
$tpl->assign($data);
//2008-06-24 종태 카테고리 목록

$sql = "select distinct str_category from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('cate_LIST'=>$row));


		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/".$skin."/write.htm"));


		WebApp::call('_titlebar',array('title'=>$TITLE));
		$tpl->assign($data);
		$tpl->assign(array(
			'id'=>$id,
			'mcode'=>$mcode,
			'env'=>$env
		));

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
		$serial = $DB->sqlFetchOne("
			SELECT
				
				max(num_serial)+1
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid = ".$_OID." and
				$que num_mcode=$mcode 
		");

$sql = "
			SELECT
				num_mcode, num_serial, num_group, num_step, num_depth
			FROM
				$ARTICLE_TABLE
			WHERE
			num_oid = ".$_OID." and
				$que num_mcode=$mcode AND num_serial=$id
		";


		$parent_info = $DB->sqlFetch($sql);


		$group = $parent_info['num_group'];
		$depth = (int)$parent_info['num_depth'] + 1;
		$step = (int)$parent_info['num_step'] - 1;
		$mcode = $parent_info['num_mcode'];

		$DB->query("UPDATE $ARTICLE_TABLE SET num_step=num_step-1 WHERE num_oid=$oid AND num_mcode=$mcode AND num_group=$group AND num_step<".$parent_info['num_step']);

        $num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
		$user = $_SESSION['USERID'];
		$name = $_POST['str_name'];
		$pass = $_POST['str_pass'];
		$email = $_POST['str_email'];
		$title = $_POST['str_title'];
		$content = str_replace("'","''",$_POST['content']);
		
	


	
		if(!$_POST['content']) {
			WebApp::moveBack('본문을 입력해주십시오.');
		}

	
		$str_text = $_POST['content'];
		if(!$str_text) $str_text = "<p></p>";
		$title = str_replace("'","''",$title);
		//$str_text = str_replace("'","''",$str_text);
		$str_text = WebApp::ImgChaneDe($str_text, $serial);
		
		//비속어처리 2009-07-25 종태
		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';

		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
        $dt_date = $_POST['dt_date'] ? "'".$_POST['dt_date']."'" : "'".date("Y-m-d")."'";

  		if($_POST['dt_date']){
			$dt_date = WebApp::mkday($_POST['dt_date']);
		}else{
			$dt_date = mktime();
		}	

		
		$ip = getenv('REMOTE_ADDR');
	
		
		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text,  chr_html, dt_date, str_ip, num_hit,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,num_unix_time,str_view,num_input_pass,str_nick)
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str_text','$use_html', $dt_date,'$ip', $num_hit,'$str_category', '$str_tmp1', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10',".mktime().",'$str_view','$num_input_pass','$str_nick')
			";
		


		if ($DB->query($sql)) {
			$DB->commit();


			if($_SESSION['USERID']){
				//2008-07-07 회원 포인트 값
				$plus_point = "num_repaly_point";

				$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
				$chw = $DB -> sqlFetchOne($sql);
				
				//2008-11-10 현민 - 게시글 등록시 포인트는 하루에 2건만으로 제한.
				$sdate = mktime(0,0,0,date("m"),date("d"),date("Y"));
				$edate = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

				$sql = "select count(*) from $ARTICLE_TABLE 
							where num_oid = $_OID 
							and str_user = '".$_SESSION['USERID']."' 
							and num_depth > 0 
							and num_unix_time between $sdate and $edate";
				$bcnt = $DB -> sqlFetchOne($sql);

				if($bcnt <= 2){
					$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
					$DB->query($sql);
					$DB->commit();
				}

			}


// {{{ 업로드한 파일 처리
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

}else{



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




			WebApp::redirect($listlink);
		} else {
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();
			WebApp::moveBack('답변을 달 수 없습니다');
		}
		break;
}

#### Functions ####
function _format_data(&$data) {
	$data['passwd'] = $data['writer'] = $data['email'] = $data['use_html'] = $data['dt_date'] = $data['num_hit'] = "";
	$data['title'] = &$data['str_title'];
	$data['comment'] = "\n\n\n\n\n------------------------------------------\n[ ".$data['title']." ]\n".$data['body'];
}
?>
