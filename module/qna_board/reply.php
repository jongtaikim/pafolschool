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

if($mcode >= 900000) {
	
	// 아이피 체크 2007-06-21 종태
	# (회사 IP인지 체크)

    $REMOTE_ADDR;
    if(!$REMOTE_ADDR) $REMOTE_ADDR = getenv('REMOTE_ADDR');

	$except = array('1');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	//if ($ipbase == '125.7.178' && ($iptail >= 1 && $iptail <= 50)) return (!in_array($iptail,$except));
	if (
  ($ipbase == '61.250.141' && ($iptail >= 1 && $iptail <= 100))
  or($ipbase == '218.237.157' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.104.150' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '124.199.149' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.214.160' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '218.37.42' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '121.139.90' && ($iptail >= 1 && $iptail <= 255))

  
	) 
	{	$ip_iknock = "Y";  	}
}


switch ($REQUEST_METHOD) {
	case "GET":
		$timestamp = date('U');
		if($id === false) WebApp::moveBack('글이 존재하지 않습니다');
		$data = $DB->sqlFetch("SELECT * FROM $ARTICLE_TABLE WHERE  $que num_mcode=$mcode AND num_serial=$id");
		if (!$data) WebApp::moveBack('해당 글이 존재하지 않습니다');
		@_format_data(&$data);

		$tpl->assign('re','<td width="40">[Re]:</td>');



//2008-06-24 종태 카테고리 목록

$sql = "select distinct str_category from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('cate_LIST'=>$row));


		if($mcode >= "900000") {
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/write_900000.htm"));			
		}else{
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/write.htm"));
		}

        
		

if($mcode >= 90000) {


$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/write.htm"));


$tpl->assign(array('hidden_s2'=> "<!--",'hidden_e2'=> "-->",));	


if($_OID == $data['num_oid'])
	
{ $tpl->assign(array('hidden_s'=> "",'hidden_e'=> "",)); 

}else{   
	
$tpl->assign(array('hidden_s'=> "<!--",'hidden_e'=> "-->",));	

}



	// 아이피 체크 2007-06-21 종태
# (회사 IP인지 체크)

    $REMOTE_ADDR;
    if(!$REMOTE_ADDR) $REMOTE_ADDR = getenv('REMOTE_ADDR');

	$except = array('1');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	//if ($ipbase == '125.7.178' && ($iptail >= 1 && $iptail <= 50)) return (!in_array($iptail,$except));
	if (
  ($ipbase == '61.250.141' && ($iptail >= 1 && $iptail <= 100))
  or($ipbase == '218.237.157' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.104.150' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '124.199.149' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.214.160' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '218.37.42' && ($iptail >= 1 && $iptail <= 255))
  
	) 
	{ $tpl->assign(array('hidden_s'=> "",'hidden_e'=> "",'hidden_s2'=> "",'hidden_e2'=> "",)); 
	}




}



		WebApp::call('_titlebar',array('title'=>$TITLE));
		$tpl->assign($data);
		$tpl->assign(array(
			'id'=>$id,
			'mcode'=>$mcode,
			'env'=>$env
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
		$str_text = $FH->get_content($_POST['content']);
		
	if(strstr($_POST['content'], "SCRIPT")) {
			WebApp::moveBack('본문중 스크립트가 포함돼어있습니다. 글을 등록할수 없습니다.');
		}
			if(strstr($_POST['content'] ,"SCRIPT")) {
			WebApp::moveBack('본문중 스크립트가 포함돼어있습니다. 글을 등록할수 없습니다.');
		}

		list($str1,$str2,$str3) = WebApp::content_split($str_text);	// 앞에서부터 3개 이하는 버림!
		$use_html = $_POST['use_html'];
		if (!$use_html) $use_html = 'Y';
        $num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : 0;
        $dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';
		
		$ip = getenv('REMOTE_ADDR');
	
		if($ip_iknock) {
		
		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text1, str_text2, str_text3, chr_html, dt_date, str_ip, num_hit ,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10)
			VALUES
				(1,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$use_html', $dt_date,'$ip', $num_hit, '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10')
			";
		}else{
		
		$sql = 
			"INSERT INTO $ARTICLE_TABLE
				(num_oid, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
					str_email, str_title, str_text1, str_text2, str_text3, chr_html, dt_date, str_ip, num_hit,str_category,str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10)
			VALUES
				($oid,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', '$email','$title','$str1','$str2','$str3','$use_html', $dt_date,'$ip', $num_hit,'$str_category', '$str_tmp2', '$str_tmp3', '$str_tmp4', '$str_tmp5', '$str_tmp6',  '$str_tmp7', '$str_tmp8', '$str_tmp9', '$str_tmp10')
			";
		
		}
			
		if ($DB->query($sql)) {
			$DB->commit();


		//2008-07-07 회원 포인트 값
		$plus_point = "num_repaly_point";
		$sql = "select $plus_point from TAB_BOARD_CONFIG where num_oid = '$_OID' and num_mcode = '$mcode' ";
		if($chw = $DB -> sqlFetchOne($sql) < 1){
		$sql = "select $plus_point from TAB_ORGAN where num_oid = '$_OID' ";
		$chw = $DB -> sqlFetchOne($sql);
		}

		
		$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
		$DB->query($sql);
		$DB->commit();


			// {{{ 업로드한 파일 처리
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
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
					$que num_mcode=$mcode AND num_serial=$serial
			")) $DB->commit();

            if($env['use_recent']) {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
            }

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
