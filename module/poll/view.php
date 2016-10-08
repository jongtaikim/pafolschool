<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: view.php
* 작성일: 2005-03-24
* 작성자: 이범민
* 설  명: 투표 및 투표결과보기
*****************************************************************
* TODO : 권한체크
*/


if(!$id) WebApp::raiseError('잘못된 요청입니다.');

// 날짜 유효성(투표가능여부)
$DB = &WebApp::singleton('DB');
$sql = "SELECT
STR_TITLE,
DT_START_DATE as DT_START,
DT_FINISH_DATE as DT_FINISH,
CHR_CHECK,
CHR_RESULT,
STR_POLL_GROUP
FROM ".TAB_POLL_MAIN."
WHERE
NUM_OID=$_OID AND
NUM_SERIAL=$id";
if(!$data = $DB->sqlFetch($sql)) WebApp::raiseError('데이타가 존재하지 않습니다.');
$today = mktime();
if($data['dt_start'] <= $today && $data['dt_finish'] >= $today) $data['use_poll'] = true;


//echo $data['dt_start']."|".$data['dt_finish']."|".$today;

switch($REQUEST_METHOD) {
case "GET":

		if(!$mcode) {
			$DB = &WebApp::singleton("DB");
			$sql = "select num_mcode from TAB_MENU where num_oid = '$_OID' and str_type = 'poll' and num_mcode not like '".$OFFICE_MCODE."%'";
			$mcode_meta = $DB -> sqlFetchOne($sql);	
			if($mcode_meta) {
				if(!$id) {
					echo "<meta http-equiv='Refresh' Content=\"0; URL='".$act."?mcode=$mcode_meta'\">";
					exit;		
				}else{
					echo "<meta http-equiv='Refresh' Content=\"0; URL='".$act."?mcode=$mcode_meta&id=$id'\">";
					exit;	
				}
			}
		}

	// 진행중 결과보기
		//if(trim($data['chr_result']) == 'e') {
			$sql = "SELECT * FROM ".TAB_POLL_CONTENTS."
					WHERE NUM_OID=$_OID AND NUM_MAIN=$id";
			// 총 투표수 계산
			if($DB->query($sql)) {
				while($crow = $DB->fetch()) {
					$data['total_num'] += $crow['num_vote'];
					$data['LIST'][] = $crow;
				}
			} else {
				$data['total_num'] = 0;
			}
			// 투표율 계산
			foreach($data['LIST'] as $key => $crow) {
				if($crow['num_vote']>0) {
					$data['LIST'][$key]['rate'] = number_format($crow['num_vote']/$data['total_num']*100);
				} else {
					$data['LIST'][$key]['rate'] = 0;
				}
			}
		//}

		// 나도한마디
		$sql = "SELECT NUM_MAIN,NUM_SERIAL,STR_COMMENT,STR_NAME, DT_DATE , TO_CHAR(DT_DATE,'HH24:MI:SS') as DT_DATE2 ,STR_IP
				FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$id";
		if($DB->query($sql)) {
			while($row = $DB->fetch()) {
				// 태그제거
				$row['str_comment'] = $row['str_comment'];
				$data['COMMENT_LIST'][] = $row;
			}
		}
		$data['NAME'] = $_SESSION['NAME'];
		$data['USERID'] = $_SESSION['USERID'];
		$data['sect'] = $sect;
		$data['id'] = $id;

		$tpl->setLayout();
		$tpl->define('CONTENT','html/poll/skin/'.$skin.'/view.htm');
		$tpl->assign($data);

		$tpl->assign(array('type2'=>$type,'mcode'=>$mcode));
		
		
	break;
	case "POST":
		if(!$cid) {
			WebApp::moveBack('설문을 선택해주세요.');
		}

		if($data['use_poll']) {
			if(trim($data['chr_check']) == 'id') {
				// ID 중복검사
				if($_SESSION['USERID']) {
					if(_OID == _AOID) $userid = $_SESSION['SES_ORGAN_OID'].".".$_SESSION['USERID'];
					else $userid = $_SESSION['USERID'];

					$sql = "SELECT COUNT(STR_USER) FROM ".TAB_POLL_USER."
							WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND STR_USER='".$userid."'";
					if(intval($DB->sqlFetchOne($sql))<1) {
						$sql_insert =	"INSERT INTO ".TAB_POLL_USER." (NUM_OID,NUM_MAIN,STR_USER)".
										"VALUES ($_OID,$id,'".$userid."')";
					}

				}
			} elseif(trim($data['chr_check']) == 'ip') {
				// IP 중복검사
				$sql = "SELECT COUNT(STR_IP) FROM ".TAB_POLL_IP."
						WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND STR_IP='".getenv('REMOTE_ADDR')."'";
				if(intval($DB->sqlFetchOne($sql))<1) {
					$sql_insert =	"INSERT INTO ".TAB_POLL_IP." (NUM_OID,NUM_MAIN,STR_IP)".
									"VALUES ($_OID,$id,'".getenv('REMOTE_ADDR')."')";
				}

			} elseif(trim($data['chr_check']) == 'mt') {
				// 회원권한체크

				$str_poll_group = explode(",",$data['str_poll_group']);
				if (!in_array($_SESSION['CHR_MTYPE'], $str_poll_group)){
					WebApp::moveBack('투표권한이 없습니다.');
				}

				if($_SESSION['USERID']) {
					if(_OID == _AOID) $userid = $_SESSION['SES_ORGAN_OID'].".".$_SESSION['USERID'];
					else $userid = $_SESSION['USERID'];

					$sql = "SELECT COUNT(STR_USER) FROM ".TAB_POLL_USER."
							WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND STR_USER='".$userid."'";
					if(intval($DB->sqlFetchOne($sql))<1) {
						$sql_insert =	"INSERT INTO ".TAB_POLL_USER." (NUM_OID,NUM_MAIN,STR_USER)".
										"VALUES ($_OID,$id,'".$userid."')";
					}
				}

			} elseif(trim($data['chr_check']) == 'cd') {
				//인증코드 체크
				$str_poll_group = explode(",",$data['str_poll_group']);
				if (!in_array($Fcode, $str_poll_group)){
					WebApp::moveBack('인증코드가 맞지않습니다.');
				}

				$sql = "SELECT COUNT(STR_IP) FROM ".TAB_POLL_CODE."
						WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND STR_CODE='".$Fcode."'";
				if(intval($DB->sqlFetchOne($sql))<1) {
					$sql_insert =	"INSERT INTO ".TAB_POLL_CODE." (NUM_OID,NUM_MAIN,STR_CODE)".
									"VALUES ($_OID,$id,'".$Fcode."')";
				}
			}
		}

		// 투표반영
		if($sql_insert) {
			if($DB->query($sql_insert)) {
				$DB->commit();

				$sql = "UPDATE ".TAB_POLL_CONTENTS." SET NUM_VOTE=NUM_VOTE+1
						WHERE NUM_OID=$_OID AND NUM_MAIN=$id AND NUM_SERIAL=$cid";
				$DB->query($sql);
				$DB->commit();
			}
		
			echo '<script>alert("성공적으로 반영되었습니다.");</script>';
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/poll.list?mcode=$mcode&type=$type2'\">";

		}else{
		
			echo '<script>alert("이미 투표하신 항목입니다.");</script>';
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/poll.list?mcode=$mcode&type=$type2'\">";

		}


	break;
}
?>