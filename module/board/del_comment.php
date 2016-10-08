<?
/**************************************
* 파일명: del_comment.php
* 작성일: 2002-12-26
* 작성자: 거친마루
* 설  명: 코멘트 삭제
***************************************/

// 요거 좀 만져야 한다. -ㅛ-;;

$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];
$main = $_REQUEST['main'];
$DB = &WebApp::singleton('DB');

	$sql = "select str_user,  dt_date from $COMMENT_TABLE where num_oid = $_OID and num_mcode = $mcode and num_main=$main AND num_serial=$id ";
	$odata = $DB -> sqlFetch($sql);
	
	$str_id = $odata[str_user];
	$tpl->assign(array('str_id'=>$str_id));
	

$que = " num_oid = '$_OID' and ";


if ($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
if ($pass) {


	$data = $DB->sqlFetch("SELECT str_pass, str_user FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
	if ($pass != $data['str_pass']) WebApp::moveBack("패스워드가 일치하지 않습니다");

	$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id";

	if ($DB->query($sql)) {
		$DB->commit();
		$DB->query("
			UPDATE $ARTICLE_TABLE SET
				num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode AND num_main=$main)
			WHERE $que num_mcode=$mcode AND num_serial=$main
		");
		$DB->commit();

		//2008-11-10 현민 - 신규글, 댓글 삭제시 포인트 소진
		if($data[str_user]){
			
			$plus_point = "num_commint_point";

			$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
			$chw = $DB -> sqlFetchOne($sql);

			//2008-11-10 현민 - 게시글 등록시 포인트는 하루에 2건만으로 제한.
			$cdate = $data[dt_date];
			$sdate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2),substr($cdate,0,4)));
			$edate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2)+1,substr($cdate,0,4)));

			$sql = "select count(*) from $COMMENT_TABLE where num_oid = $_OID and str_user = '".$data[str_user]."' and TO_CHAR(dt_date,'YYYY-MM-DD') between '$sdate' and '$edate'";
			$bcnt = $DB -> sqlFetchOne($sql);

			if($bcnt <= 1){	//게시글이 한개는 위에서 삭제됐으므로, 한개 이하가 남았을경우는 포인트 소진시킴. (두개이상은 어차피 포인트 쌓이지 않았음.)
				$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point -1 , num_point_total = num_point_total - $chw WHERE num_oid=$_OID AND str_id='".$data[str_user]."'";
				$DB->query($sql);
				$DB->commit();
			}

		}

		$URL->delVar('main');
		WebApp::redirect($URL->setVar(array('act'=>'board.read','id'=>$main)));
	} else {
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	$data = array(id=>$id,page=>$page);

	if ($env['admin'] || $_SESSION[ADMIN_sub]) {
		$message = "나도 한마디를 삭제합니다.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/admin_del_confirm.htm"));
		$tpl->assign('pass',$pass);
	} else {
		if($str_id == $_SESSION[USERID]){
			$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id";
			if ($DB->query($sql)) {
				$DB->commit();

				$sch_data[str_url] = "/board.view?mcode=".$mcode."&id=".$main.'&comment='.$id;
				$DB->deleteQuery("TAB_SCH"," num_oid = "._OID." and str_url = '".$sch_data[str_url]."'");
				$DB->commit();


				$DB->query("
					UPDATE $ARTICLE_TABLE SET
						num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode AND num_main=$main)
					WHERE $que num_mcode=$mcode AND num_serial=$main
				");
				$DB->commit();

				//2008-11-10 현민 - 신규글, 댓글 삭제시 포인트 소진
				if($_SESSION['USERID']){
					
					$plus_point = "num_commint_point";

					$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
					$chw = $DB -> sqlFetchOne($sql);

					//2008-11-10 현민 - 게시글 등록시 포인트는 하루에 2건만으로 제한.
					$cdate = $odata[dt_date];
					$sdate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2),substr($cdate,0,4)));
					$edate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2)+1,substr($cdate,0,4)));

					$sql = "select count(*) from $COMMENT_TABLE where num_oid = $_OID and str_user = '".$_SESSION['USERID']."' and TO_CHAR(dt_date,'YYYY-MM-DD') between '$sdate' and '$edate'";
					$bcnt = $DB -> sqlFetchOne($sql);

					if($bcnt <= 1){	//게시글이 한개는 위에서 삭제됐으므로, 한개 이하가 남았을경우는 포인트 소진시킴. (두개이상은 어차피 포인트 쌓이지 않았음.)
						$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point -1 , num_point_total = num_point_total - $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
						$DB->query($sql);
						$DB->commit();
					}

				}

				$URL->delVar('main');
				WebApp::redirect($URL->setVar(array('act'=>'board.read','id'=>$main)));
			}

		}else{
			$message = "나도 한마디를 삭제하시려면 작성시 입력하셨던 패스워드를 입력하세요";
			$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/pass.htm"));
			$tpl->assign($data);

		}
	}
	$tpl->assign(array(
		'mcode'=>$mcode,
		'main'=>$main,
		'id'=>$id,
		'message'=>$message
	));
}
?>
