<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/list.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'l');

$DB = &WebApp::singleton('DB');

$page = $_REQUEST['page'];
if (!$page) $page = 1;
$listnum = 10;
$navmum = 10;
$dateformat = "Y-m-d";

$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];
if($search_key && $search_value) {
	if(substr($search_key,0,3) != "num") {
		$whereadd = "AND $search_key LIKE '$search_value%'";
	} else {
		$whereadd = "AND $search_key = $search_value";
	}
}
$offset = $listnum * ($page - 1);

if($env['admin']) {
	// {{{ �������� ��� ����
	$sql_total = "SELECT COUNT(*) FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_mcode=$mcode $whereadd";
	$sql = "SELECT 
				*
			FROM
				(SELECT
					/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
					ROWNUM AS RNUM,
					num_oid,
					num_mcode,
					num_serial,
                    num_notice,
					num_depth,
					str_title,
					str_name,
					str_user,
					str_email,
					num_hit,
					num_public,
					TO_CHAR(dt_date,'YYYY-MM-DD') dt_date
				FROM
					".TAB_PARTY_COUNCIL."
				WHERE
					num_oid=$_OID AND
					num_mcode=$mcode AND
					ROWNUM<=".($offset + $listnum)."
					$whereadd)
			WHERE RNUM>$offset";
	// }}}
} else {
	if($PERM->check('party',$pcode.'.'.$mcode,'r')) {
		// �б������ ������� �����۰� �ڽ��� �� ����
		$where_public = $_SESSION['USERID'] ? "AND (num_public=1 OR str_ouser='".$_SESSION['USERID']."')" : "AND num_public=1";
	} else {
		// �б������ ������� �ڽ��� �۸� ����
		$where_public = $_SESSION['USERID'] ? "AND str_ouser='".$_SESSION['USERID']."'" : "";
	}

	// {{{ �����ڰ� �ƴѰ�� ����
	$sql_total = "	SELECT COUNT(*) FROM ".TAB_PARTY_COUNCIL."
					WHERE
						num_oid=$_OID AND
						num_mcode=$mcode
						$where_public
						$whereadd";
	$sql = "SELECT * FROM
				(SELECT 
					/*+ INDEX_DESC (".TAB_PARTY_COUNCIL." ".IDX_TAB_PARTY_COUNCIL_SEARCH.") */
					ROWNUM AS RNUM,
					num_oid,
                    num_pcode,
					num_mcode,
					num_serial,
                    num_notice,
					num_group,
					num_depth,
					str_title,
					str_name,
					str_user,
					str_email,
					num_hit,
					num_public,
					to_char(dt_date,'yyyy-mm-dd') dt_date
				FROM ".TAB_PARTY_COUNCIL."
				WHERE 
					num_oid=$_OID AND
                    num_pcode=$pcode AND
					num_mcode=$mcode AND
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
					$whereadd
					AND ROWNUM <= ".($offset + $listnum)." 
				)
			WHERE RNUM > $offset";
	// }}}
}
//echo "<xmp>$sql_total</xmp>";
if(!$total = $DB->sqlFetchOne($sql_total)) $total = 0;
if($data = $DB->sqlFetchAll($sql)) @array_walk($data,'cb_format_list');
$URL->delVar('id','num');

$tpl->define("CONTENT","html/party/council/skin/${skin}/listview.htm");
$tpl->assign(array(
    'env'      => $env,
    'mcode'    => $mcode,
    'LIST'     => &$data,
    'listnum'  => $listnum,
    'total'    => $total,
    'colors'   => $colors
));

// {{{ Functions
function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}

function cb_format_list(&$arr,$key,$param) {
	global $_OID, $env, $total, $offset, $listnum, $dataformat, $search, $search, $URL;
	static $num;
	$arr['num'] = $total - $offset - $num;
	$arr['title'] = cut_str($arr['str_title'], 50);

	// ÷�������� ������� ����Ʈ���� ǥ������� �� ��쿡���� ó��
	if ($arr['num_file'] > 0) $arr['file'] = '��������';
	$arr['bgcolor'] = ($num % 2) ? $env['oddcolor'] : $env['evencolor'];
	$arr['indent'] = str_repeat("��",$arr['num_depth']);
	if ($arr['num_depth'] > 0) $arr['icon'] = 1;
	else $arr['icon'] = 0;

	$arr['date'] = &$arr['dt_date'];
	$arr['hit'] = $arr['num_hit'];
	if ($arr['email']) {
		$arr['name'] = "<a href='mailto:".$arr['str_email']."'>".$arr['str_name']."</a>";
	} else {
		$arr['name'] = $arr['str_name'];
	}

	$arr['public'] = $GLOBALS['publicArr'][$arr['num_public']];

	$arr['readlink'] = $URL->setVar(array(
		'act' => '.read',
		'id'  => $arr['num_serial'],
		'num' => $arr['num']
	));
	$num++;
	if ($search) $arr['title'] = str_replace($search,'<font color="red">'.$search.'</font>',$arr['title']);
}
// }}}
?>