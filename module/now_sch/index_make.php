<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-02
* 작성자: 김종태
* 설   명: 인덱스 생성기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$sql = "select * from TAB_BOARD ";
$row = $DB -> sqlFetchAll($sql);

//$sqlV = "y";


for($ii=0; $ii<count($row); $ii++) {
	$datas[num_oid] = _OID;
	$datas[str_url] = '/board.read?mcode='.$row[$ii][num_mcode].'&id='.$row[$ii][num_serial];
	$datas[str_type] = 'board';
	$datas[str_title] = strip_tags($row[$ii][str_title]);
	$datas[str_text] = strip_tags($row[$ii][str_text]);
	$datas[num_date] = date("Ymd",$row[$ii][dt_date]);
	$datas[num_hit] = 0;

	$datas['str_location'] = 
		 $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".substr($row[$ii][num_mcode],0,-2))." >".$DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".$row[$ii][num_mcode]);
	$DB->insertQuery($table,$datas);
	$DB->commit();
	
	

	unset($datas[num_hit]);
	$DB->updateQuery($table,$datas," num_oid = "._OID." and str_url = '".$datas[str_url]."'  ");
	$DB->commit();
}


$sql = "select * from TAB_MAIN_BOARD ";
$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {
	$datas[num_oid] = _OID;
	$datas[str_type] = 'news';
	$datas[str_title] = strip_tags($row[$ii][str_title]);
	$datas[str_url] = '/news.read?mcode=1710&code=news&id='.$row[$ii][num_serial];
	$datas[str_text] = strip_tags($row[$ii][str_text]);
	$datas[num_date] = date("Ymd",$row[$ii][dt_date]);
	$datas[num_hit] = 0;

	$DB->insertQuery($table,$datas);
	$DB->commit();
	
	unset($datas[num_hit]);
	$DB->updateQuery($table,$datas," num_oid = "._OID." and str_url = '".$datas[str_url]."' ");
	$DB->commit();
}

echo "인덱스 생성완료";

?>