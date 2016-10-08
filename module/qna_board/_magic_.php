<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: modify.php
* 작성일: 2003-05-02
* 작성자: 거친마루
* 설  명: 게시판 글 수정
*****************************************************************/

$DB = &WebApp::singleton('DB');

$upfiles = explode('|',$_POST['upfiles']);
$num_file = count($upfiles);
foreach ($upfiles as $upfile) {
	$sql = "UPDATE $FILE_TABLE SET num_main=$id WHERE num_oid=$_OID AND num_mcode=$mcode AND num_serial=$upfile";
	$DB->query($sql);
}

//==-- 썸네일 생성을 위해 올라간 파일들을 불러와 확장자를 검사한다 --==//
$_up_files = $DB->sqlFetchAll("
	SELECT
		str_refile
	FROM
		$FILE_TABLE 
	WHERE
		num_oid=$_OID AND num_mcode=$mcode AND num_main=$id
");

for ($i=0,$cnt=count($_up_files); $i<$cnt; $i++) {
	if (in_array(strtolower(array_pop(explode('.',$_up_files[$i]['str_refile']))),array('gif','jpg','jpeg','png'))) {
		$_first_image = $_up_files[$i]['str_refile'];
		break;
	}
}

//==-- 썸네일을 만든다 --==//
if ($_first_image) {
	if (strpos($_first_image,'/') !== false) {
		$downfile = $_first_image;
	} else {
		$downfile = "hosts/$HOST/files/board/".$_first_image;
	}
	$_thumb_filename = "thumbnail".basename($downfile);
	$THUMB = &WebApp::singleton('Thumbnail',$downfile);
	$THUMB->ThumbJPEG(100,"hosts/$HOST/files/board/$_thumb_filename");
}
if (!$DB->error) $DB->commit();
if ($DB->query("UPDATE $ARTICLE_TABLE SET num_file=$num_file, str_thumb='$_thumb_filename' WHERE num_oid=$_OID AND num_mcode=$mcode AND num_serial=$id")) $DB->commit();

#### Functions ####
function _format_data(&$arr) {
	global $PERM;
	if ($_SESSION['ADMIN'] == true || $PERM->check('x')) {
		$arr['pass'] = $arr['str_pass'];
	} else 	$arr['str_pass'] = "";
	$arr['use_html_checked'] = ($arr['use_html'] == 1) ? " CHECKED" : "";
	$arr['secret_checked'] = ($arr['secret'] == 1) ? " CHECKED" : "";
	$arr['name'] = &$arr['name'];
	$arr['title'] = strip_tags(&$arr['title']);
	$arr['content'] = $arr['str_text1'].$arr['str_text2'].$arr['str_text3'];
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,4000);
		$str = substr($str,4000);
	}
	return $ret;
}

function new_serial() {
	global $DB;
	$_OID = $_REQUEST['num_oid'];
	$mocde = $_REQUEST['num_mcode'];
	$sql = "
		SELECT
			/*+ INDEX_DESC(TAB_BOARD_FILES IDX_TAB_BOARD_TEMP) */
			num_serial
		FROM
			TAB_BOARD_FILES
		WHERE
			num_oid=$_OID AND num_mcode=$mcode AND ROWNUM=1
	";
	return $DB->sqlFetchOne($sql) + 1;
}

?>
