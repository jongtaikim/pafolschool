<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/read.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'r');

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);

$sql = "SELECT
            num_pcode,
			num_mcode AS mcode, 
			num_serial AS serial,
			num_group,
			num_step,
			str_user,
			str_ouser,
			str_name AS name,
			str_email AS email, 
			str_title AS title, 
			str_text1, 
			str_text2,
			str_text3,
			chr_html AS use_html, 
			TO_CHAR(dt_date,'YYYY-MM-DD') AS reg_date, 
			num_hit AS hit, 
			num_file, 
			str_ip AS remote_addr, 
			num_public, 
			chr_method
		FROM
			".TAB_PARTY_COUNCIL."
		WHERE
			num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
$data = $DB->sqlFetch($sql);
// 접근권한체크 (중요!!! : 관리자인지 체크,id 체크,공개글인지체크,읽기권한 체크)
if(!$env['admin'] && (!$_SESSION['USERID'] || $data['str_ouser'] != $_SESSION['USERID'])) {
	if( !$data['num_public'] || !$PERM->check('party',$pcode.'.'.$mcode,'r')) WebApp::moveBack("권한이 없습니다.");
}
@_format_data(&$data);

$data['content'] = $FH->set_content($data['content']);
$DB->query("UPDATE ".TAB_PARTY_COUNCIL." SET num_hit=num_hit+1 WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
$DB->commit();

if ($data['chr_html'] == 'N') html2txt($data['content']);
if ($data['str_email']) $data['name'] = "<a href='mailto:$data[str_email]'>".$data['name']."</a>";

// {{{ 이전글,다음글 (2004-08-25)
	$search_key = $_REQUEST['search_key'];
	$search_value = $_REQUEST['search_value'];
	if($search_key && $search_value) {
		if(substr($search_key,0,3) != "num") {
			$whereadd = "AND $search_key LIKE '$search_value%'";
		} else {
			$whereadd = "AND $search_key = $search_value";
		}
	}
	$group = $data['num_group'];
	$step = $data['num_step'];

	if($env['admin']) {
		// {{{ 관리자인 경우 쿼리
		$sql_next = "SELECT
						/*+ INDEX (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
						ROWNUM AS RNUM,NUM_SERIAL,STR_TITLE
					FROM
						".TAB_PARTY_COUNCIL."
					WHERE
						num_oid=$_OID AND
                        num_pcode=$pcode AND 
						num_mcode=$mcode AND
                        num_notice < 1 AND
						((num_group>$group) OR (num_group=$group AND num_step>$step))
						$whereadd
						AND ROWNUM=1";
		$sql_prev = "SELECT
						/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
						ROWNUM AS RNUM,num_serial,str_title
					FROM
						".TAB_PARTY_COUNCIL."
					WHERE
						num_oid=$_OID AND
                        num_pcode=$pcode AND
						num_mcode=$mcode AND
                        num_notice < 1 AND
						((num_group<$group) OR (num_group=$group AND num_step<$step))
						$whereadd
						AND ROWNUM=1";
		// }}}
	} else {
		if($PERM->check('party',$pcode.'.'.$mcode,'r')) {
			// 읽기권한이 있을경우 공개글과 자신의 글 열람
			$where_public = $_SESSION['USERID'] ? "AND (num_public=1 OR str_ouser='".$_SESSION['USERID']."')" : "AND num_public=1";
		} else {
			// 읽기권한이 없을경우 자신의 글만 열람
			$where_public = $_SESSION['USERID'] ? "AND str_ouser='".$_SESSION['USERID']."'" : "";
		}

		// {{{ 관리자가 아닌경우 쿼리
		$sql_next = "SELECT 
						/*+ INDEX (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
						num_serial,str_title
					FROM ".TAB_PARTY_COUNCIL."
					WHERE 
						num_oid=$_OID AND
                        num_pcode=$pcode AND
						num_mcode=$mcode AND
                        num_notice < 1 AND
						num_group IN
							(SELECT num_group
							FROM ".TAB_PARTY_COUNCIL." 
							WHERE 
								num_oid=$_OID AND
                                num_pcode=$pcode AND
								num_mcode=$mcode AND
								num_depth=0
								$where_public
							)
						AND ((num_group>$group) OR (num_group=$group AND num_step>$step))
						$whereadd
						AND ROWNUM=1";
		$sql_prev = "SELECT 
						/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
						num_serial,str_title
					FROM ".TAB_PARTY_COUNCIL."
					WHERE 
						num_oid=$_OID AND
                        num_pcode=$pcode AND
						num_mcode=$mcode AND
                        num_notice < 1 AND
						num_group IN
							(SELECT num_group
							FROM ".TAB_PARTY_COUNCIL." 
							WHERE 
								num_oid=$_OID AND
                                num_pcode=$pcode AND
								num_mcode=$mcode AND
								num_depth=0
								$where_public
							)
						AND ((num_group<$group) OR (num_group=$group AND num_step<$step))
						$whereadd
						AND ROWNUM=1";
		// }}}
	}

	if($next_data = $DB->sqlFetch($sql_next)) {
		$nextlink = "<a href='".$URL->alterVar(array("act"=>$act,"id"=>$next_data['num_serial']))."'>".$next_data['str_title']."</a>";
	} else {
		$nextlink = "<font color='#AAAAAA'>다음글이 없습니다.</font>";
	}
	if($prev_data = $DB->sqlFetch($sql_prev)) {
		$prevlink = "<a href='".$URL->alterVar(array("act"=>$act,"id"=>$prev_data['num_serial']))."'>".$prev_data['str_title']."</a>";
	} else {
		$prevlink = "<font color='#AAAAAA'>이전글이 없습니다.</font>";
	}
// }}}

if ($data['num_file'] > 0) {
	$fdata = $FH->get_files_info($id);
	$total_size = array_pop($fdata);
} else {
	$total_size = 0;
}

$tpl->setLayout('sub');
$tpl->define("CONTENT","/html/party/council/skin/${skin}/read.htm");
$tpl->assign(array(
	'env'=>$env,
	'FILE_LIST'=>$fdata,
	'total_size'=>$total_size,
    'nextlink'=>$nextlink,
    'prevlink'=>$prevlink
));
$tpl->assign($data);
$tpl->parse("CONTENT");

#### Functions ####
function html2txt(&$str) {
	$str = str_replace(array("&","<",">","\n"),array("&amp;","&lt;","&gt;"," <br>\n"),$str);
}

function _format_data(&$arr) {
	global $publicArr,$methodArr;
	$arr['name'] = &$arr['name'];
	$arr['title'] = strip_tags(&$arr['title']);
	$arr['content'] = $arr['str_text1'].$arr['str_text2'].$arr['str_text3'];
	$arr['public'] = $publicArr[$arr['num_public']];
	$arr['method'] = $methodArr[$arr['chr_method']];
}

function allow_tags(&$str,$allow="b|i|font") {	//특정 태그만 허용
	if (is_array($allow)) $allow = implode("|",$allow);
	$str = preg_replace("/<(\/?)(?!\/|$allow)([^<>]*)?>/i", "&lt;\\1\\2&gt;", $str);
	return $str;
}
?>