<?
/**************************************
* ���ϸ�: del_comment.php
* �ۼ���: 2002-12-26
* �ۼ���: ��ģ����
* ��  ��: �ڸ�Ʈ ����
***************************************/

// ��� �� ������ �Ѵ�. -��-;;

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


if ($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
if ($pass) {


	$data = $DB->sqlFetch("SELECT str_pass, str_user FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
	if ($pass != $data['str_pass']) WebApp::moveBack("�н����尡 ��ġ���� �ʽ��ϴ�");

	$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id";

	if ($DB->query($sql)) {
		$DB->commit();
		$DB->query("
			UPDATE $ARTICLE_TABLE SET
				num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode AND num_main=$main)
			WHERE $que num_mcode=$mcode AND num_serial=$main
		");
		$DB->commit();

		//2008-11-10 ���� - �űԱ�, ��� ������ ����Ʈ ����
		if($data[str_user]){
			
			$plus_point = "num_commint_point";

			$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
			$chw = $DB -> sqlFetchOne($sql);

			//2008-11-10 ���� - �Խñ� ��Ͻ� ����Ʈ�� �Ϸ翡 2�Ǹ����� ����.
			$cdate = $data[dt_date];
			$sdate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2),substr($cdate,0,4)));
			$edate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2)+1,substr($cdate,0,4)));

			$sql = "select count(*) from $COMMENT_TABLE where num_oid = $_OID and str_user = '".$data[str_user]."' and TO_CHAR(dt_date,'YYYY-MM-DD') between '$sdate' and '$edate'";
			$bcnt = $DB -> sqlFetchOne($sql);

			if($bcnt <= 1){	//�Խñ��� �Ѱ��� ������ ���������Ƿ�, �Ѱ� ���ϰ� ���������� ����Ʈ ������Ŵ. (�ΰ��̻��� ������ ����Ʈ ������ �ʾ���.)
				$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point -1 , num_point_total = num_point_total - $chw WHERE num_oid=$_OID AND str_id='".$data[str_user]."'";
				$DB->query($sql);
				$DB->commit();
			}

		}

		$URL->delVar('main');
		WebApp::redirect($URL->setVar(array('act'=>'board.read','id'=>$main)));
	} else {
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	$data = array(id=>$id,page=>$page);

	if ($env['admin'] || $_SESSION[ADMIN_sub]) {
		$message = "���� �Ѹ��� �����մϴ�.";
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

				//2008-11-10 ���� - �űԱ�, ��� ������ ����Ʈ ����
				if($_SESSION['USERID']){
					
					$plus_point = "num_commint_point";

					$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
					$chw = $DB -> sqlFetchOne($sql);

					//2008-11-10 ���� - �Խñ� ��Ͻ� ����Ʈ�� �Ϸ翡 2�Ǹ����� ����.
					$cdate = $odata[dt_date];
					$sdate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2),substr($cdate,0,4)));
					$edate = date("Y-m-d",mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2)+1,substr($cdate,0,4)));

					$sql = "select count(*) from $COMMENT_TABLE where num_oid = $_OID and str_user = '".$_SESSION['USERID']."' and TO_CHAR(dt_date,'YYYY-MM-DD') between '$sdate' and '$edate'";
					$bcnt = $DB -> sqlFetchOne($sql);

					if($bcnt <= 1){	//�Խñ��� �Ѱ��� ������ ���������Ƿ�, �Ѱ� ���ϰ� ���������� ����Ʈ ������Ŵ. (�ΰ��̻��� ������ ����Ʈ ������ �ʾ���.)
						$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point -1 , num_point_total = num_point_total - $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
						$DB->query($sql);
						$DB->commit();
					}

				}

				$URL->delVar('main');
				WebApp::redirect($URL->setVar(array('act'=>'board.read','id'=>$main)));
			}

		}else{
			$message = "���� �Ѹ��� �����Ͻ÷��� �ۼ��� �Է��ϼ̴� �н����带 �Է��ϼ���";
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
