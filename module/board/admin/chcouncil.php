<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: chcouncil.php
* 작성일: 2004-10-06
* 작성자: 이범민
* 설  명: 게시판 자료를 상담실 자료로 이전
*****************************************************************
* 
*/
if(!$mcode) WebApp::moveBack("잘못된 요청입니다.");

switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout();
		$tpl->define("CONTENT","html/admin/board/chcouncil.htm");
		$tpl->parse("CONTENT");
	break;
	case "POST":
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><center>게시판 변경작업중입니다.<br>잠시만 기다려 주십시오.</center><br>";

		//echo "<xmp>";
		$DB = &WebApp::singleton("DB");

		// 게시판 설정파일 가져오기
		$sql_conf = "SELECT * FROM TAB_BOARD_CONFIG WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		if(!$data_conf = $DB->sqlFetch($sql_conf)) {
			WebApp::moveBack("게시판 설정 자료가 존재하지 않습니다.");
		}
		
		// {{{ Council Config 저장
		$sql = make_sql_conf($data_conf);
		if(!$DB->query($sql)) {
			WebApp::moveBack("상담실 설정 DB 저장중 오류가 발생했습니다.");
		}
		$DB->commit();
		// }}}

		// 게시판 데이터 가져오기
		$sql_data = "SELECT
						NUM_OID,
						NUM_MCODE,
						NUM_SERIAL,
						NUM_GROUP,
						NUM_STEP,
						NUM_DEPTH,
						STR_USER,
						STR_NAME,
						STR_EMAIL,
						STR_TITLE,
						STR_TEXT1,
						STR_TEXT2,
						STR_TEXT3,
						CHR_HTML,
						TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
						NUM_HIT,
						NUM_FILE,
						STR_IP
					FROM TAB_BOARD
					WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		if($data = $DB->sqlFetchAll($sql_data)) {
			flush();
			$i=0;
			foreach($data as $row) {
				// 최상위글의 user_id 가져오기(for tab_council.str_ouser)
				$sql = "SELECT /*+ INDEX_DESC (TAB_BOARD IDX_TAB_BOARD_SEARCH) */ STR_USER FROM TAB_BOARD WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND NUM_GROUP=".$row['num_group']." AND ROWNUM=1";
				$data[$i]['str_ouser'] = $row['str_ouser'] = $DB->sqlFetchOne($sql);
				// Council 테이블에 저장
				$sql = make_sql_data($row);
				//echo $sql."\n";
				if($DB->query($sql)) {
					$DB->commit();
				} else {
					$error_data[] = "http://$HOST/?act=board.read&mcode=$mcode&id=".$row['num_serial'];
				}
				$i++;
				echo "■";
				usleep(100);
				flush();
			}

			// {{{ COMMENT 데이타를 답글로 전환
			foreach($data as $row) {
				$sql = "SELECT 
							NUM_OID,NUM_MCODE,NUM_MAIN,NUM_SERIAL,STR_USER,STR_NAME,STR_PASS,STR_COMMENT,TO_CHAR(DT_DATE,'YYYY-MM-DD') AS DT_DATE,STR_IP
						FROM TAB_BOARD_COMMENT 
						WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND NUM_MAIN=".$row['num_serial'];
				if ($data_comm = $DB->sqlFetchAll($sql)) {
					foreach($data_comm as $comm) {
						$comm['num_serial'] = $DB->sqlFetchOne("SELECT /*+ INDEX_DESC (TAB_COUNCIL PK_TAB_COUNCIL) */ NUM_SERIAL FROM TAB_COUNCIL WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND ROWNUM=1") + 1;
						$comm['num_group'] = $row['num_group'];
						$comm['num_depth'] = (int)$row['num_depth'] + 1;
						$comm['num_step'] = (int)$row['num_step'] - 1;
						$comm['str_ouser'] = $row['str_ouser'];
						$comm['str_title'] = $row['str_title'];

						$DB->query("UPDATE TAB_COUNCIL SET num_step=num_step-1 WHERE num_oid=$_OID AND num_mcode=$mcode AND num_group=".$row['num_group']." AND num_step<".$row['num_step']);
						$DB->commit();
						$sql = make_sql_comm($comm);
						//echo $sql."\n";
						if($DB->query($sql)) {
							$DB->commit();
						} else {
							$error_data[] = "http://$HOST/?act=board.read&mcode=$mcode&id=".$row['num_serial']." 의 코멘트";
						}
						echo "■";
						usleep(100);
						flush();
					}
				}
			}
			// }}}

			// {{{ 첨부파일 자료 옮기기
			$sql_files = "SELECT * FROM TAB_BOARD_FILES WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			if($data_files = $DB->sqlFetchAll($sql_files)) {
				$sql = "INSERT INTO TAB_COUNCIL_FILES 
						(NUM_OID,NUM_MCODE,NUM_MAIN,NUM_SERIAL,STR_UPFILE,STR_REFILE,NUM_DOWN,NUM_SIZE) 
						SELECT * FROM TAB_BOARD_FILES WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
				$DB->query($sql);
				$DB->commit();
			}
			echo "■";
			usleep(100);
			flush();
			// }}}
		} else {
			$sql = "DELETE FROM TAB_COUNCIL_CONFIG WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			$DB->query($sql);
			$DB->commit();
			WebApp::moveBack("게시판에 데이타가 존재하지 않습니다.\n현재 메뉴를 삭제하시고\n상담실을 새로 생성하시기 바랍니다.");
		}
		//die();

		// {{{ Config 파일 내리기
		//include "module/admin/council/inc.saveconf.php";
        Webapp::call('counsil.admin.saveconf');
		echo "■";
		usleep(100);
		flush();
		// }}}

		// {{{ Menu Type 변경
		$sql = "UPDATE TAB_MENU SET CHR_TYPE='C' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		$DB->query($sql);
		$DB->commit();
		echo "■";
		// }}}

		// {{{ menu.xml 파일 업데이트
		include "module/admin/menu/inc.xmlsave.php";
		echo "■";
		usleep(100);
		flush();
		// }}}

		// {{{ inc.side.htm 파일 업데이트
		include "module/admin/side/inc.xmlsave.php";
		echo "■";
		usleep(100);
		flush();
		// }}}

		// {{{ 게시판 자료 지우기
		$sql = "DELETE FROM TAB_BOARD_CONFIG WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		$DB->query($sql);
		$sql = "DELETE FROM TAB_BOARD WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		$DB->query($sql);
		$sql = "DELETE FROM TAB_BOARD_COMMENT WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		$DB->query($sql);
		$sql = "DELETE FROM TAB_BOARD_FILES WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		$DB->query($sql);
		echo "■";
		usleep(100);
		flush();
		$DB->commit();
		if(!$FTP->conn) {
			$ftp_host = WebApp::getConf('account.host');
			$ftp_user = WebApp::getConf('account.user');
			$ftp_pass = WebApp::getConf('account.pass');
			$FTP->connect($ftp_host,$ftp_user,$ftp_pass);
		}
		$FTP->delete(_DOC_ROOT."/hosts/$HOST/conf/board/$mcode.conf.php");
		// }}}
		
		WebApp::alert("변경작업이 완료되었습니다.\n 메뉴 권한설정을 다시 조정하시기 바랍니다.");
		WebApp::redirect("/?act=admin.menu.option&mcode=$mcode");
		//print_r($error_data);
	break;
}


function make_sql_conf($arr) {
	extract($arr);
	$DB = &WebApp::singleton("DB");
	$sql = "INSERT INTO TAB_COUNCIL_CONFIG (
				NUM_OID,
				NUM_MCODE,
				STR_TITLE,
				STR_OPERATORS,
				STR_SKIN,
				NUM_LISTNUM,
				NUM_NAVNUM,
				NUM_TITLELEN,
				CHR_ODDCOLOR,
				CHR_EVENCOLOR
			) VALUES (
				$num_oid,
				$num_mcode,
				'$str_title',
				'',
				'default',
				$num_listnum,
				$num_navnum,
				$num_titlelen,
				'$chr_oddcolor',
				'$chr_evencolor'
			)";
	return $sql;
}
function make_sql_data($arr) {
	extract($arr);
	$sql = "INSERT INTO TAB_COUNCIL (
				NUM_OID,
				NUM_MCODE,
				NUM_SERIAL,
				NUM_GROUP,
				NUM_STEP,
				NUM_DEPTH,
				STR_USER,
				STR_OUSER,
				STR_NAME,
				STR_EMAIL,
				STR_TITLE,
				STR_TEXT1,
				STR_TEXT2,
				STR_TEXT3,
				CHR_HTML,
				DT_DATE,
				NUM_HIT,
				NUM_FILE,
				NUM_PUBLIC,
				CHR_METHOD,
				STR_IP
			) VALUES (
				$num_oid,
				$num_mcode,
				$num_serial,
				$num_group,
				$num_step,
				$num_depth,
				'$str_user',
				'$str_ouser',
				'$str_name',
				'$str_email',
				'$str_title',
				'$str_text1',
				'$str_text2',
				'$str_text3',
				'$chr_html',
				TO_DATE('$dt_date','YYYY-MM-DD'),
				$num_hit,
				$num_file,
				0,
				'B',
				'$str_ip'
			)";
	return $sql;
}

function make_sql_comm($arr) {
	extract($arr);
	$sql = "INSERT INTO TAB_COUNCIL (
				NUM_OID,
				NUM_MCODE,
				NUM_SERIAL,
				NUM_GROUP,
				NUM_STEP,
				NUM_DEPTH,
				STR_USER,
				STR_OUSER,
				STR_NAME,
				STR_EMAIL,
				STR_TITLE,
				STR_TEXT1,
				STR_TEXT2,
				STR_TEXT3,
				CHR_HTML,
				DT_DATE,
				NUM_HIT,
				NUM_FILE,
				NUM_PUBLIC,
				CHR_METHOD,
				STR_IP
			) VALUES (
				$num_oid,
				$num_mcode,
				$num_serial,
				$num_group,
				$num_step,
				$num_depth,
				'$str_user',
				'$str_ouser',
				'$str_name',
				'',
				'$str_title',
				'$str_comment',
				'',
				'',
				'Y',
				TO_DATE('$dt_date','YYYY-MM-DD'),
				0,
				0,
				0,
				'B',
				'$str_ip'
			)";
	return $sql;
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}
?>
